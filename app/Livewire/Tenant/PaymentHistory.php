<?php

namespace App\Livewire\Tenant;

use App\Models\BankAccount;
use App\Models\Booking;
use App\Models\Payment;
use App\Services\FileUploadService;
use Carbon\Carbon;
use Livewire\Component;
use Livewire\WithFileUploads;
use Livewire\WithPagination;

class PaymentHistory extends Component
{
    use WithFileUploads, WithPagination;

    // Modal state
    public $showUploadModal = false;
    public $selectedBookingId = null;

    // Form fields
    public $bankAccountId = '';
    public $paymentType = 'full'; // 'dp', 'full', 'settlement'
    public $amount = 0;
    public $paymentDate = '';
    public $senderName = '';
    public $senderBank = '';
    public $proofImage;

    protected $rules = [
        'selectedBookingId' => 'required|exists:bookings,id',
        'bankAccountId' => 'required|exists:bank_accounts,id',
        'paymentType' => 'required|in:dp,full,settlement',
        'amount' => 'required|numeric|min:1000',
        'paymentDate' => 'required|date',
        'senderName' => 'required|string|max:100',
        'senderBank' => 'required|string|max:50',
        'proofImage' => 'required|image|max:5120', // 5MB max
    ];

    public function mount()
    {
        $this->paymentDate = Carbon::today()->toDateString();
    }

    public function openUploadModal($bookingId = null, $type = 'full')
    {
        $user = auth()->user();
        $this->reset(['proofImage', 'senderName', 'senderBank']);
        $this->paymentDate = Carbon::today()->toDateString();

        $activeBank = BankAccount::active()->first();
        $this->bankAccountId = $activeBank ? $activeBank->id : '';

        if ($bookingId) {
            $booking = Booking::where('id', $bookingId)->where('user_id', $user->id)->firstOrFail();
            $this->selectedBookingId = $booking->id;
            $this->paymentType = $type;

            if ($type === 'settlement') {
                $this->amount = (float) $booking->remaining_amount;
            } elseif ($type === 'dp') {
                $this->amount = (float) ($booking->dp_amount > 0 ? $booking->dp_amount : ($booking->total_price * 0.5));
            } else {
                $this->amount = (float) $booking->total_price;
            }
        } else {
            // Pick first booking needing payment
            $booking = Booking::where('user_id', $user->id)
                ->whereIn('status', ['pending_payment', 'dp_paid'])
                ->first();

            if ($booking) {
                $this->selectedBookingId = $booking->id;
                if ($booking->status === 'dp_paid') {
                    $this->paymentType = 'settlement';
                    $this->amount = (float) $booking->remaining_amount;
                } else {
                    $this->paymentType = $booking->payment_scheme === 'dp' ? 'dp' : 'full';
                    $this->amount = $this->paymentType === 'dp'
                        ? (float) ($booking->dp_amount > 0 ? $booking->dp_amount : ($booking->total_price * 0.5))
                        : (float) $booking->total_price;
                }
            }
        }

        $this->showUploadModal = true;
    }

    public function updatedSelectedBookingId()
    {
        $booking = Booking::where('id', $this->selectedBookingId)->where('user_id', auth()->id())->first();
        if ($booking) {
            if ($this->paymentType === 'settlement') {
                $this->amount = (float) $booking->remaining_amount;
            } elseif ($this->paymentType === 'dp') {
                $this->amount = (float) ($booking->dp_amount > 0 ? $booking->dp_amount : ($booking->total_price * 0.5));
            } else {
                $this->amount = (float) $booking->total_price;
            }
        }
    }

    public function updatedPaymentType()
    {
        $this->updatedSelectedBookingId();
    }

    public function submitPayment()
    {
        $this->validate();

        $booking = Booking::where('id', $this->selectedBookingId)->where('user_id', auth()->id())->firstOrFail();

        // Save file directly to public/uploads/payments/...
        $imagePath = FileUploadService::upload($this->proofImage, 'payments');

        // Check if an existing payment record without proof image exists
        $existingPayment = Payment::where('booking_id', $booking->id)
            ->where('payment_type', $this->paymentType)
            ->whereNull('proof_image')
            ->first();

        if ($existingPayment) {
            $existingPayment->update([
                'bank_account_id' => $this->bankAccountId,
                'amount' => $this->amount,
                'payment_date' => $this->paymentDate,
                'proof_image' => $imagePath,
                'sender_name' => $this->senderName,
                'sender_bank' => $this->senderBank,
                'status' => 'pending', // Menunggu verifikasi (Diproses)
            ]);
        } else {
            Payment::create([
                'booking_id' => $booking->id,
                'user_id' => auth()->id(),
                'bank_account_id' => $this->bankAccountId,
                'payment_type' => $this->paymentType,
                'amount' => $this->amount,
                'payment_date' => $this->paymentDate,
                'proof_image' => $imagePath,
                'sender_name' => $this->senderName,
                'sender_bank' => $this->senderBank,
                'status' => 'pending', // Menunggu Verifikasi (Diproses)
            ]);
        }

        // Update booking status to payment_under_review if it was pending_payment
        if ($booking->status === 'pending_payment') {
            $booking->update(['status' => 'payment_under_review']);
        }

        $this->showUploadModal = false;
        $this->reset(['proofImage', 'senderName', 'senderBank', 'amount']);

        session()->flash('success', 'Bukti pembayaran berhasil diunggah! Status pembayaran kini "Menunggu Verifikasi" dari Pengelola Kost.');
    }

    public function confirmRenewal($bookingId, $status)
    {
        $booking = Booking::where('id', $bookingId)
            ->where('user_id', auth()->id())
            ->firstOrFail();

        if (in_array($status, ['renewing', 'moving_out'])) {
            $booking->update(['renewal_status' => $status]);
            session()->flash('renewal_message', $status === 'renewing'
                ? 'Terima kasih! Konfirmasi perpanjangan sewa Anda telah dicatat.'
                : 'Informasi rencana pindah Anda telah dicatat untuk penjadwalan pengelola.');
        }
    }

    public function render()
    {
        $user = auth()->user();

        // Kamar & masa sewa aktif penyewa
        $activeBooking = Booking::with('room')
            ->where('user_id', $user->id)
            ->whereIn('status', ['active', 'approved'])
            ->latest()
            ->first();

        // Tagihan DP yang belum dilunasi
        $dpBookingPendingSettlement = Booking::with('room')
            ->where('user_id', $user->id)
            ->where('payment_scheme', 'dp')
            ->whereIn('status', ['dp_paid', 'approved'])
            ->first();

        // Daftar pengajuan sewa & antrian (waiting list)
        $waitingBookings = Booking::with('room')
            ->where('user_id', $user->id)
            ->whereIn('status', ['pending_payment', 'payment_under_review', 'waiting_verification', 'waiting_renewal_confirmation'])
            ->latest()
            ->get();

        // Tenant Bookings that can receive payment
        $payableBookings = Booking::with('room')
            ->where('user_id', $user->id)
            ->whereIn('status', ['pending_payment', 'dp_paid', 'payment_under_review'])
            ->get();

        $payments = Payment::with(['booking.room', 'bankAccount'])
            ->where('user_id', $user->id)
            ->latest()
            ->paginate(10);

        $bankAccounts = BankAccount::active()->get();

        return view('livewire.tenant.payment-history', compact(
            'activeBooking',
            'dpBookingPendingSettlement',
            'waitingBookings',
            'payableBookings',
            'payments',
            'bankAccounts'
        ))->layout('layouts.tms-tenant', ['title' => 'Riwayat Sewa & Bukti Pembayaran']);
    }
}