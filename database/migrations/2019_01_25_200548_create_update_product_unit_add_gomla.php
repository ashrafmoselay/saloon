<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUpdateProductUnitAddGomla extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('product_unit', function (Blueprint $table) {
            $table->double('gomla_gomla_price')->default(0);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('product_unit', function (Blueprint $table) {
            $table->dropColumn('gomla_gomla_price');
        });
    }
}
