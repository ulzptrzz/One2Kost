<?php

namespace App\Livewire\Admin;

use App\Models\RoomType;
use Illuminate\Support\Facades\DB;
use Livewire\Component;
use Livewire\WithPagination;

class RoomTypeManagement extends Component
{
    use WithPagination;

    public string $search = '';
    public int $perPage = 10;

    public bool $showModal = false;
    public bool $isEdit = false;
    public ?int $typeId = null;
    public string $name = '';
    public string $default_size = '3 x 4 m';
    public string $base_monthly_price = '';
    public string $description = '';
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
        $this->reset(['typeId', 'name', 'base_monthly_price', 'description']);
        $this->default_size = '3 x 4 m';
        $this->is_active = true;
        $this->isEdit = false;
        $this->showModal = true;
    }

    public function openEditModal(int $id): void
    {
        $type = RoomType::findOrFail($id);
        $this->typeId = $type->id;
        $this->name = $type->name;
        $this->default_size = $type->default_size ?? '3 x 4 m';
        $this->base_monthly_price = $type->base_monthly_price ? number_format((float) $type->base_monthly_price, 0, ',', '.') : '';
        $this->description = $type->description ?? '';
        $this->is_active = (bool) $type->is_active;

        $this->isEdit = true;
        $this->showModal = true;
    }

    public function saveRoomType(): void
    {
        $cleanPrice = $this->base_monthly_price !== ''
            ? preg_replace('/\D/', '', $this->base_monthly_price)
            : null;

        $this->validate([
            'name' => 'required|string|max:50|unique:room_types,name,' . $this->typeId,
            'default_size' => 'nullable|string|max:50',
            'description' => 'nullable|string',
        ]);

        $data = [
            'name' => trim($this->name),
            'default_size' => $this->default_size,
            'base_monthly_price' => $cleanPrice ?: null,
            'description' => $this->description,
            'is_active' => $this->is_active,
        ];

        if ($this->isEdit) {
            $type = RoomType::findOrFail($this->typeId);
            $type->update($data);

            session()->flash('success', "Tipe kamar '{$data['name']}' berhasil diperbarui.");
        } else {
            RoomType::create($data);
            session()->flash('success', "Tipe kamar '{$data['name']}' berhasil ditambahkan.");
        }

        $this->showModal = false;
    }

    public function confirmDelete(int $id): void
    {
        $type = RoomType::findOrFail($id);
        $this->deleteId = $type->id;
        $this->deleteLabel = $type->name;
        $this->showDeleteModal = true;
    }

    public function deleteRoomType(): void
    {
        if ($this->deleteId) {
            $type = RoomType::findOrFail($this->deleteId);
            $name = $type->name;
            $type->delete();
            session()->flash('success', "Tipe kamar '{$name}' berhasil dihapus.");
        }

        $this->showDeleteModal = false;
        $this->deleteId = null;
        $this->deleteLabel = '';
    }

    public function render()
    {
        $roomTypes = RoomType::query()
            ->when($this->search, fn ($q) => $q->where('name', 'like', "%{$this->search}%")->orWhere('description', 'like', "%{$this->search}%"))
            ->orderBy('name', 'asc')
            ->paginate($this->perPage);

        // Hitung jumlah kamar per nama tipe kamar lewat join ke room_types
        $roomCounts = DB::table('rooms')
            ->join('room_types', 'rooms.room_type_id', '=', 'room_types.id')
            ->select('room_types.name', DB::raw('count(rooms.id) as total'))
            ->groupBy('room_types.name')
            ->pluck('total', 'name');

        return view('livewire.admin.room-type-management', compact('roomTypes', 'roomCounts'))
            ->layout('layouts.tms-admin', ['title' => 'Tipe Kamar']);
    }
}