<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // 1. Master Tipe Kamar
        Schema::create('room_types', function (Blueprint $table) {
            $table->id();
            $table->string('name')->unique();
            $table->string('default_size')->nullable();
            $table->decimal('base_monthly_price', 12, 2)->nullable();
            $table->text('description')->nullable();
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });

        // 2. Master Fasilitas
        Schema::create('facilities', function (Blueprint $table) {
            $table->id();
            $table->string('name')->unique();
            $table->string('category')->default('Umum');
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });

        // 3. Tabel Kamar (Terhubung ke room_types)
        Schema::create('rooms', function (Blueprint $table) {
            $table->id();
            $table->string('room_number')->unique();
            $table->string('name');
            $table->foreignId('room_type_id')->nullable()->constrained('room_types')->nullOnDelete();
            $table->integer('floor')->default(1);
            $table->decimal('monthly_price', 12, 2);
            $table->decimal('annual_price', 12, 2)->nullable();
            $table->string('size')->default('3 x 4 m');
            $table->text('description')->nullable();
            $table->string('main_image')->nullable();
            $table->json('images')->nullable();
            $table->enum('status', ['available', 'occupied', 'pending_renewal'])->default('available');
            $table->timestamps();
        });

        // 4. Tabel Pivot Many-to-Many (Kamar <-> Fasilitas)
        Schema::create('facility_room', function (Blueprint $table) {
            $table->id();
            $table->foreignId('room_id')->constrained('rooms')->cascadeOnDelete();
            $table->foreignId('facility_id')->constrained('facilities')->cascadeOnDelete();
            $table->timestamps();

            $table->unique(['room_id', 'facility_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('facility_room');
        Schema::dropIfExists('rooms');
        Schema::dropIfExists('facilities');
        Schema::dropIfExists('room_types');
    }
};