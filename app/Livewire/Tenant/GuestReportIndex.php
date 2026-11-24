<?php

namespace App\Livewire\Tenant;

use App\Models\Booking;
use App\Models\GuestReport;
use Carbon\Carbon;
use Livewire\Component;

class GuestReportIndex extends Component
{
    public $showCreateModal = false;

    // Form fields
    public $guestName = '';
    public $relationship = 'Teman';
    public $visitDate = '';
    public $visitTime = '';
    public $duration = '2 Jam';
    public $purpose = '';
    public $guestPhone = '';

    protected $rules = [
        'guestName' => 'required|string|max:100',
        'relationship' => 'required|string|max:50',
        'visitDate' => 'required|date',
        'visitTime' => 'required|string',
        'duration' => 'required|string|max:50',
        'purpose' => 'required|string|min:5',
        'guestPhone' => 'nullable|string|max:20',
    ];

    public function mount()
    {
        $this->visitDate = Carbon::today()->toDateString();
        $this->visitTime = '19:00 WIB';
    }

    public function openCreateModal()
    {
        $this->reset(['guestName', 'purpose', 'guestPhone']);
        $this->visitDate = Carbon::today()->toDateString();
        $this->visitTime = '19:00 WIB';
        $this->relationship = 'Teman';
        $this->duration = '2 Jam';
        $this->showCreateModal = true;
    }

    public function submitGuestReport()
    {
        $this->validate();

        $user = auth()->user();
        $activeBooking = Booking::where('user_id', $user->id)
            ->whereIn('status', ['active', 'dp_paid'])
            ->first();

        GuestReport::create([
            'user_id' => $user->id,
            'room_id' => $activeBooking ? $activeBooking->room_id : null,
            'guest_name' => $this->guestName,
            'relationship' => $this->relationship,
            'visit_date' => $this->visitDate,
            'visit_time' => $this->visitTime,
            'duration' => $this->duration,
            'purpose' => $this->purpose,
            'guest_phone' => $this->guestPhone,
            'status' => 'recorded',
        ]);

        $this->showCreateModal = false;
        $this->reset(['guestName', 'purpose', 'guestPhone']);

        session()->flash('success', 'Laporan kunjungan tamu berhasil dicatat ke sistem!');
    }

    public function render()
    {
        $reports = GuestReport::with('room')
            ->where('user_id', auth()->id())
            ->latest()
            ->paginate(10);

        return view('livewire.tenant.guest-report-index', compact('reports'))
            ->layout('layouts.tms-tenant', ['title' => 'Laporan Kunjungan Tamu']);
    }
}
