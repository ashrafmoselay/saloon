<?php

use App\Expense;
use App\Order;
use App\ReturnProduct;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddTaxValueOrderExpenseReturn extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->double('tax_value')->default(0)->after('tax');
        });
        Schema::table('returns', function (Blueprint $table) {
            $table->double('tax_value')->default(0)->after('tax');
        });
        Schema::table('expenses', function (Blueprint $table) {
            $table->double('tax_value')->default(0)->after('tax');
        });
        $orders = Order::where("tax",">",0)->get();
        if($orders){
            foreach($orders as $row){
                $row->tax_value = $row->tax_value_caluclated;
                $row->save();
            }
        }
        $returns = ReturnProduct::where("tax",">",0)->get();
        if($returns){
            foreach($returns as $row){
                $row->tax_value = $row->tax_value_caluclated;
                $row->save();
            }
        }
        $expenses = Expense::where("tax",">",0)->get();
        if($expenses){
            foreach($expenses as $row){
                $row->tax_value = $row->tax_value_caluclated;
                $row->save();
            }
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {

        Schema::table('orders', function (Blueprint $table) {
            $table->dropColumn('tax_value');
        });
        Schema::table('returns', function (Blueprint $table) {
            $table->dropColumn('tax_value');
        });
        Schema::table('expenses', function (Blueprint $table) {
            $table->dropColumn('tax_value');
        });
    }
}
