<?php

namespace App\Livewire\Admin;

use App\Models\BankAccount;
use Livewire\Component;
use Livewire\WithPagination;

class BankAccountManagement extends Component
{
    use WithPagination;

    public string $search = '';
    public int $perPage = 10;

    public bool $showBankModal = false;
    public bool $isBankEdit = false;
    public ?int $bankId = null;
    public string $bank_name = 'BCA';
    public string $account_number = '';
    public string $account_holder = '';
    public string $branch = '';
    public string $instructions = '';
    public bool $is_active = true;

    public function updatedSearch(): void
    {
        $this->resetPage();
    }

    public function updatedPerPage(): void
    {
        $this->resetPage();
    }

    public function openCreateBankModal(): void
    {
        $this->reset(['bankId', 'account_number', 'account_holder', 'branch', 'instructions']);
        $this->bank_name = 'BCA';
        $this->is_active = true;
        $this->isBankEdit = false;
        $this->showBankModal = true;
    }

    public function openEditBankModal(int $id): void
    {
        $bank = BankAccount::findOrFail($id);
        $this->bankId = $bank->id;
        $this->bank_name = $bank->bank_name;
        $this->account_number = $bank->account_number;
        $this->account_holder = $bank->account_holder;
        $this->branch = $bank->branch ?? '';
        $this->instructions = $bank->instructions ?? '';
        $this->is_active = (bool) $bank->is_active;

        $this->isBankEdit = true;
        $this->showBankModal = true;
    }

    public function saveBank(): void
    {
        $this->validate([
            'bank_name' => 'required|string|max:50',
            'account_number' => 'required|string|max:50',
            'account_holder' => 'required|string|max:100',
            'branch' => 'nullable|string|max:100',
            'instructions' => 'nullable|string',
        ]);

        $data = [
            'bank_name' => $this->bank_name,
            'account_number' => $this->account_number,
            'account_holder' => $this->account_holder,
            'branch' => $this->branch,
            'instructions' => $this->instructions,
            'is_active' => $this->is_active,
        ];

        if ($this->isBankEdit) {
            BankAccount::findOrFail($this->bankId)->update($data);
            session()->flash('success', 'Rekening bank berhasil diperbarui.');
        } else {
            BankAccount::create($data);
            session()->flash('success', 'Rekening bank baru berhasil ditambahkan.');
        }

        $this->showBankModal = false;
    }

    public function deleteBank(int $id): void
    {
        BankAccount::findOrFail($id)->delete();
        session()->flash('success', 'Rekening bank berhasil dihapus.');
    }

    public function render()
    {
        $banks = BankAccount::query()
            ->when($this->search, function ($query) {
                $query->where('bank_name', 'like', "%{$this->search}%")
                    ->orWhere('account_number', 'like', "%{$this->search}%")
                    ->orWhere('account_holder', 'like', "%{$this->search}%")
                    ->orWhere('branch', 'like', "%{$this->search}%");
            })
            ->latest()
            ->paginate($this->perPage);

        return view('livewire.admin.bank-account-management', compact('banks'))
            ->layout('layouts.tms-admin', ['title' => 'Bank Account']);
    }
}