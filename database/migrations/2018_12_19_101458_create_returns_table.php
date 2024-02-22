<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateReturnsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('returns', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('client_id')->nullable();
            $table->foreign('client_id')
                ->references('id')
                ->on('persons')
                ->onDelete('set null');
            $table->string('return_type')->comment('sales,purchase');
            $table->boolean('return_value');
            $table->boolean('is_cash');
            $table->date('return_date');
            $table->softDeletes();
            $table->timestamps();
        });
        Schema::create('return_detailes', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('return_id')->nullable();
            $table->foreign('return_id')
                ->references('id')
                ->on('returns')
                ->onDelete('set null');
            $table->unsignedInteger('store_id')->nullable();
            $table->foreign('store_id')
                ->references('id')
                ->on('stores')
                ->onDelete('set null');
            $table->string('store_name');
            $table->unsignedInteger('product_id')->nullable();
            $table->foreign('product_id')
                ->references('id')
                ->on('products')
                ->onDelete('set null');
            $table->unsignedInteger('unit_id')->nullable();
            $table->foreign('unit_id')
                ->references('id')
                ->on('units')
                ->onDelete('set null');
            $table->string('unit_name');
            $table->string('product_name');
            $table->integer('qty');
            $table->double('price');
            $table->double('cost');
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
        Schema::dropIfExists('returns');
        Schema::dropIfExists('return_detailes');
    }
}
