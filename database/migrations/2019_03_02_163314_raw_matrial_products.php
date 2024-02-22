<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class RawMatrialProducts extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {

        Schema::table('products', function (Blueprint $table) {
            $table->boolean('is_raw_material')->default(false);
            $table->text('note')->nullable();
        });
        Schema::create('product_raw_materials', function (Blueprint $table) {
            $table->unsignedInteger('product_id');
            $table->foreign('product_id')
                ->references('id')
                ->on('products')
                ->onDelete('cascade');
            $table->unsignedInteger('raw_material_id');
            $table->foreign('raw_material_id')
                ->references('id')
                ->on('products')
                ->onDelete('cascade');
            $table->double('qty');
            $table->integer('color_number')->nullable();
            $table->timestamps();

        });

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('products', function (Blueprint $table) {
            $table->dropColumn(['is_raw_material','note']);
        });

        Schema::dropIfExists('product_raw_materials');
    }
}
