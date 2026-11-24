<?php

namespace App\Livewire\Admin;

use App\Models\Booking;
use App\Models\DamageReport;
use App\Models\GuestReport;
use App\Models\Payment;
use Livewire\Component;

class NotificationBell extends Component
{
    public function render()
    {
        $pendingPaymentsCount = Payment::where('status', 'pending')->count();
        $waitingBookingsCount = Booking::whereIn('status', ['waiting_renewal_confirmation', 'payment_under_review'])->count();
        $reportedDamagesCount = DamageReport::where('status', 'reported')->count();
        $recordedGuestsCount = GuestReport::where('status', 'recorded')->count();

        $totalNotifications = $pendingPaymentsCount + $waitingBookingsCount + $reportedDamagesCount + $recordedGuestsCount;

        $recentPayments = Payment::with(['user', 'booking'])->where('status', 'pending')->latest()->take(3)->get();
        $recentBookings = Booking::with(['user', 'room'])->whereIn('status', ['waiting_renewal_confirmation', 'payment_under_review'])->latest()->take(3)->get();
        $recentDamages = DamageReport::with(['user', 'room'])->where('status', 'reported')->latest()->take(3)->get();
        $recentGuests = GuestReport::with(['user', 'room'])->where('status', 'recorded')->latest()->take(3)->get();

        return view('livewire.admin.notification-bell', compact(
            'pendingPaymentsCount',
            'waitingBookingsCount',
            'reportedDamagesCount',
            'recordedGuestsCount',
            'totalNotifications',
            'recentPayments',
            'recentBookings',
            'recentDamages',
            'recentGuests'
        ));
    }
}
