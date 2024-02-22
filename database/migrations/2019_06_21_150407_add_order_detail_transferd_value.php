<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddOrderDetailTransferdValue extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('order_detailes', function (Blueprint $table) {
            $table->double('cost_egp')->default(0);
            $table->double('price_egp')->default(0)->nullable();

        });
        \DB::statement('UPDATE order_detailes SET cost_egp = cost,price_egp=price ');
        Schema::table('return_detailes', function (Blueprint $table) {
            $table->double('cost_egp')->default(0);
            $table->double('price_egp')->default(0);

        });
        \DB::statement('UPDATE return_detailes SET cost_egp = cost,price_egp=price ');

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('order_detailes', function (Blueprint $table) {
            $table->dropColumn(['cost_egp','price_egp']);
        });
        Schema::table('return_detailes', function (Blueprint $table) {
            $table->dropColumn(['cost_egp','price_egp']);
        });
    }
}
