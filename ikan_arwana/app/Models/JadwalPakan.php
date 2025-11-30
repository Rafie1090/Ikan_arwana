<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class JadwalPakan extends Model
{
    protected $fillable = [
        'kolam_id',
        'waktu',
        'sesi',
        'jumlah',
        'jenis_pakan',
        'tanggal',   // ⬅ WAJIB ADA BIAR BISA DIISI OTOMATIS
        'status',
    ];

    // Relasi ke model Kolam (kolam_id sebagai foreign key)
    public function kolam()
    {
        return $this->belongsTo(Kolam::class);
    }
}
