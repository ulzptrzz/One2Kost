<?php

namespace Tests\Feature;

use App\Livewire\LandingPage;
use App\Models\Booking;
use App\Models\Room;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Livewire\Livewire;
use Tests\TestCase;

class TenantManagementSystemTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        $this->seed();
    }

    public function test_landing_page_renders_successfully(): void
    {
        $response = $this->get('/');
        $response->assertStatus(200);
        $response->assertSee('Kost');
    }

    public function test_room_booking_detects_conflict_when_occupied(): void
    {
        $room101 = Room::where('room_number', 'A101')->first();
        $this->assertNotNull($room101);

        // Active booking ends 2026-12-15
        // Test picking a date before that (e.g. 2026-12-01) -> MUST CONFLICT
        Livewire::test(LandingPage::class)
            ->call('openBookingModal', $room101->id)
            ->set('startDate', '2026-12-01')
            ->assertSet('hasConflict', true)
            ->assertSet('isWaitingList', false);
    }

    public function test_room_booking_enters_waiting_list_queue_after_occupied_date(): void
    {
        $room101 = Room::where('room_number', 'A101')->first();
        $this->assertNotNull($room101);

        // Active booking ends 2026-12-15
        // Test picking a date after that (e.g. 2026-12-20) -> MUST ENTER WAITING LIST
        Livewire::test(LandingPage::class)
            ->call('openBookingModal', $room101->id)
            ->set('startDate', '2026-12-20')
            ->assertSet('hasConflict', false)
            ->assertSet('isWaitingList', true);
    }

    public function test_admin_can_access_admin_dashboard_but_tenant_cannot(): void
    {
        $admin = User::where('email', 'admin@kost.com')->first();
        $tenant = User::where('email', 'penyewa@kost.com')->first();

        // Admin access
        $this->actingAs($admin)
            ->get(route('admin.dashboard'))
            ->assertStatus(200)
            ->assertSee('Dashboard Ringkasan');

        // Tenant access to admin dashboard should redirect
        $this->actingAs($tenant)
            ->get(route('admin.dashboard'))
            ->assertRedirect(route('tenant.dashboard'));
    }

    public function test_tenant_dashboard_displays_dp_remaining_alert_for_budi(): void
    {
        $budi = User::where('email', 'budi@kost.com')->first();
        $this->assertNotNull($budi);

        // Budi has a booking with dp_paid and remaining_amount = 900,000
        $this->actingAs($budi)
            ->get(route('tenant.dashboard'))
            ->assertStatus(200)
            ->assertSee('Perhatian: Anda Memiliki Sisa Tagihan Pelunasan');
    }
}
