<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MonitoringAir extends Model
{
    protected $table = 'monitoring_air';

    protected $fillable = [
        'suhu',
        'ph',
        'oksigen',
        'kekeruhan',
        'kolam_id',
    ];
    public function kolam()
    {
        return $this->belongsTo(Kolam::class, 'kolam_id');
    }
}
