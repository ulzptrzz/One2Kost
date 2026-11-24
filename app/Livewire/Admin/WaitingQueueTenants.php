<?php

namespace App\Livewire\Admin;

use App\Models\Booking;
use Livewire\Component;
use Livewire\WithPagination;

class WaitingQueueTenants extends Component
{
    use WithPagination;

    public string $search = '';
    public int $perPage = 10;

    public function updatedSearch(): void
    {
        $this->resetPage();
    }

    public function updatedPerPage(): void
    {
        $this->resetPage();
    }

    public function approveQueueBooking(int $bookingId): void
    {
        $booking = Booking::with(['room', 'user'])->findOrFail($bookingId);
        $booking->update(['status' => 'pending_payment']);

        session()->flash('success', "Antrian {$booking->user->name} untuk Kamar {$booking->room->room_number} berhasil disetujui.");
    }

    public function cancelBooking(int $bookingId): void
    {
        $booking = Booking::findOrFail($bookingId);
        $booking->update(['status' => 'cancelled']);

        session()->flash('success', 'Pengajuan antrian telah dibatalkan.');
    }

   public function render()
    {
        $waitingBookings = Booking::with(['user', 'room'])
            ->whereIn('status', [
                'waiting_renewal_confirmation',
                'waiting_confirmation',
                'pending',
                'waiting',
                'booked',
                'new',
            ])
            ->when($this->search, function ($query) {
                $query->where(function ($q) {
                    $q->whereHas('user', fn ($u) => $u->where('name', 'like', "%{$this->search}%"))
                      ->orWhereHas('room', fn ($r) => $r->where('room_number', 'like', "%{$this->search}%"))
                      ->orWhere('booking_code', 'like', "%{$this->search}%");
                });
            })
            ->latest()
            ->paginate($this->perPage);

        return view('livewire.admin.waiting-queue-tenants', compact('waitingBookings'))
            ->layout('layouts.tms-admin', ['title' => 'Antrian Calon Penyewa']);
    }
}