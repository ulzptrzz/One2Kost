<?php

namespace App\Livewire;

use App\Models\BankAccount;
use App\Models\Booking;
use App\Models\Room;
use App\Models\RoomType;
use App\Models\Slider;
use Carbon\Carbon;
use Illuminate\Support\Str;
use Livewire\Component;

class LandingPage extends Component
{
    // Filter properties
    public $search = '';
    public $filterType = '';
    public $filterStatus = '';
    public $filterPriceMax = '';

    // Detail Room Modal
    public bool $showRoomDetailModal = false;
    public ?Room $detailRoom = null;

    // Selected Room for booking
    public $selectedRoom = null;
    public $showBookingModal = false;

    // Booking form fields
    public $startDate = '';
    public $durationMonths = 1;
    public $rentalType = 'monthly';
    public $paymentScheme = 'full'; // 'full' or 'dp'
    public $notes = '';

    // Conflict & Waiting list states
    public $hasConflict = false;
    public $conflictMessage = '';
    public $currentOccupantEndDate = '';
    public $isWaitingList = false;
    public $waitingListExplanation = '';

    // Calculated amounts
    public $calculatedEndDate = '';
    public $calculatedTotalPrice = 0;
    public $calculatedDpAmount = 0;
    public $calculatedRemainingAmount = 0;

    // Success State
    public $bookingSuccess = false;
    public $createdBooking = null;

    protected $rules = [
        'startDate' => 'required|date|after_or_equal:today',
        'durationMonths' => 'required|integer|min:1|max:24',
        'paymentScheme' => 'required|in:full,dp',
    ];

    public function mount()
    {
        $this->startDate = Carbon::today()->addDay()->toDateString();
    }

    public function openRoomDetailModal($roomId)
    {
        $this->detailRoom = Room::with(['activeBooking', 'roomType', 'facilityItems'])->findOrFail($roomId);
        $this->showRoomDetailModal = true;
    }

    public function closeRoomDetailModal()
    {
        $this->showRoomDetailModal = false;
        $this->detailRoom = null;
    }

    public function openRoomDetail($roomId)
    {
        $this->openRoomDetailModal($roomId);
    }

    public function closeRoomDetail()
    {
        $this->closeRoomDetailModal();
    }

    public function openDetailModal($roomId)
    {
        $this->openRoomDetailModal($roomId);
    }

    public function closeDetailModal()
    {
        $this->closeRoomDetailModal();
    }

    public function bookFromDetail($roomId)
    {
        $this->showRoomDetailModal = false;
        $this->detailRoom = null;
        $this->openBookingModal($roomId);
    }

    public function openBookingModal($roomId)
    {
        $this->showRoomDetailModal = false;
        $this->selectedRoom = Room::with(['activeBooking', 'roomType'])->findOrFail($roomId);
        $this->showBookingModal = true;
        $this->bookingSuccess = false;
        $this->createdBooking = null;
        $this->calculateSchedule();
    }

    public function closeBookingModal()
    {
        $this->showBookingModal = false;
        $this->selectedRoom = null;
        $this->hasConflict = false;
        $this->isWaitingList = false;
        $this->bookingSuccess = false;
    }

    public function updatedStartDate()
    {
        $this->calculateSchedule();
    }

    public function updatedDurationMonths()
    {
        $this->calculateSchedule();
    }

    public function updatedRentalType()
    {
        $this->calculateSchedule();
    }

    public function updatedPaymentScheme()
    {
        $this->calculateSchedule();
    }

