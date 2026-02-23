<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class KegiatanHarian extends Model
{
    use HasFactory;

    protected $table = 'kegiatan_harians';

    protected $fillable = [
        'user_id',
        'mahasiswa_id',
        'tanggal',
        'jam_masuk',
        'jam_pulang',
        'aktivitas',
        'status',
        'status_verifikasi',
        'verifikasi',
        'catatan_supervisor',
    ];

    protected $casts = [
        'tanggal' => 'date',
    ];

    // 🔥 RELASI KE MAHASISWA (USER)
    public function mahasiswa()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    // 🔥 RELASI KE SUPERVISOR (JIKA ADA)
    public function supervisor()
    {
        return $this->belongsTo(User::class, 'supervisor_id');
    }

    public function getVerifikasiStatus(): string
    {
        $status =
            $this->status ??
            $this->status_verifikasi ??
            $this->verifikasi ??
            null;

        if (!$status) {
            return 'pending';
        }

        $status = strtolower((string) $status);

        if ($status === 'approved') return 'approved';
        if ($status === 'rejected') return 'rejected';

        return 'pending';
    }
}