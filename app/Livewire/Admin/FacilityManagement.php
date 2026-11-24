<?php

namespace App\Livewire\Admin;

use App\Models\Facility;
use Illuminate\Support\Facades\DB;
use Livewire\Component;
use Livewire\WithPagination;

class FacilityManagement extends Component
{
    use WithPagination;

    public string $search = '';
    public int $perPage = 10;

    public bool $showModal = false;
    public bool $isEdit = false;
    public ?int $facilityId = null;
    public string $name = '';
    public string $category = 'Furnitur';
    public bool $is_active = true;

    public bool $showDeleteModal = false;
    public ?int $deleteId = null;
    public string $deleteLabel = '';

    public function updatedSearch(): void
    {
        $this->resetPage();
    }

    public function updatedPerPage(): void
    {
        $this->resetPage();
    }

    public function openCreateModal(): void
    {
        $this->reset(['facilityId', 'name']);
        $this->category = 'Furnitur';
        $this->is_active = true;
        $this->isEdit = false;
        $this->showModal = true;
    }

    public function openEditModal(int $id): void
    {
        $facility = Facility::findOrFail($id);
        $this->facilityId = $facility->id;
        $this->name = $facility->name;
        $this->category = $facility->category ?? 'Umum';
        $this->is_active = (bool) $facility->is_active;

        $this->isEdit = true;
        $this->showModal = true;
    }

    public function saveFacility(): void
    {
        $this->validate([
            'name' => 'required|string|max:100|unique:facilities,name,' . $this->facilityId,
            'category' => 'nullable|string|max:50',
        ]);

        $newName = trim($this->name);

        if ($this->isEdit) {
            $facility = Facility::findOrFail($this->facilityId);
            $facility->update([
                'name' => $newName,
                'category' => $this->category,
                'is_active' => $this->is_active,
            ]);

            session()->flash('success', "Fasilitas '{$newName}' berhasil diperbarui.");
        } else {
            Facility::create([
                'name' => $newName,
                'category' => $this->category,
                'is_active' => $this->is_active,
            ]);

            session()->flash('success', "Fasilitas '{$newName}' berhasil ditambahkan.");
        }

        $this->showModal = false;
    }

    public function confirmDelete(int $id): void
    {
        $facility = Facility::findOrFail($id);
        $this->deleteId = $facility->id;
        $this->deleteLabel = $facility->name;
        $this->showDeleteModal = true;
    }

    public function deleteFacility(): void
    {
        if ($this->deleteId) {
            $facility = Facility::findOrFail($this->deleteId);
            $name = $facility->name;
            $facility->delete();
            session()->flash('success', "Fasilitas '{$name}' berhasil dihapus.");
        }

        $this->showDeleteModal = false;
        $this->deleteId = null;
        $this->deleteLabel = '';
    }

    public function render()
    {
        $facilities = Facility::query()
            ->when($this->search, fn ($q) => $q->where('name', 'like', "%{$this->search}%")->orWhere('category', 'like', "%{$this->search}%"))
            ->orderBy('name', 'asc')
            ->paginate($this->perPage);

        // Hitung jumlah kamar per nama fasilitas lewat tabel pivot facility_room
        $roomCounts = DB::table('facility_room')
            ->join('facilities', 'facility_room.facility_id', '=', 'facilities.id')
            ->select('facilities.name', DB::raw('count(facility_room.room_id) as total'))
            ->groupBy('facilities.name')
            ->pluck('total', 'name');

        return view('livewire.admin.facility-management', compact('facilities', 'roomCounts'))
            ->layout('layouts.tms-admin', ['title' => 'Fasilitas Kamar']);
    }
}