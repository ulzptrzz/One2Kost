<?php

namespace App\Livewire\Tenant;

use App\Models\Booking;
use App\Models\DamageReport;
use App\Services\FileUploadService;
use Livewire\Component;
use Livewire\WithFileUploads;

class DamageReportIndex extends Component
{
    use WithFileUploads;

    public $showCreateModal = false;

    // Form fields
    public $facilityName = '';
    public $description = '';
    public $photo;

    protected $rules = [
        'facilityName' => 'required|string|max:100',
        'description' => 'required|string|min:10',
        'photo' => 'nullable|image|max:5120',
    ];

    public function openCreateModal()
    {
        $this->reset(['facilityName', 'description', 'photo']);
        $this->showCreateModal = true;
    }

    public function submitDamageReport()
    {
        $this->validate();

        $user = auth()->user();
        $activeBooking = Booking::where('user_id', $user->id)
            ->whereIn('status', ['active', 'dp_paid'])
            ->first();

        $photoPath = null;
        if ($this->photo) {
            // Save directly into public/uploads/damages/
            $photoPath = FileUploadService::upload($this->photo, 'damages');
        }

        DamageReport::create([
            'user_id' => $user->id,
            'room_id' => $activeBooking ? $activeBooking->room_id : null,
            'facility_name' => $this->facilityName,
            'description' => $this->description,
            'photo' => $photoPath,
            'status' => 'reported',
        ]);

        $this->showCreateModal = false;
        $this->reset(['facilityName', 'description', 'photo']);

        session()->flash('success', 'Laporan kerusakan fasilitas berhasil dikirim! Pengelola akan segera menindaklanjuti.');
    }

    public function render()
    {
        $reports = DamageReport::with('room')
            ->where('user_id', auth()->id())
            ->latest()
            ->paginate(10);

        return view('livewire.tenant.damage-report-index', compact('reports'))
            ->layout('layouts.tms-tenant', ['title' => 'Laporan Kerusakan Fasilitas']);
    }
}
