<?php

namespace App\Livewire\Admin;

use App\Models\DamageReport;
use Livewire\Component;
use Livewire\WithPagination;

class DamageManagement extends Component
{
    use WithPagination;

    public string $search = '';
    public int $perPage = 10;

    public bool $showModal = false;
    public $selectedReport = null;
    public string $status = 'reported';
    public string $admin_response = '';

    public function updatedSearch(): void
    {
        $this->resetPage();
    }

    public function updatedPerPage(): void
    {
        $this->resetPage();
    }

    public function openDetailModal(int $id): void
    {
        $this->selectedReport = DamageReport::with(['user', 'room'])->findOrFail($id);
        $this->status =$this->selectedReport->status;
        $this->admin_response =$this->selectedReport->admin_response ?? '';
        $this->showModal = true;
    }

    public function updateReport(): void
    {
        if (!$this->selectedReport) {
            return;
        }

        $this->selectedReport->update([
            'status' => $this->status,
            'admin_response' => $this->admin_response,
            'resolved_at' => $this->status === 'resolved' ? now() : null,
        ]);

        $this->showModal = false;
        session()->flash('success', "Status laporan kerusakan berhasil diperbarui menjadi {$this->selectedReport->status_label}!");
    }

    public function render()
    {
        $reports = DamageReport::with(['user', 'room'])
            ->when($this->search, function ($query) {
                $query->where(function ($q) {
                    $q->where('facility_name', 'like', "\%{$this->search}%")
                        ->orWhere('description', 'like', "%{$this->search}%")
                        ->orWhereHas('user', fn ($u) => $u->where('name', 'like', "\%{$this->search}%"))
                        ->orWhereHas('room', fn ($r) => $r->where('room_number', 'like', "\%{$this->search}%"));
                });
            })
            ->latest()
            ->paginate($this->perPage);

        return view('livewire.admin.damage-management', compact('reports'))
            ->layout('layouts.tms-admin', ['title' => 'Maintenance Request']);
    }
}