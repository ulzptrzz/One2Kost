<?php

namespace App\Livewire\Admin;

use App\Models\Booking;
use Livewire\Component;
use Livewire\WithPagination;

class TenantManagement extends Component
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

    public function updateRenewalStatus(int $bookingId, string$status): void
    {
        $booking = Booking::with('room')->findOrFail($bookingId);
        $booking->update(['renewal_status' =>$status]);

        if ($booking->room) {
            if ($status === 'renewing') {$booking->room->update(['status' => 'occupied']);
                session()->flash('success', "Penghuni kamar {$booking->room->room_number} ditandai: Akan Memperpanjang.");
            } elseif ($status === 'moving_out') {$booking->room->update(['status' => 'pending_renewal']);
                session()->flash('success', "Penghuni kamar {$booking->room->room_number} ditandai: Pindah / Checkout.");
            }
        }
    }

    public function render()
    {
        $activeBookings = Booking::with(['user', 'room'])
            ->whereNotIn('status', [
                'cancelled',
                'rejected',
                'expired',
                'completed',
                'waiting_renewal_confirmation',
                'waiting_confirmation',
                'pending',
            ])
            ->where(function ($q) {
                $q->whereIn('status', ['active', 'dp_paid', 'paid', 'confirmed', 'approved', 'dp', 'occupied'])
                  ->orWhereHas('room', fn ($r) => $r->whereIn('status', ['occupied', 'pending_renewal']));
            })
            ->when($this->search, function ($query) {
                $query->where(function ($q) {
                    $q->whereHas('user', function ($u) {
                        $u->where('name', 'like', "%{$this->search}%")
                          ->orWhere('email', 'like', "%{$this->search}%");
                    })->orWhereHas('room', function ($r) {
                        $r->where('room_number', 'like', "%{$this->search}%");
                    });
                });
            })
            ->latest()
            ->paginate($this->perPage);

        return view('livewire.admin.tenant-management', compact('activeBookings'))
            ->layout('layouts.tms-admin', ['title' => 'Penghuni Aktif & Masa Sewa']);
    }
}