<?php

namespace App\Exports;

use App\Models\MonitoringAir;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;

class MonitoringAirExport implements FromView
{
    public function __construct($kolam)
    {
        $this->kolam = $kolam;
    }

    public function view(): View
    {
        return view('exports.monitoring-air', [
            'data' => MonitoringAir::where('kolam_id', $this->kolam)->get(),
        ]);
    }
}
