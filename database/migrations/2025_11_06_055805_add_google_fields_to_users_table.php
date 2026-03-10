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
            // INI YANG SEBELUMNYA KELUPAAN (Sangat Wajib!)
            $table->string('google_id')->nullable()->after('email'); 
            
            $table->text('google_token')->nullable(); // simpan access token
            $table->text('google_refresh_token')->nullable(); // refresh token
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            // Jangan lupa tambahkan di fungsi down juga agar rapi
            $table->dropColumn(['google_id', 'google_token', 'google_refresh_token']);
        });
    }
};