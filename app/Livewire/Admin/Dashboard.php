<?php

namespace App\Livewire\Admin;

use App\Models\Booking;
use App\Models\DamageReport;
use App\Models\GuestReport;
use App\Models\Payment;
use App\Models\Room;
use App\Models\User;
use Carbon\Carbon;
use Livewire\Component;

class Dashboard extends Component
{
    public function render()
    {
        $totalRooms = Room::count();
        $occupiedRooms = Room::where('status', 'occupied')->count();
        $availableRooms = Room::where('status', 'available')->count();
        $activeTenantsCount = User::where('role', 'tenant')
            ->whereHas('bookings', fn($q) => $q->whereIn('status', ['active', 'dp_paid']))
            ->count();

        // Financial stats
        $currentMonthRevenue = Payment::where('status', 'approved')
            ->whereMonth('payment_date', Carbon::now()->month)
            ->whereYear('payment_date', Carbon::now()->year)
            ->sum('amount');

        $totalRevenue = Payment::where('status', 'approved')->sum('amount');

        // Operational stats
        $pendingPaymentsCount = Payment::where('status', 'pending')->count();
        $waitingQueueCount = Booking::where('status', 'waiting_renewal_confirmation')->count();
        $pendingDamagesCount = DamageReport::whereIn('status', ['reported', 'in_progress'])->count();
        $recentGuestReportsCount = GuestReport::whereDate('visit_date', '>=', Carbon::today())->count();

        // 1. Penyewa dengan skema DP yang belum melunasi sisa pembayaran
        $unpaidDpBookings = Booking::with(['room', 'user'])
            ->where(function ($q) {
                $q->where('status', 'dp_paid')
                  ->orWhere(function ($sub) {
                      $sub->where('payment_scheme', 'dp')
                          ->where('remaining_amount', '>', 0)
                          ->whereIn('status', ['active', 'dp_paid', 'pending_payment']);
                  });
            })
            ->latest()
            ->get();

        // 2. Penyewa yang masa sewanya mendekati habis (<= 30 hari ke depan)
        $expiringBookings = Booking::with(['room', 'user'])
            ->whereIn('status', ['active', 'dp_paid'])
            ->whereNotNull('end_date')
            ->whereDate('end_date', '<=', Carbon::now()->addDays(30))
            ->orderBy('end_date', 'asc')
            ->get();

        // Recent items
        $recentPayments = Payment::with(['booking.room', 'user'])
            ->latest()
            ->take(5)
            ->get();

        $recentWaitingBookings = Booking::with(['room', 'user'])
            ->where('status', 'waiting_renewal_confirmation')
            ->latest()
            ->take(5)
            ->get();

        $recentDamages = DamageReport::with(['room', 'user'])
            ->whereIn('status', ['reported', 'in_progress'])
            ->latest()
            ->take(5)
            ->get();

        return view('livewire.admin.dashboard', compact(
            'totalRooms',
            'occupiedRooms',
            'availableRooms',
            'activeTenantsCount',
            'currentMonthRevenue',
            'totalRevenue',
            'pendingPaymentsCount',
            'waitingQueueCount',
            'pendingDamagesCount',
            'recentGuestReportsCount',
            'unpaidDpBookings',
            'expiringBookings',
            'recentPayments',
            'recentWaitingBookings',
            'recentDamages'
        ))->layout('layouts.tms-admin', ['title' => 'Dashboard Ringkasan Pengelola']);
    }
}