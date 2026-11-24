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
        Schema::table('users', function (Blueprint $table) {
            $table->string('role')->default('tenant')->after('email'); // 'admin', 'tenant'
            $table->string('phone')->nullable()->after('role');
            $table->string('id_card_number')->nullable()->after('phone');
            $table->string('avatar')->nullable()->after('id_card_number');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn(['role', 'phone', 'id_card_number', 'avatar']);
        });
    }
};
