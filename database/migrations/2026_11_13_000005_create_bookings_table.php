<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('bookings', function (Blueprint $table) {
            $table->id();
            $table->string('booking_code')->unique();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->foreignId('room_id')->constrained()->cascadeOnDelete();
            $table->date('start_date');
            $table->integer('duration_months')->default(1);
            $table->date('end_date');
            $table->string('rental_type')->default('monthly'); // 'monthly', 'annual'
            $table->decimal('total_price', 12, 2);
            $table->string('payment_scheme')->default('full'); // 'full', 'dp'
            $table->decimal('dp_amount', 12, 2)->default(0);
            $table->decimal('remaining_amount', 12, 2)->default(0);
            $table->enum('status', [
                'waiting_renewal_confirmation', // Antrian (Waiting list)
                'pending_payment',              // Menunggu Pembayaran
                'payment_under_review',        // Bukti transfer diunggah, menunggu verifikasi admin
                'dp_paid',                     // DP Diterima - Belum Lunas
                'active',                      // Lunas & Aktif Sewa
                'cancelled',                   // Dibatalkan
                'completed'                    // Selesai Masa Sewa
            ])->default('pending_payment');
            $table->enum('renewal_status', [
                'pending',                     // Belum ada respon
                'renewing',                    // Ingin perpanjang
                'moving_out'                   // Pindah / tidak perpanjang
            ])->default('pending');
            $table->text('notes')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('bookings');
    }
};
