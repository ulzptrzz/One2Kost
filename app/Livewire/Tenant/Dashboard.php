<?php

namespace App\Livewire\Tenant;

use App\Models\Booking;
use App\Models\DamageReport;
use App\Models\GuestReport;
use App\Models\Payment;
use Carbon\Carbon;
use Livewire\Component;

class Dashboard extends Component
{
    public $renewalFeedback = '';

    public function confirmRenewal($bookingId, $status)
    {
        $booking = Booking::where('id', $bookingId)
            ->where('user_id', auth()->id())
            ->firstOrFail();

        if (in_array($status, ['renewing', 'moving_out'])) {
            $booking->update([
                'renewal_status' => $status,
            ]);

            $this->renewalFeedback = $status === 'renewing' 
                ? 'Terima kasih! Konfirmasi perpanjangan sewa Anda telah dicatat oleh pengelola.' 
                : 'Konfirmasi pindah/checkout telah dicatat. Pengelola akan memproses pengembalian deposit/kunci saat jatuh tempo.';

            session()->flash('renewal_message', $this->renewalFeedback);
        }
    }

    public function render()
    {
        $user = auth()->user();

        // 1. Check for Active or DP Booking
        $activeBooking = Booking::with(['room', 'payments'])
            ->where('user_id', $user->id)
            ->whereIn('status', ['active', 'dp_paid'])
            ->latest()
            ->first();

        // 2. Check for Pending or Waiting Queue Bookings
        $waitingBookings = Booking::with('room')
            ->where('user_id', $user->id)
            ->whereIn('status', ['waiting_renewal_confirmation', 'pending_payment', 'payment_under_review'])
            ->latest()
            ->get();

        // 3. DP Alert check: if there is a booking with status 'dp_paid' and remaining_amount > 0
        $dpBookingPendingSettlement = Booking::with('room')
            ->where('user_id', $user->id)
            ->where('status', 'dp_paid')
            ->where('remaining_amount', '>', 0)
            ->latest()
            ->first();

        // 4. Counts
        $totalPaymentsCount = Payment::where('user_id', $user->id)->count();
        $totalDamagesCount = DamageReport::where('user_id', $user->id)->count();
        $totalGuestsCount = GuestReport::where('user_id', $user->id)->count();

        // 5. Recent damage reports
        $recentDamages = DamageReport::where('user_id', $user->id)->latest()->take(3)->get();

        return view('livewire.tenant.dashboard', compact(
            'activeBooking',
            'waitingBookings',
            'dpBookingPendingSettlement',
            'totalPaymentsCount',
            'totalDamagesCount',
            'totalGuestsCount',
            'recentDamages'
        ))->layout('layouts.tms-tenant', ['title' => 'Dashboard Penyewa']);
    }
}
