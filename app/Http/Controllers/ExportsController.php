<?php
namespace App\Http\Controllers;

use App\Exports\ProductsExport;
use App\Exports\UnitsExport;
use Maatwebsite\Excel\Facades\Excel;

class ExportsController extends Controller
{
    public function index()
    {
        return Excel::download(new ProductsExport(), 'products.xls');
    }
}
