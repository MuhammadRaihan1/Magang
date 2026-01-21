<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;

class KegiatanHarian extends Model
{
    use HasFactory;

    protected $table = 'kegiatan_harians';

    protected $fillable = [
        'user_id',
        'tanggal',
        'jam_masuk',
        'jam_pulang',
        'aktivitas',
        'lampiran',
        'status',
        'catatan_supervisor',
    ];

    protected $casts = [
        'tanggal' => 'date',
    ];

    public function mahasiswa()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
