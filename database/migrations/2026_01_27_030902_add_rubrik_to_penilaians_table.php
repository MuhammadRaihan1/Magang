<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('penilaians', function (Blueprint $table) {

            // sistem baru
            $table->json('nilai')->nullable()->after('inisiatif');
            $table->unsignedSmallInteger('total_skor')->default(0)->after('nilai');
            $table->decimal('nilai_akhir', 5, 2)->default(0)->after('total_skor');
            $table->string('grade', 2)->default('-')->after('nilai_akhir');

            // sistem lama dijadikan nullable
            $table->unsignedTinyInteger('disiplin')->nullable()->change();
            $table->unsignedTinyInteger('tanggung_jawab')->nullable()->change();
            $table->unsignedTinyInteger('kerjasama')->nullable()->change();
            $table->unsignedTinyInteger('inisiatif')->nullable()->change();
        });
    }

    public function down(): void
    {
        Schema::table('penilaians', function (Blueprint $table) {
            $table->dropColumn(['nilai', 'total_skor', 'nilai_akhir', 'grade']);
        });
    }
};
