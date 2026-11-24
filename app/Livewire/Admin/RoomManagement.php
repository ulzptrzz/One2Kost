<?php

namespace App\Livewire\Admin;

use App\Models\Facility;
use App\Models\Room;
use App\Models\RoomType;
use App\Services\FileUploadService;
use Livewire\Component;
use Livewire\WithFileUploads;
use Livewire\WithPagination;

class RoomManagement extends Component
{
    use WithPagination, WithFileUploads;

    // Filters & Pagination
    public $search = '';
    public $filterType = '';
    public $filterStatus = '';
    public $perPage = 10;

    // Modal states
    public $showModal = false;
    public $isEdit = false;
    public $selectedRoomId = null;

    public $showDetailModal = false;
    public ?Room $detailRoom = null;

    public $showDeleteModal = false;
    public ?int $deleteRoomId = null;
    public string $deleteRoomLabel = '';

    // Form fields
    public $room_number = '';
    public $name = '';
    public $room_type = '';
    public $floor = 1;
    public $monthly_price = '';
    public $annual_price = '';
    public $size = '3 x 4 m';
    public $description = '';
    public $facilities = [];
    public $newFacility = '';
    public $status = 'available';

    // Multiple images
    public $imageFiles = [];
    public array $existingImages = [];

    public array $defaultFacilities = [
        'AC',
        'WiFi Cepat',
        'Kamar Mandi Dalam',
        'Water Heater',
        'Kasur Springbed',
        'Kasur Queen Size',
        'Kasur King Size',
        'Lemari Pakaian',
        'Meja & Kursi Kerja',
        'Smart TV',
        'Kulkas Mini',
        'Balkon Pribadi',
        'Jendela Luar',
        'Dapur Bersama',
        'Parkir Mobil/Motor',
        'Cleaning Service Berkala',
    ];

    public array $allFacilities = [];

    public function mount()
    {
        $this->loadMasterFacilities();
    }

    protected function loadMasterFacilities(): void
    {
        $dbFacilities = Facility::where('is_active', true)
            ->orderBy('name')
            ->pluck('name')
            ->toArray();

        $baseList = !empty($dbFacilities) ? $dbFacilities : $this->defaultFacilities;

        $this->allFacilities = array_values(array_unique(array_merge(
            $baseList,
            is_array($this->facilities) ? $this->facilities : []
        )));
    }

    public function syncRoomFacilities(): void
    {
        $this->loadMasterFacilities();
    }

    public function updatedRoomType($value): void
    {
        if (!$this->isEdit && $value) {
            $type = RoomType::where('name', $value)->first();
            if ($type) {
                if ($type->default_size) {
                    $this->size = $type->default_size;
                }
                if ($type->base_monthly_price && !$this->monthly_price) {
                    $this->monthly_price = number_format((float) $type->base_monthly_price, 0, ',', '.');
                }
            }
        }
    }

    public function addCustomFacility(): void
    {
        $facility = trim((string) $this->newFacility);

        if ($facility === '') {
            return;
        }

        // Simpan ke master tabel facilities jika belum ada agar bisa direlasikan ke pivot
        $facilityModel = Facility::whereRaw('LOWER(name) = ?', [mb_strtolower($facility)])->first();

        if (!$facilityModel) {
            $facilityModel = Facility::create([
                'name' => $facility,
                'category' => 'Umum',
                'is_active' => true,
            ]);
        }

        $finalName = $facilityModel->name;

        if (!in_array($finalName, $this->allFacilities, true)) {
            $this->allFacilities[] = $finalName;
        }

        if (!in_array($finalName, $this->facilities, true)) {
            $this->facilities[] = $finalName;
        }

        $this->newFacility = '';
    }

    public function updatedSearch()
    {
        $this->resetPage();
    }

    public function updatedPerPage()
    {
        $this->resetPage();
    }

    protected function rules()
    {
        return [
            'room_number' => 'required|string|max:20|unique:rooms,room_number,' . $this->selectedRoomId,
            'name' => 'required|string|max:100',
            'room_type' => 'required|string|max:50',
            'floor' => 'required|integer|min:1',
            'monthly_price' => 'required|numeric|min:100000',
            'annual_price' => 'nullable|numeric|min:100000',
            'size' => 'required|string|max:50',
            'description' => 'nullable|string',
            'facilities' => 'nullable|array',
            'status' => 'required|in:available,occupied,pending_renewal',
            'imageFiles.*' => 'nullable|image|max:5120',
        ];
    }

    public function openDetailModal($id)
    {
        $this->detailRoom = Room::with(['roomType', 'facilityItems'])->findOrFail($id);
        $this->showDetailModal = true;
    }

    public function openCreateModal()
    {
        $this->reset([
            'selectedRoomId', 'room_number', 'name', 'room_type', 'floor',
            'monthly_price', 'annual_price', 'size', 'description', 'facilities',
            'newFacility', 'status', 'imageFiles', 'existingImages'
        ]);

        $defaultType = RoomType::where('is_active', true)->orderBy('name')->first();

        $this->room_type = $defaultType?->name ?? 'Standard';
        $this->floor = 1;
        $this->size = $defaultType?->default_size ?: '3 x 4 m';
        $this->monthly_price = $defaultType?->base_monthly_price
            ? number_format((float) $defaultType->base_monthly_price, 0, ',', '.')
            : '';
        $this->status = 'available';
        $this->facilities = [];

        $this->syncRoomFacilities();
        $this->isEdit = false;
        $this->showModal = true;
    }

