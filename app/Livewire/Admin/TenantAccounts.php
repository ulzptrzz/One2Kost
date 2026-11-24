<?php

namespace App\Livewire\Admin;

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;
use Livewire\Component;
use Livewire\WithPagination;

class TenantAccounts extends Component
{
    use WithPagination;

    public string $search = '';
    public int $perPage = 10;

    // Modal Detail & Edit
    public bool $showDetailModal = false;
    public ?User $detailUser = null;

    public bool $showEditModal = false;
    public ?int $editingUserId = null;
    public string $name = '';
    public string $email = '';
    public string $phone = '';
    public string $id_card_number = '';
    public string $password = '';

    public function updatedSearch(): void
    {
        $this->resetPage();
    }

    public function updatedPerPage(): void
    {
        $this->resetPage();
    }

    public function openDetailModal(int $userId): void
    {
        $this->detailUser = User::where('role', 'tenant')
            ->with(['bookings' => fn ($q) => $q->with('room')->latest()])
            ->findOrFail($userId);
        $this->showDetailModal = true;
    }

    public function closeDetailModal(): void
    {
        $this->showDetailModal = false;
        $this->detailUser = null;
    }

    public function openEditModal(int $userId): void
    {
        $user = User::where('role', 'tenant')->findOrFail($userId);

        $this->editingUserId = $user->id;
        $this->name = $user->name;
        $this->email = $user->email;
        $this->phone = $user->phone ?? '';
        $this->id_card_number = $user->id_card_number ?? '';
        $this->password = '';
        $this->resetValidation();
        $this->showEditModal = true;
    }

    public function closeEditModal(): void
    {
        $this->showEditModal = false;
        $this->editingUserId = null;
        $this->password = '';
    }

    public function updateAccount(): void
    {
        $user = User::where('role', 'tenant')->findOrFail($this->editingUserId);

        $validated = $this->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255', Rule::unique('users', 'email')->ignore($user->id)],
            'phone' => ['nullable', 'string', 'max:30'],
            'id_card_number' => ['nullable', 'string', 'max:30'],
            'password' => ['nullable', 'string', 'min:6'],
        ]);

        $data = [
            'name' => $validated['name'],
            'email' => $validated['email'],
            'phone' => $validated['phone'] ?: null,
            'id_card_number' => $validated['id_card_number'] ?: null,
        ];

        if (!empty($validated['password'])) {
            $data['password'] = Hash::make($validated['password']);
        }

        $user->update($data);

        $this->closeEditModal();
        session()->flash('success', "Data akun {$user->name} berhasil diperbarui.");
    }

    public function deleteAccount(int $userId): void
    {
        $user = User::where('role', 'tenant')->findOrFail($userId);
        $userName = $user->name;
        $user->delete();

        session()->flash('success', "Akun {$userName} berhasil dihapus.");
    }

    public function render()
    {
        $allTenants = User::where('role', 'tenant')
            ->with(['bookings' => function ($q) {
                $q->with('room')
                  ->whereNotIn('status', ['cancelled', 'rejected', 'expired', 'completed'])
                  ->latest();
            }])
            ->when($this->search, function ($query) {
                $query->where(function ($q) {
                    $q->where('name', 'like', "%{$this->search}%")
                      ->orWhere('email', 'like', "%{$this->search}%")
                      ->orWhere('phone', 'like', "%{$this->search}%");
                });
            })
            ->latest()
            ->paginate($this->perPage);

        return view('livewire.admin.tenant-accounts', compact('allTenants'))
            ->layout('layouts.tms-admin', ['title' => 'Semua Akun Terdaftar']);
    }
}