<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('penilaians', function (Blueprint $table) {
            $table->id();

            // mahasiswa yang dinilai (user role mahasiswa)
            $table->foreignId('mahasiswa_id')->constrained('users')->cascadeOnDelete();

            // supervisor yang menilai (user role supervisor)
            $table->foreignId('supervisor_id')->constrained('users')->cascadeOnDelete();

            // komponen penilaian (0-100)
            $table->unsignedTinyInteger('disiplin');
            $table->unsignedTinyInteger('tanggung_jawab');
            $table->unsignedTinyInteger('kerjasama');
            $table->unsignedTinyInteger('inisiatif');

            $table->text('catatan')->nullable();
            $table->date('tanggal')->nullable(); // opsional

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('penilaians');
    }
};

