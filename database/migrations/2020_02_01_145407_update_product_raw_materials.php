<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UpdateProductRawMaterials extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('product_raw_materials', function (Blueprint $table) {
            $table->unsignedBigInteger('raw_unit_id')->nullable();
            $table->string('raw_unit_text')->nullable();

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('product_raw_materials', function (Blueprint $table) {
            $table->dropColumn(['raw_unit_id','raw_unit_text']);
        });
    }
}
