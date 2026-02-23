<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('kegiatan_harians', function (Blueprint $table) {
            $table->string('status_verifikasi', 20)->default('pending');
            $table->timestamp('verified_at')->nullable();
            $table->unsignedBigInteger('verified_by')->nullable();
            $table->text('catatan_verifikasi')->nullable();
        });
    }

    public function down(): void
    {
        Schema::table('kegiatan_harians', function (Blueprint $table) {
            $table->dropColumn([
                'status_verifikasi',
                'verified_at',
                'verified_by',
                'catatan_verifikasi'
            ]);
        });
    }
};