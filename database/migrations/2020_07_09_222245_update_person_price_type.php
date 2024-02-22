<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UpdatePersonPriceType extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('persons', function (Blueprint $table) {
            $table->string('priceType')->default('one')->nullable();
        });
        Schema::table('product_unit', function (Blueprint $table) {
            $table->double('half_gomla_price')->after('gomla_price')->default(0);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('persons', function (Blueprint $table) {
            $table->dropColumn('priceType');
        });
        Schema::table('product_unit', function (Blueprint $table) {
            $table->dropColumn('half_gomla_price');
        });
    }
}
