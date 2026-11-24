<?php

namespace App\Livewire\Admin;

use App\Models\GuestReport;
use Livewire\Component;
use Livewire\WithPagination;

class GuestManagement extends Component
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

    public function acknowledge(int $id): void
    {
        $guest = GuestReport::findOrFail($id);
        $guest->update(['status' => 'acknowledged']);
        session()->flash('success', "Laporan kunjungan tamu atas nama {$guest->guest_name} telah dikonfirmasi.");
    }

    public function render()
    {
        $guests = GuestReport::with(['user', 'room'])
            ->when($this->search, function ($query) {
                $query->where(function ($q) {
                    $q->where('guest_name', 'like', "%{$this->search}%")
                        ->orWhere('relationship', 'like', "%{$this->search}%")
                        ->orWhere('purpose', 'like', "%{$this->search}%")
                        ->orWhereHas('user', fn ($u) => $u->where('name', 'like', "%{$this->search}%"))
                        ->orWhereHas('room', fn ($r) => $r->where('room_number', 'like', "%{$this->search}%"));
                });
            })
            ->latest()
            ->paginate($this->perPage);

        return view('livewire.admin.guest-management', compact('guests'))
            ->layout('layouts.tms-admin', ['title' => 'Guest Visit Log']);
    }
}