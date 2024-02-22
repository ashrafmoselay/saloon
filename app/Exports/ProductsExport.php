<?php
namespace App\Exports;

use App\Product;
use App\ProductUnit;
use App\Unit;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;

class ProductsExport implements FromView
{
    public function view(): View
    {
        return view('exports.products', [
            'products' => ProductUnit::with(['product','unit'])->get()
        ]);
    }
}
