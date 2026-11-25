<?php

namespace Database\Seeders;

use App\Models\BankAccount;
use App\Models\Booking;
use App\Models\DamageReport;
use App\Models\Facility;
use App\Models\GuestReport;
use App\Models\Payment;
use App\Models\Room;
use App\Models\RoomType;
use App\Models\Slider;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // 1. Akun Admin
        $admin = User::updateOrCreate(
            ['email' => 'admin@kost.com'],
            [
                'name' => 'Pengelola Kost Modern',
                'password' => Hash::make('password'),
                'role' => 'admin',
                'phone' => '081234567890',
                'id_card_number' => '3171012345670001',
                'email_verified_at' => now(),
            ]
        );

        // 2. Akun Penyewa Lama (Aktif menempati Kamar A101, mendekati jatuh tempo)
        $tenantActive = User::updateOrCreate(
            ['email' => 'penyewa@kost.com'],
            [
                'name' => 'Ahmad Pratama',
                'password' => Hash::make('password'),
                'role' => 'tenant',
                'phone' => '081298765432',
                'id_card_number' => '3273012345670002',
                'email_verified_at' => now(),
            ]
        );

        // 3. Akun Budi Santoso (Penyewa DP 50% di Kamar B202)
        $tenantBudi = User::updateOrCreate(
            ['email' => 'budi@kost.com'],
            [
                'name' => 'Budi Santoso',
                'password' => Hash::make('password'),
                'role' => 'tenant',
                'phone' => '085612345678',
                'id_card_number' => '3374012345670003',
                'email_verified_at' => now(),
            ]
        );

        // 4. Akun Citra Lestari (Calon Penyewa dalam Antrian Kamar A101)
        $tenantQueue = User::updateOrCreate(
            ['email' => 'citra@kost.com'],
            [
                'name' => 'Citra Lestari',
                'password' => Hash::make('password'),
                'role' => 'tenant',
                'phone' => '081377889900',
                'id_card_number' => '3275012345670004',
                'email_verified_at' => now(),
            ]
        );

        // 5. Rekening Bank Pengelola
        $bca = BankAccount::updateOrCreate(
            ['account_number' => '8830192831'],
            [
                'bank_name' => 'BCA',
                'account_holder' => 'PT KOST MANAGEMENT INDONESIA',
                'branch' => 'KCU Thamrin Jakarta',
                'instructions' => 'Mohon sertakan Kode Booking pada berita transfer Anda untuk mempermudah verifikasi cepat.',
                'is_active' => true,
            ]
        );

        BankAccount::updateOrCreate(
            ['account_number' => '1370019283741'],
            [
                'bank_name' => 'Mandiri',
                'account_holder' => 'PT KOST MANAGEMENT INDONESIA',
                'branch' => 'KC Sudirman',
                'instructions' => 'Transfer ATM atau Livin by Mandiri. Simpan bukti transfer dalam format JPG atau PNG.',
                'is_active' => true,
            ]
        );

        BankAccount::updateOrCreate(
            ['account_number' => '034101002345531'],
            [
                'bank_name' => 'BRI',
                'account_holder' => 'PT KOST MANAGEMENT INDONESIA',
                'branch' => 'Unit Menteng',
                'instructions' => 'Dapat ditransfer via BRImo atau teller BRI seluruh Indonesia.',
                'is_active' => true,
            ]
        );

        // 6. Banner Slider Promo Halaman Depan (Foto Kamar Kost Minimalis Asli)
        Slider::updateOrCreate(
            ['title' => 'Hunian Kost Modern, Nyaman & Strategis'],
            [
                'subtitle' => 'Dilengkapi AC, Kamar Mandi Dalam, WiFi Kecepatan Tinggi, Keamanan 24 Jam & Fasilitas Lengkap.',
                'badge_text' => 'Konsep Modern & Terpercaya',
                'image' => 'https://images.pexels.com/photos/6585757/pexels-photo-6585757.jpeg?auto=compress&cs=tinysrgb&w=1600',
                'button_text' => 'Lihat Katalog Kamar',
                'button_link' => '#katalog',
                'order' => 1,
                'is_active' => true,
            ]
        );

        Slider::updateOrCreate(
            ['title' => 'Promo Diskon Sewa Tahunan Hemat s.d. 2 Bulan'],
            [
                'subtitle' => 'Dapatkan potongan harga spesial untuk masa sewa minimal 1 tahun dan gratis layanan kebersihan berkala.',
                'badge_text' => 'Promo Spesial Tahun Ini',
                'image' => 'https://images.pexels.com/photos/6585601/pexels-photo-6585601.jpeg?auto=compress&cs=tinysrgb&w=1600',
                'button_text' => 'Pilih Kamar Favorit',
                'button_link' => '#katalog',
                'order' => 2,
                'is_active' => true,
            ]
        );

        Slider::updateOrCreate(
            ['title' => 'Sistem Antrean & Booking Kamar Transparan'],
            [
                'subtitle' => 'Pantau jadwal kosong kamar secara real-time, daftar antrean lebih awal, dan kelola laporan hunian dalam satu portal.',
                'badge_text' => 'Tenant Management System',
                'image' => 'https://images.pexels.com/photos/6782567/pexels-photo-6782567.jpeg?auto=compress&cs=tinysrgb&w=1600',
                'button_text' => 'Pelajari Cara Sewa',
                'button_link' => '#alur-sewa',
                'order' => 3,
                'is_active' => true,
            ]
        );

        // 7. Master Tipe Kamar (Terhubung ke CRUD Tipe Kamar)
        $typeStandard = RoomType::updateOrCreate(
            ['name' => 'Standard'],
            [
                'default_size' => '3 x 4 m',
                'base_monthly_price' => 1500000,
                'description' => 'Kamar fungsional dengan sirkulasi udara baik, cocok untuk mahasiswa dan pekerja.',
                'is_active' => true,
            ]
        );

        $typeDeluxe = RoomType::updateOrCreate(
            ['name' => 'Deluxe'],
            [
                'default_size' => '3.5 x 4.5 m',
                'base_monthly_price' => 1850000,
                'description' => 'Kamar lebih luas dengan tempat tidur Queen Size, meja kerja lebar, dan water heater.',
                'is_active' => true,
            ]
        );

        $typeVip = RoomType::updateOrCreate(
            ['name' => 'VIP'],
            [
                'default_size' => '4 x 5 m',
                'base_monthly_price' => 2500000,
                'description' => 'Tipe eksekutif dengan Smart TV, kulkas mini, sofa santai, dan balkon pribadi.',
                'is_active' => true,
            ]
        );

        RoomType::updateOrCreate(
            ['name' => 'Suite'],
            [
                'default_size' => '5 x 5 m',
                'base_monthly_price' => 3200000,
                'description' => 'Kamar paling luas dengan ruang duduk terpisah dan fasilitas lengkap.',
                'is_active' => true,
            ]
        );

        // 8. Master Fasilitas (Terhubung ke CRUD Fasilitas & Tabel Pivot facility_room)
        $facilitiesData = [
            ['name' => 'AC', 'category' => 'Elektronik'],
            ['name' => 'AC Inverter', 'category' => 'Elektronik'],
            ['name' => 'WiFi Cepat', 'category' => 'Elektronik'],
            ['name' => 'WiFi 100Mbps', 'category' => 'Elektronik'],
            ['name' => 'Smart TV 32"', 'category' => 'Elektronik'],
            ['name' => 'Kulkas Mini', 'category' => 'Elektronik'],
            ['name' => 'Water Heater', 'category' => 'Kamar Mandi'],
            ['name' => 'Kamar Mandi Dalam', 'category' => 'Kamar Mandi'],
            ['name' => 'Kamar Mandi Luar Bersih', 'category' => 'Kamar Mandi'],
            ['name' => 'Kasur Springbed', 'category' => 'Furnitur'],
            ['name' => 'Kasur Queen Size', 'category' => 'Furnitur'],
            ['name' => 'Kasur King Size', 'category' => 'Furnitur'],
            ['name' => 'Lemari Pakaian', 'category' => 'Furnitur'],
            ['name' => 'Lemari Cermin', 'category' => 'Furnitur'],
            ['name' => 'Meja & Kursi Kerja', 'category' => 'Furnitur'],
            ['name' => 'Sofa Santai', 'category' => 'Furnitur'],
            ['name' => 'Balkon Pribadi', 'category' => 'Umum'],
            ['name' => 'Jendela Luar', 'category' => 'Umum'],
            ['name' => 'Dapur Bersama', 'category' => 'Area Bersama'],
            ['name' => 'Parkir Mobil/Motor', 'category' => 'Area Bersama'],
            ['name' => 'Cleaning Service Berkala', 'category' => 'Umum'],
        ];

        $facilityMap = [];
        foreach ($facilitiesData as $item) {
            $fac = Facility::updateOrCreate(
                ['name' => $item['name']],
                ['category' => $item['category'], 'is_active' => true]
            );
            $facilityMap[$fac->name] = $fac->id;
        }

        $syncFacilities = fn (array $names) => collect($names)
            ->map(fn ($name) => $facilityMap[$name] ?? null)
            ->filter()
            ->values()
            ->all();

        // 9. Data Kamar (Foto Kamar Kost Minimalis / Kamar Tidur Rumahan Asli)
        // Kamar A101: MENUNGGU KONFIRMASI PERPANJANGAN (pending_renewal) — 1 Foto
        $room101 = Room::updateOrCreate(
            ['room_number' => 'A101'],
            [
                'name' => 'Kamar Standard - Lantai 1 (A101)',
                'room_type_id' => $typeStandard->id,
                'floor' => 1,
                'monthly_price' => 1500000,
                'annual_price' => 16500000,
                'size' => '3 x 4 m',
                'description' => 'Kamar nyaman di lantai dasar dengan sirkulasi udara baik. Dilengkapi ranjang single springbed, lemari baju 2 pintu, meja belajar, AC, dan kamar mandi dalam.',
                'main_image' => 'https://images.pexels.com/photos/6585757/pexels-photo-6585757.jpeg?auto=compress&cs=tinysrgb&w=900',
                'images' => null,
                'status' => 'pending_renewal',
            ]
        );
        $room101->facilityItems()->sync($syncFacilities([
            'AC', 'WiFi Cepat', 'Kamar Mandi Dalam', 'Kasur Springbed', 'Lemari Pakaian', 'Meja & Kursi Kerja', 'Jendela Luar',
        ]));

        // Kamar A102: TERSEDIA (Available) — 1 Foto
        $room102 = Room::updateOrCreate(
            ['room_number' => 'A102'],
            [
                'name' => 'Kamar Deluxe - Lantai 1 (A102)',
                'room_type_id' => $typeDeluxe->id,
                'floor' => 1,
                'monthly_price' => 1850000,
                'annual_price' => 20350000,
                'size' => '3.5 x 4.5 m',
                'description' => 'Kamar luas dengan tempat tidur Queen Size, smart LED lighting, meja kerja lebar, lemari geser cermin, AC dingin, dan water heater di kamar mandi.',
                'main_image' => 'https://images.pexels.com/photos/6585601/pexels-photo-6585601.jpeg?auto=compress&cs=tinysrgb&w=900',
                'images' => null,
                'status' => 'available',
            ]
        );
        $room102->facilityItems()->sync($syncFacilities([
            'AC', 'WiFi Cepat', 'Kamar Mandi Dalam', 'Water Heater', 'Kasur Queen Size', 'Lemari Cermin', 'Meja & Kursi Kerja', 'Balkon Pribadi',
        ]));

        // Kamar B201: TERSEDIA (Available) — MEMILIKI 3 FOTO KAMAR (Kamar + Meja Belajar + Kamar Mandi Dalam)
        $b201Photos = [
            'https://images.pexels.com/photos/6782567/pexels-photo-6782567.jpeg?auto=compress&cs=tinysrgb&w=900',
            'https://images.pexels.com/photos/4050318/pexels-photo-4050318.jpeg?auto=compress&cs=tinysrgb&w=900',
            'https://images.pexels.com/photos/6585763/pexels-photo-6585763.jpeg?auto=compress&cs=tinysrgb&w=900',
        ];
        $room201 = Room::updateOrCreate(
            ['room_number' => 'B201'],
            [
                'name' => 'Kamar VIP Eksekutif - Lantai 2 (B201)',
                'room_type_id' => $typeVip->id,
                'floor' => 2,
                'monthly_price' => 2500000,
                'annual_price' => 27500000,
                'size' => '4 x 5 m',
                'description' => 'Tipe terbaik dengan interior modern minimalis, Smart TV 32 inch, kulkas mini pribadi, sofa santai, meja kerja ergonomis, dan water heater premium.',
                'main_image' => $b201Photos[0],
                'images' => $b201Photos,
                'status' => 'available',
            ]
        );
        $room201->facilityItems()->sync($syncFacilities([
            'AC Inverter', 'Smart TV 32"', 'Kulkas Mini', 'WiFi 100Mbps', 'Kamar Mandi Dalam', 'Water Heater', 'Kasur King Size', 'Sofa Santai', 'Balkon Pribadi',
        ]));

        // Kamar B202: TERISI (Occupied - DP Diterima Belum Lunas oleh Budi) — 1 Foto
        $room202 = Room::updateOrCreate(
            ['room_number' => 'B202'],
            [
                'name' => 'Kamar Deluxe - Lantai 2 (B202)',
                'room_type_id' => $typeDeluxe->id,
                'floor' => 2,
                'monthly_price' => 1800000,
                'annual_price' => 19800000,
                'size' => '3.5 x 4 m',
                'description' => 'Kamar tenang di lantai 2 dengan pemandangan taman samping. Fasilitas lengkap siap huni.',
                'main_image' => 'https://images.pexels.com/photos/7534555/pexels-photo-7534555.jpeg?auto=compress&cs=tinysrgb&w=900',
                'images' => null,
                'status' => 'occupied',
            ]
        );
        $room202->facilityItems()->sync($syncFacilities([
            'AC', 'WiFi Cepat', 'Kamar Mandi Dalam', 'Water Heater', 'Kasur Queen Size', 'Lemari Pakaian', 'Meja & Kursi Kerja',
        ]));

        // Kamar B203: TERSEDIA (Available) — 1 Foto
        $room203 = Room::updateOrCreate(
            ['room_number' => 'B203'],
            [
                'name' => 'Kamar Standard - Lantai 2 (B203)',
                'room_type_id' => $typeStandard->id,
                'floor' => 2,
                'monthly_price' => 1450000,
                'annual_price' => 15950000,
                'size' => '3 x 4 m',
                'description' => 'Kamar hemat bersahabat bagi mahasiswa atau karyawan muda. Sirkulasi udara segar dan pencahayaan alami.',
                'main_image' => 'https://images.pexels.com/photos/6585598/pexels-photo-6585598.jpeg?auto=compress&cs=tinysrgb&w=900',
                'images' => null,
                'status' => 'available',
            ]
        );
        $room203->facilityItems()->sync($syncFacilities([
            'AC', 'WiFi Cepat', 'Kamar Mandi Luar Bersih', 'Kasur Springbed', 'Lemari Pakaian', 'Meja & Kursi Kerja',
        ]));

        // 10. Booking & Transaksi Demo
        // A. Booking Aktif Ahmad Pratama di Kamar A101 (Mendekati jatuh tempo 30 Nov 2026)
        $startDateA101 = Carbon::parse('2026-10-01');
        $endDateA101 = Carbon::parse('2026-11-30');
        $bookingA101 = Booking::updateOrCreate(
            ['booking_code' => 'TMS-202610-A101'],
            [
                'user_id' => $tenantActive->id,
                'room_id' => $room101->id,
                'start_date' => $startDateA101,
                'duration_months' => 2,
                'end_date' => $endDateA101,
                'rental_type' => 'monthly',
                'total_price' => 3000000,
                'payment_scheme' => 'full',
                'dp_amount' => 0,
                'remaining_amount' => 0,
                'status' => 'active',
                'renewal_status' => 'pending',
                'notes' => 'Penyewa aktif. Masa sewa berakhir 30 November 2026 dan sedang menunggu konfirmasi perpanjangan.',
            ]
        );

        Payment::updateOrCreate(
            ['booking_id' => $bookingA101->id, 'payment_type' => 'full'],
            [
                'user_id' => $tenantActive->id,
                'bank_account_id' => $bca->id,
                'amount' => 3000000,
                'payment_date' => $startDateA101,
                'proof_image' => 'https://images.pexels.com/photos/4386321/pexels-photo-4386321.jpeg?auto=compress&cs=tinysrgb&w=700',
                'sender_name' => 'Ahmad Pratama',
                'sender_bank' => 'BCA',
                'status' => 'approved',
                'admin_notes' => 'Pembayaran lunas telah diverifikasi. Kamar siap dihuni.',
                'verified_at' => $startDateA101,
                'verified_by' => $admin->id,
            ]
        );

        // B. Booking Budi Santoso di Kamar B202 (Skema DP 50%, Belum Lunas)
        $startDateB202 = Carbon::parse('2026-11-20');
        $endDateB202 = Carbon::parse('2026-12-20');
        $bookingB202 = Booking::updateOrCreate(
            ['booking_code' => 'TMS-202611-B202'],
            [
                'user_id' => $tenantBudi->id,
                'room_id' => $room202->id,
                'start_date' => $startDateB202,
                'duration_months' => 1,
                'end_date' => $endDateB202,
                'rental_type' => 'monthly',
                'total_price' => 1800000,
                'payment_scheme' => 'dp',
                'dp_amount' => 900000,
                'remaining_amount' => 900000,
                'status' => 'dp_paid',
                'renewal_status' => 'pending',
                'notes' => 'Pembayaran DP 50% diterima. Menunggu pelunasan sebelum jatuh tempo.',
            ]
        );

        Payment::updateOrCreate(
            ['booking_id' => $bookingB202->id, 'payment_type' => 'dp'],
            [
                'user_id' => $tenantBudi->id,
                'bank_account_id' => $bca->id,
                'amount' => 900000,
                'payment_date' => now()->subDays(2),
                'proof_image' => 'https://images.pexels.com/photos/4386321/pexels-photo-4386321.jpeg?auto=compress&cs=tinysrgb&w=700',
                'sender_name' => 'Budi Santoso',
                'sender_bank' => 'Mandiri',
                'status' => 'approved',
                'admin_notes' => 'DP 50% telah diterima. Harap segera melunasi sisa tagihan Rp 900.000.',
                'verified_at' => now()->subDay(),
                'verified_by' => $admin->id,
            ]
        );

        // C. Antrian Calon Penyewa Citra Lestari untuk Kamar A101 (Mulai 1 Des 2026 setelah Ahmad selesai)
        Booking::updateOrCreate(
            ['booking_code' => 'TMS-202612-A101-Q1'],
            [
                'user_id' => $tenantQueue->id,
                'room_id' => $room101->id,
                'start_date' => Carbon::parse('2026-12-01'),
                'duration_months' => 3,
                'end_date' => Carbon::parse('2027-02-28'),
                'rental_type' => 'monthly',
                'total_price' => 4500000,
                'payment_scheme' => 'full',
                'dp_amount' => 0,
                'remaining_amount' => 4500000,
                'status' => 'waiting_renewal_confirmation',
                'renewal_status' => 'pending',
                'notes' => 'Antrian #1 untuk Kamar A101 apabila penghuni lama tidak memperpanjang.',
            ]
        );

        // 11. Laporan Kerusakan Demo (Oleh Ahmad di Kamar A101)
        DamageReport::updateOrCreate(
            [
                'user_id' => $tenantActive->id,
                'facility_name' => 'AC Kurang Dingin & Menetes',
            ],
            [
                'room_id' => $room101->id,
                'description' => 'Unit AC di kamar A101 mengeluarkan tetesan air di bagian bawah casing dan hembusan udara kurang sejuk sejak kemarin sore.',
                'photo' => 'https://images.pexels.com/photos/3964341/pexels-photo-3964341.jpeg?auto=compress&cs=tinysrgb&w=700',
                'status' => 'in_progress',
                'admin_response' => 'Teknisi service AC sudah dijadwalkan datang hari Jumat pukul 14:00 WIB. Mohon pastikan ada orang di kamar.',
            ]
        );

        // 12. Laporan Kunjungan Tamu Demo (Oleh Ahmad)
        GuestReport::updateOrCreate(
            [
                'user_id' => $tenantActive->id,
                'guest_name' => 'Rian Sanjaya',
            ],
            [
                'room_id' => $room101->id,
                'relationship' => 'Rekan Kerja / Teman',
                'visit_date' => now()->addDay()->toDateString(),
                'visit_time' => '19:00 - 22:00 WIB',
                'duration' => '3 Jam',
                'purpose' => 'Kerja kelompok / diskusi proyek kantor.',
                'guest_phone' => '081344556677',
                'status' => 'recorded',
            ]
        );
    }
}