    public function calculateSchedule()
    {
        if (!$this->selectedRoom || !$this->startDate) {
            return;
        }

        try {
            $start = Carbon::parse($this->startDate);
            $months = max(1, (int) $this->durationMonths);
            $end = $start->copy()->addMonths($months);
            $this->calculatedEndDate = $end->format('d M Y');

            // Price calculation
            if ($this->rentalType === 'annual' && $this->selectedRoom->annual_price) {
                $years = ceil($months / 12);
                $this->calculatedTotalPrice = (float) $this->selectedRoom->annual_price * $years;
            } else {
                $this->calculatedTotalPrice = (float) $this->selectedRoom->monthly_price * $months;
            }

            if ($this->paymentScheme === 'dp') {
                $this->calculatedDpAmount = $this->calculatedTotalPrice * 0.5; // DP 50%
                $this->calculatedRemainingAmount = $this->calculatedTotalPrice - $this->calculatedDpAmount;
            } else {
                $this->calculatedDpAmount = 0;
                $this->calculatedRemainingAmount = 0;
            }

            // Real-Time Schedule Overlap & Waiting List Check
            $activeBooking = Booking::where('room_id', $this->selectedRoom->id)
                ->whereIn('status', ['active', 'dp_paid'])
                ->orderBy('end_date', 'desc')
                ->first();

            $this->hasConflict = false;
            $this->isWaitingList = false;
            $this->conflictMessage = '';
            $this->currentOccupantEndDate = '';

            if ($activeBooking) {
                $tenantEnd = Carbon::parse($activeBooking->end_date);
                $this->currentOccupantEndDate = $tenantEnd->format('d F Y');

                if ($start->lte($tenantEnd)) {
                    $this->hasConflict = true;
                    $this->conflictMessage = "PERINGATAN: Kamar {$this->selectedRoom->room_number} masih terisi oleh penghuni saat ini hingga tanggal {$this->currentOccupantEndDate}. Anda tidak dapat memilih tanggal sebelum atau pada periode tersebut. Silakan pilih tanggal mulai sewa setelah tanggal {$this->currentOccupantEndDate}.";
                } else {
                    $this->isWaitingList = true;
                    $this->waitingListExplanation = "PEMBERITAHUAN ANTRIAN: Kamar {$this->selectedRoom->room_number} sedang dihuni hingga {$this->currentOccupantEndDate}. Pengajuan sewa Anda mulai {$start->format('d M Y')} akan dicatat sebagai ANTRIAN (Waiting List) dengan status 'Menunggu Konfirmasi Penghuni Lama'. Pembayaran akan dibuka setelah penghuni lama mengonfirmasi pindah.";
                }
            }
        } catch (\Exception $e) {
            // Silently handle invalid date input
        }
    }

    public function submitBooking()
    {
        if (!auth()->check()) {
            session()->put('intended_room_id', $this->selectedRoom->id);
            return redirect()->route('login')->with('warning', 'Silakan masuk atau daftar akun terlebih dahulu untuk melanjutkan pengajuan sewa kamar.');
        }

        if (auth()->user()->isAdmin()) {
            session()->flash('booking_error', 'Akun Pengelola (Admin) tidak dapat melakukan booking kamar. Gunakan akun penyewa.');
            return;
        }

        $this->validate();

        $this->calculateSchedule();

        if ($this->hasConflict) {
            session()->flash('booking_error', $this->conflictMessage);
            return;
        }

        $start = Carbon::parse($this->startDate);
        $months = max(1, (int) $this->durationMonths);
        $end = $start->copy()->addMonths($months);

        $bookingCode = 'TMS-' . strtoupper(Str::random(3)) . '-' . rand(1000, 9999);
        $initialStatus = $this->isWaitingList ? 'waiting_renewal_confirmation' : 'pending_payment';

        $booking = Booking::create([
            'booking_code' => $bookingCode,
            'user_id' => auth()->id(),
            'room_id' => $this->selectedRoom->id,
            'start_date' => $start->toDateString(),
            'duration_months' => $months,
            'end_date' => $end->toDateString(),
            'rental_type' => $this->rentalType,
            'total_price' => $this->calculatedTotalPrice,
            'payment_scheme' => $this->paymentScheme,
            'dp_amount' => $this->calculatedDpAmount,
            'remaining_amount' => $this->calculatedRemainingAmount,
            'status' => $initialStatus,
            'renewal_status' => 'pending',
            'notes' => $this->notes,
        ]);

        $this->createdBooking = $booking;
        $this->bookingSuccess = true;
    }

    public function render()
    {
        $sliders = Slider::active()->get();
        $bankAccounts = BankAccount::active()->get();

        $query = Room::query();

        if ($this->search) {
            $query->where(function ($q) {
                $q->where('name', 'like', '%' . $this->search . '%')
                    ->orWhere('room_number', 'like', '%' . $this->search . '%')
                    ->orWhereHas('roomType', function ($rt) {
                        $rt->where('name', 'like', '%' . $this->search . '%');
                    });
            });
        }

        if ($this->filterType) {
            $query->whereHas('roomType', function ($rt) {
                $rt->where('name', $this->filterType);
            });
        }

        if ($this->filterStatus) {
            $query->where('status', $this->filterStatus);
        }

        if ($this->filterPriceMax) {
            $query->where('monthly_price', '<=', (float) $this->filterPriceMax);
        }

        $rooms = $query->with(['activeBooking', 'roomType', 'facilityItems'])
            ->orderBy('room_number', 'asc')
            ->get();

        $roomTypes = RoomType::where('is_active', true)
            ->orderBy('name')
            ->pluck('name');

        return view('livewire.landing-page', compact('sliders', 'bankAccounts', 'rooms', 'roomTypes'))
            ->layout('layouts.tms-public', ['title' => 'Sistem Informasi Kost Modern']);
    }
}