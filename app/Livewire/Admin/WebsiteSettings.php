<?php

namespace App\Livewire\Admin;

use App\Models\Slider;
use App\Services\FileUploadService;
use Livewire\Component;
use Livewire\WithFileUploads;
use Livewire\WithPagination;

class WebsiteSettings extends Component
{
    use WithFileUploads, WithPagination;

    public string $search = '';
    public int $perPage = 10;

    // Slider Form
    public bool $showSliderModal = false;
    public bool $isSliderEdit = false;
    public ?int $sliderId = null;
    public string $sliderTitle = '';
    public string $sliderSubtitle = '';
    public string $sliderBadge = '';
    public string $sliderButtonText = 'Lihat Katalog Kamar';
    public string $sliderButtonLink = '#katalog';
    public int $sliderOrder = 1;
    public bool $sliderIsActive = true;
    public $sliderImageFile;
    public string $existingSliderImage = '';

    public function updatedSearch(): void
    {
        $this->resetPage();
    }

    public function updatedPerPage(): void
    {
        $this->resetPage();
    }

    public function openCreateSliderModal(): void
    {
        $this->reset([
            'sliderId', 'sliderTitle', 'sliderSubtitle', 'sliderBadge',
            'sliderImageFile', 'existingSliderImage'
        ]);
        $this->sliderButtonText = 'Lihat Katalog Kamar';
        $this->sliderButtonLink = '#katalog';
        $this->sliderOrder = Slider::count() + 1;
        $this->sliderIsActive = true;
        $this->isSliderEdit = false;
        $this->showSliderModal = true;
    }

    public function openEditSliderModal(int $id): void
    {
        $slider = Slider::findOrFail($id);
        $this->sliderId = $slider->id;
        $this->sliderTitle = $slider->title;
        $this->sliderSubtitle = $slider->subtitle ?? '';
        $this->sliderBadge = $slider->badge_text ?? '';
        $this->sliderButtonText = $slider->button_text ?? '';
        $this->sliderButtonLink = $slider->button_link ?? '';
        $this->sliderOrder = $slider->order;
        $this->sliderIsActive = (bool) $slider->is_active;
        $this->existingSliderImage = $slider->image;
        $this->sliderImageFile = null;

        $this->isSliderEdit = true;
        $this->showSliderModal = true;
    }

    public function saveSlider(): void
    {
        $this->validate([
            'sliderTitle' => 'required|string|max:150',
            'sliderSubtitle' => 'nullable|string|max:255',
            'sliderBadge' => 'nullable|string|max:50',
            'sliderOrder' => 'required|integer|min:0',
            'sliderImageFile' => $this->isSliderEdit ? 'nullable|image|max:5120' : 'required|image|max:5120',
        ]);

        $imagePath = $this->existingSliderImage;
        if ($this->sliderImageFile) {
            $imagePath = FileUploadService::upload($this->sliderImageFile, 'sliders');
        }

        $data = [
            'title' => $this->sliderTitle,
            'subtitle' => $this->sliderSubtitle,
            'badge_text' => $this->sliderBadge,
            'button_text' => $this->sliderButtonText,
            'button_link' => $this->sliderButtonLink,
            'order' => $this->sliderOrder,
            'is_active' => $this->sliderIsActive,
            'image' => $imagePath,
        ];

        if ($this->isSliderEdit) {
            Slider::findOrFail($this->sliderId)->update($data);
            session()->flash('success', 'Banner slider berhasil diperbarui.');
        } else {
            Slider::create($data);
            session()->flash('success', 'Banner slider baru berhasil ditambahkan.');
        }

        $this->showSliderModal = false;
    }

    public function deleteSlider(int $id): void
    {
        Slider::findOrFail($id)->delete();
        session()->flash('success', 'Banner slider berhasil dihapus.');
    }

    public function render()
    {
        $sliders = Slider::query()
            ->when($this->search, function ($query) {
                $query->where('title', 'like', "%{$this->search}%")
                    ->orWhere('subtitle', 'like', "%{$this->search}%")
                    ->orWhere('badge_text', 'like', "%{$this->search}%");
            })
            ->orderBy('order', 'asc')
            ->paginate($this->perPage);

        return view('livewire.admin.website-settings', compact('sliders'))
            ->layout('layouts.tms-admin', ['title' => 'Banner Slider']);
    }
}