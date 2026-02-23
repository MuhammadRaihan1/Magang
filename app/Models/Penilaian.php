<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Penilaian extends Model
{
    use HasFactory;

    protected $table = 'penilaians';

    protected $fillable = [
        'mahasiswa_id',
        'supervisor_id',
        'nilai',
        'total_skor',
        'nilai_akhir',
        'grade',
        'tanggal',
    ];

    protected $casts = [
        'nilai' => 'array',
        'tanggal' => 'date',
    ];

    public function mahasiswa()
    {
        return $this->belongsTo(User::class, 'mahasiswa_id');
    }

    public function supervisor()
    {
        return $this->belongsTo(User::class, 'supervisor_id');
    }
}