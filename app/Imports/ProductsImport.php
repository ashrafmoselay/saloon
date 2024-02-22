<?php

namespace App\Imports;

use App\Category;
use App\Product;
use App\ProductStore;
use App\ProductUnit;
use App\Store;
use App\Unit;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithStartRow;

class ProductsImport implements ToCollection,WithStartRow
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function collection(Collection $rows)
    {
//        DB::table('product_unit')->truncate();
//        DB::table('product_store')->truncate();
        DB::table('products')->truncate();
//        DB::table('categories')->truncate();
//        DB::table('units')->truncate();
        foreach ($rows as $row) {
            if(!$row[1]){
                $row[1] = "أخرى";
            }
            $category = Category::firstOrCreate(['name'=>$row[1]],['name'=>$row[1],'type'=>1]);
//            $unit = Unit::firstOrCreate(['name'=>$row[2]]);
            //$product = Product::where('code',$row[0])->first();
           $qty = $row[5]?:0;
            $cost = $row[3]?:0; $price = $row[4]?:0; $gomla = $row[4]?:0;
            $product = Product::firstOrCreate([
                'name' => $row[0]?:'صنف بدون اسم',
            ],[
                'name' => $row[0]?:'صنف بدون اسم',
                'code' => rand(10000,60000),
                'first_qty' => $qty,
                'last_cost' => $cost,
                'avg_cost' => $cost,
                'main_category_id' => $category->id,
                'observe' => 5,
                'is_price_percent' => 0,
                'price_percent' => 0
            ]);
            if(!$price){
                $price = $cost + ($cost * 0.1);
            }
            if(!$gomla){
                $gomla = $cost + ($cost * 0.05);
            }
            ProductUnit::firstOrCreate(
                [
                    'product_id' => $product->id,
                    'unit_id' => 1
                ],
                [
                'unit_id' => 1,
                'product_id' => $product->id,
                'pieces_num' => 1,
                'cost_price' => $cost,
                'sale_price' => round($price, 2),
                'gomla_price' => round($gomla, 2),
                'gomla_gomla_price' => round($gomla, 2),
            ]);
            $store = Store::query()->firstOrCreate([
                'name'=>$row[2]
            ],[
                'name'=>$row[2]
            ]);
            ProductStore::firstOrCreate(
                [
                    'product_id' => $product->id,
                    'store_id' => $store->id],
                [
                'product_id' => $product->id,
                'store_id' => $store->id,
                'unit_id' => 1,
                'qty' => $qty,
                'sale_count' => 0
            ]);
            /*$ss = ProductStore::where('product_id',$product->id)->first();
            $ss->qty -= $row[1];
            $ss->save();*/
        }
    }

    public function startRow(): int
    {
        return 1;
    }
}
