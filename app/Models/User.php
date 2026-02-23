<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class User extends Authenticatable
{
    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
        'supervisor_id',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];

    public function penilaians(): HasMany
    {
        return $this->hasMany(Penilaian::class, 'mahasiswa_id');
    }

    public function penilaianTerakhir(): HasOne
    {
        return $this->hasOne(Penilaian::class, 'mahasiswa_id')->latestOfMany();
    }

    public function supervisor(): BelongsTo
    {
        return $this->belongsTo(User::class, 'supervisor_id');
    }

    public function mahasiswaBimbingan(): HasMany
    {
        return $this->hasMany(User::class, 'supervisor_id');
    }
}