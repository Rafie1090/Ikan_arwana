<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Kolam extends Model
{
    protected $fillable = [
        'nama_kolam',
        'lokasi',
        'deskripsi',
        'status',
    ];

    // Di model Kolam
    public function jadwalPakan()
    {
        return $this->hasMany(JadwalPakan::class); // Relasi one-to-many
    }
}
