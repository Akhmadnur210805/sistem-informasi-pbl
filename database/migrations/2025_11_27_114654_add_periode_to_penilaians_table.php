<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('penilaians', function (Blueprint $table) {
            // Kita tambahkan kolom ini agar nilai UTS dan UAS tidak saling timpa
            $table->string('periode')->default('sebelum_uts')->after('mata_kuliah_id');
        });
    }

    public function down(): void
    {
        Schema::table('penilaians', function (Blueprint $table) {
            $table->dropColumn('periode');
        });
    }
};