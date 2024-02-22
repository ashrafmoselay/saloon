<?php

use Illuminate\Database\Seeder;

class ProductsTable extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('products')->truncate();
        for($i=0;$i<5;$i++) {
            $inputs["product"] = [
                "name" => str_random(5) . ' ' . str_random(5),
                "observe" => "12",
                "main_category_id" => "1",
                "code" => null,
                "model" => null
            ];
            $inputs["unit"] = [
                1 => [
                    "unit_id" => "1",
                    "pieces_num" => "1",
                    "cost_price" => rand(10, 100),
                    "sale_price" => rand(10, 200),
                    "gomla_price" => rand(10, 300),
                ]
            ];
            $inputs["store"] = [
                1 => [
                    "store_id" => "1",
                    "sale_count" => "0",
                    "qty" => rand(3,10 ),
                    "unit_id" => "1",
                ]
            ];
            $product = \App\Product::create($inputs['product']);
            $product->productUnit()->attach($inputs['unit']);
            $product->productStore()->attach($inputs['store']);
        }
    }
}