    public function openEditModal($id)
    {
        $this->showDetailModal = false;

        $room = Room::with(['roomType', 'facilityItems'])->findOrFail($id);
        $this->selectedRoomId = $room->id;
        $this->room_number = $room->room_number;
        $this->name = $room->name;
        $this->room_type = $room->roomType?->name ?? '';
        $this->floor = $room->floor;
        $this->monthly_price = number_format((float) $room->monthly_price, 0, ',', '.');
        $this->annual_price = $room->annual_price ? number_format((float) $room->annual_price, 0, ',', '.') : '';
        $this->size = $room->size;
        $this->description = $room->description;
        $this->facilities = $room->facilityItems->pluck('name')->toArray();
        $this->newFacility = '';
        $this->status = $room->status;

        $this->syncRoomFacilities();

        $imgs = [];
        if ($room->main_image) {
            $imgs[] = $room->main_image;
        }
        if (is_array($room->images)) {
            foreach ($room->images as $g) {
                if ($g && !in_array($g, $imgs)) {
                    $imgs[] = $g;
                }
            }
        }
        $this->existingImages = $imgs;
        $this->imageFiles = [];

        $this->isEdit = true;
        $this->showModal = true;
    }

    public function removeExistingImage(int $index)
    {
        if (isset($this->existingImages[$index])) {
            unset($this->existingImages[$index]);
            $this->existingImages = array_values($this->existingImages);
        }
    }

    public function saveRoom()
    {
        if (trim((string) $this->newFacility) !== '') {
            $this->addCustomFacility();
        }

        $this->monthly_price = preg_replace('/\D/', '', (string) $this->monthly_price);
        $this->annual_price = $this->annual_price !== '' && $this->annual_price !== null
            ? preg_replace('/\D/', '', (string) $this->annual_price)
            : '';

        $this->validate();

        $allImages = $this->existingImages;

        if (!empty($this->imageFiles)) {
            foreach ($this->imageFiles as $file) {
                $allImages[] = FileUploadService::upload($file, 'rooms');
            }
        }

        $mainImage = $allImages[0] ?? null;

        // Cari atau buat master tipe kamar agar mendapatkan room_type_id
        $roomTypeModel = RoomType::firstOrCreate(
            ['name' => $this->room_type],
            [
                'default_size' => $this->size,
                'base_monthly_price' => $this->monthly_price,
                'is_active' => true,
            ]
        );

        $data = [
            'room_number' => $this->room_number,
            'name' => $this->name,
            'room_type_id' => $roomTypeModel->id,
            'floor' => $this->floor,
            'monthly_price' => $this->monthly_price,
            'annual_price' => $this->annual_price ?: null,
            'size' => $this->size,
            'description' => $this->description,
            'status' => $this->status,
            'main_image' => $mainImage,
            'images' => $allImages,
        ];

        if ($this->isEdit) {
            $room = Room::findOrFail($this->selectedRoomId);
            $room->update($data);
            $message = "Kamar {$room->room_number} berhasil diperbarui!";
        } else {
            $room = Room::create($data);
            $message = "Kamar {$room->room_number} baru berhasil ditambahkan!";
        }

        // Sinkronisasi checklist fasilitas ke tabel pivot facility_room
        $facilityIds = [];
        foreach (array_unique($this->facilities) as $facName) {
            $facModel = Facility::firstOrCreate(
                ['name' => $facName],
                ['category' => 'Umum', 'is_active' => true]
            );
            $facilityIds[] = $facModel->id;
        }
        $room->facilityItems()->sync($facilityIds);

        session()->flash('success', $message);
        $this->showModal = false;
    }

    public function confirmDelete($id)
    {
        $room = Room::findOrFail($id);
        $this->deleteRoomId = $room->id;
        $this->deleteRoomLabel = "{$room->room_number} ({$room->name})";
        $this->showDeleteModal = true;
    }

    public function deleteRoom()
    {
        if ($this->deleteRoomId) {
            $room = Room::findOrFail($this->deleteRoomId);
            $roomNumber = $room->room_number;
            $room->delete();
            session()->flash('success', "Kamar {$roomNumber} berhasil dihapus.");
        }

        $this->showDeleteModal = false;
        $this->deleteRoomId = null;
        $this->deleteRoomLabel = '';
    }

    public function render()
    {
        $query = Room::with(['roomType', 'facilityItems']);

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

        $rooms = $query->orderBy('room_number', 'asc')->paginate((int) $this->perPage);

        $availableRoomTypes = RoomType::where('is_active', true)
            ->orderBy('name')
            ->pluck('name')
            ->toArray();

        $roomTypes = $availableRoomTypes;

        return view('livewire.admin.room-management', compact('rooms', 'roomTypes', 'availableRoomTypes'))
            ->layout('layouts.tms-admin', ['title' => 'Manajemen Kamar & Fasilitas']);
    }
}