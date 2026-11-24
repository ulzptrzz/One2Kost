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
        Schema::create('guest_reports', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->foreignId('room_id')->nullable()->constrained()->nullOnDelete();
            $table->string('guest_name');
            $table->string('relationship'); // Teman, Keluarga, Orang Tua, Rekan Kerja, dll.
            $table->date('visit_date');
            $table->string('visit_time');
            $table->string('duration'); // Misal: 2 jam, Seharian, Menginap semalam
            $table->text('purpose');
            $table->string('guest_phone')->nullable();
            $table->enum('status', ['recorded', 'acknowledged'])->default('recorded');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('guest_reports');
    }
};
