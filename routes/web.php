<?php

use App\Livewire\Admin\DamageManagement;
use App\Livewire\Admin\Dashboard as AdminDashboard;
use App\Livewire\Admin\GuestManagement;
use App\Livewire\Admin\PaymentManagement;
use App\Livewire\Admin\RoomManagement;
use App\Livewire\Admin\FacilityManagement;
use App\Livewire\Admin\RoomTypeManagement;
use App\Livewire\Admin\TenantManagement;
use App\Livewire\Admin\WaitingQueueTenants;
use App\Livewire\Admin\TenantAccounts;
use App\Livewire\Admin\WebsiteSettings;
use App\Livewire\Admin\BankAccountManagement;

use App\Livewire\LandingPage;
use App\Livewire\Tenant\DamageReportIndex;
use App\Livewire\Tenant\GuestReportIndex;
use App\Livewire\Tenant\PaymentHistory;
use Illuminate\Support\Facades\Route;

// Public Landing Page
Route::get('/', LandingPage::class)->name('home');

// Halaman Pemberitahuan Terkunci (untuk pengunjung yang belum login)
Route::get('/portal/akses-terkunci/{feature?}', function (?string $feature = null) {
    if (auth()->check()) {
        if (auth()->user()->isAdmin()) {
            return redirect()->route('admin.dashboard');
        }

        return match ($feature) {
            'damage' => redirect()->route('tenant.damages'),
            'visitor' => redirect()->route('tenant.guests'),
            default => redirect()->route('tenant.history'),
        };
    }

    return view('tenant.locked', ['feature' => $feature]);
})->name('tenant.locked');

// Multi-role Dashboard Redirection (setelah login)
Route::get('/dashboard', function () {
    if (auth()->check()) {
        if (auth()->user()->isAdmin()) {
            return redirect()->route('admin.dashboard');
        }
        return redirect()->route('tenant.history');
    }
    return redirect()->route('login');
})->middleware(['auth'])->name('dashboard');

// Tenant Portal Routes
Route::prefix('tenant')
    ->name('tenant.')
    ->middleware(['auth', 'role.tenant'])
    ->group(function () {
        Route::get('/pembayaran', fn() => redirect()->route('tenant.history'))->name('payments');

        // Menu History
        Route::get('/history', PaymentHistory::class)->name('history');

        // Menu Damage & Visitor
        Route::get('/laporan-kerusakan', DamageReportIndex::class)->name('damages');
        Route::get('/laporan-tamu', GuestReportIndex::class)->name('guests');
    });

// Admin Portal Routes
Route::prefix('admin')
    ->name('admin.')
    ->middleware(['auth', 'role.admin'])
    ->group(function () {
        Route::get('/dashboard', AdminDashboard::class)->name('dashboard');
        Route::get('/kamar', RoomManagement::class)->name('rooms');
        Route::get('/kamar/fasilitas', FacilityManagement::class)->name('rooms.facilities');
        Route::get('/kamar/tipe', RoomTypeManagement::class)->name('rooms.types');

        // Tenants Period & Sub-babnya
        Route::get('/penyewa', fn() => redirect()->route('admin.tenants.active'))->name('tenants');
        Route::get('/penyewa/aktif', TenantManagement::class)->name('tenants.active');
        Route::get('/penyewa/antrian', WaitingQueueTenants::class)->name('tenants.waiting');
        Route::get('/penyewa/akun', TenantAccounts::class)->name('tenants.accounts');

        Route::get('/pembayaran', PaymentManagement::class)->name('payments');
        Route::get('/laporan-kerusakan', DamageManagement::class)->name('damages');
        Route::get('/laporan-tamu', GuestManagement::class)->name('guests');
        Route::get('/settings/banners', WebsiteSettings::class)->name('settings.banners');
        Route::get('/settings/banks', BankAccountManagement::class)->name('settings.banks');
    });

require __DIR__ . '/settings.php';
