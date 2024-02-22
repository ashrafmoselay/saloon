<?php
namespace App\Exports;

use App\Unit;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;

class UnitsExport implements FromView
{
    public function view(): View
    {
        return view('exports.units', [
            'units' => Unit::all()
        ]);
    }
}
