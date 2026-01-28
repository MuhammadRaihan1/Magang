<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Penilaian extends Model
{
    protected $fillable = [
        'mahasiswa_id',
        'supervisor_id',

        // sistem lama (nullable)
        'disiplin',
        'tanggung_jawab',
        'kerjasama',
        'inisiatif',
        'catatan',

        // sistem baru
        'nilai',        // JSON (15 aspek)
        'total_skor',   // int
        'nilai_akhir',  // decimal
        'grade',        // A–E
        'tanggal',
    ];

    protected $casts = [
        'nilai' => 'array',
        'total_skor' => 'integer',
        'nilai_akhir' => 'float',
        'tanggal' => 'date',
    ];

    public function mahasiswa(): BelongsTo
    {
        return $this->belongsTo(User::class, 'mahasiswa_id');
    }

    public function supervisor(): BelongsTo
    {
        return $this->belongsTo(User::class, 'supervisor_id');
    }
}
