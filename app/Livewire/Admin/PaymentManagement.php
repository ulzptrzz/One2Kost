<?php

namespace App\Livewire\Admin;

use App\Models\Payment;
use Carbon\Carbon;
use Livewire\Component;
use Livewire\WithPagination;

class PaymentManagement extends Component
{
    use WithPagination;

    public string $search = '';
    public int $perPage = 10;

    // Verification modal state
    public bool $showVerifyModal = false;
    public $selectedPayment = null;
    public string $adminNotes = '';

    public function updatedSearch(): void
    {
        $this->resetPage();
    }

    public function updatedPerPage(): void
    {
        $this->resetPage();
    }

    public function openVerifyModal(int $paymentId): void
    {
        $this->selectedPayment = Payment::with(['booking.room', 'user', 'bankAccount'])->findOrFail($paymentId);
        $this->adminNotes = $this->selectedPayment->admin_notes ?? '';
        $this->showVerifyModal = true;
    }

    public function approvePayment(): void
    {
        if (!$this->selectedPayment) {
            return;
        }

        $payment = $this->selectedPayment;
        $booking = $payment->booking;

        $payment->update([
            'status' => 'approved',
            'admin_notes' => $this->adminNotes ?: 'Pembayaran telah diverifikasi oleh pengelola.',
            'verified_at' => now(),
            'verified_by' => auth()->id(),
        ]);

        if ($payment->payment_type === 'dp') {
            $booking->update(['status' => 'dp_paid']);
            $booking->room->update(['status' => 'occupied']);
        } elseif (in_array($payment->payment_type, ['settlement', 'full'])) {
            $booking->update([
                'status' => 'active',
                'remaining_amount' => 0,
            ]);
            $booking->room->update(['status' => 'occupied']);
        }

        $this->showVerifyModal = false;
        session()->flash('success', "Pembayaran sebesar {$payment->formatted_amount} berhasil disetujui & diverifikasi.");
    }

    public function rejectPayment(): void
    {
        if (!$this->selectedPayment) {
            return;
        }

        $this->validate([
            'adminNotes' => 'required|string|min:5',
        ], [
            'adminNotes.required' => 'Wajib menyertakan alasan penolakan pembayaran agar penyewa mengetahui kendalanya.',
        ]);

        $payment = $this->selectedPayment;

        $payment->update([
            'status' => 'rejected',
            'admin_notes' => $this->adminNotes,
            'verified_at' => now(),
            'verified_by' => auth()->id(),
        ]);

        if ($payment->booking->status === 'payment_under_review') {
            $payment->booking->update(['status' => 'pending_payment']);
        }

        $this->showVerifyModal = false;
        session()->flash('success', "Pembayaran telah ditolak dengan catatan: {$this->adminNotes}");
    }

    public function render()
    {
        $payments = Payment::with(['booking.room', 'user', 'bankAccount'])
            ->when($this->search, function ($query) {
                $query->where(function ($q) {
                    $q->where('sender_name', 'like', "%{$this->search}%")
                        ->orWhere('sender_bank', 'like', "%{$this->search}%")
                        ->orWhereHas('user', fn ($u) => $u->where('name', 'like', "%{$this->search}%"))
                        ->orWhereHas('booking', function ($b) {
                            $b->where('booking_code', 'like', "%{$this->search}%")
                              ->orWhereHas('room', fn ($r) => $r->where('room_number', 'like', "%{$this->search}%"));
                        });
                });
            })
            ->latest()
            ->paginate($this->perPage);

        $totalApprovedRevenue = Payment::where('status', 'approved')->sum('amount');
        $thisMonthApprovedRevenue = Payment::where('status', 'approved')
            ->whereMonth('payment_date', Carbon::now()->month)
            ->whereYear('payment_date', Carbon::now()->year)
            ->sum('amount');
        $totalPendingCount = Payment::where('status', 'pending')->count();

        return view('livewire.admin.payment-management', compact(
            'payments',
            'totalApprovedRevenue',
            'thisMonthApprovedRevenue',
            'totalPendingCount'
        ))->layout('layouts.tms-admin', ['title' => 'Invoices & Verifikasi Pembayaran']);
    }
}