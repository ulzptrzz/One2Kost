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
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Route;
use Illuminate\Validation\Rules\Password;

// Public Landing Page
Route::get('/', LandingPage::class)->name('home');

// Direct Password Reset (tanpa kirim email)
Route::post('/forgot-password', function (Request $request) {
    $request->validate([
        'email' => ['required', 'email', 'exists:users,email'],
    ], [
        'email.exists' => 'Email tersebut tidak terdaftar di sistem.',
    ]);

    return redirect()->route('password.reset', [
        'token' => 'direct-reset',
        'email' => $request->email,
    ]);
})->middleware('guest')->name('password.email');

Route::post('/reset-password', function (Request $request) {
    $request->validate([
        'email' => ['required', 'email', 'exists:users,email'],
        'password' => ['required', 'confirmed', Password::min(8)],
    ], [
        'email.exists' => 'Email tidak ditemukan.',
        'password.min' => 'Password minimal 8 karakter.',
        'password.confirmed' => 'Konfirmasi password tidak cocok.',
    ]);

    $user = User::where('email', $request->email)->firstOrFail();
    $user->forceFill([
        'password' => Hash::make($request->password),
    ])->save();

    return redirect()->route('login')->with('status', 'Password berhasil diperbarui! Silakan login dengan password baru.');
})->middleware('guest')->name('password.update');

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