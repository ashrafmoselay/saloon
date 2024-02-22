<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateStoresTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('stores', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->string('mobile')->nullable();
            $table->string('note')->nullable();
            $table->softDeletes();
            $table->timestamps();
        });
        Schema::create('categories', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->string('type');
            $table->softDeletes();
            $table->timestamps();
        });
        Schema::create('units', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->softDeletes();
            $table->timestamps();
        });
        Schema::create('partners', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->double('value')->nullable();
            $table->double('percent');
            $table->timestamps();
        });
        Schema::create('products', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->text('description')->nullable();
            $table->string('code')->nullable();
            $table->string('model')->nullable();
            $table->unsignedInteger('main_category_id')->nullable();
            $table->unsignedInteger('sub_category_id')->nullable();
            $table->double('avg_cost')->nullable();
            $table->double('last_cost')->nullable();
            $table->integer('observe')->default(0);
            $table->foreign('main_category_id')
                ->references('id')
                ->on('categories')
                ->onDelete('cascade');
            $table->foreign('sub_category_id')
                ->references('id')
                ->on('categories')
                ->onDelete('cascade');
            $table->softDeletes();
            $table->timestamps();
        });
        Schema::create('sales_meta', function (Blueprint $table) {
            $table->increments('id');
            $table->double('target');
            $table->integer('work_days');
            $table->integer('percent');
            $table->unsignedInteger('sale_id');
            $table->foreign('sale_id')
                ->references('id')
                ->on('persons')
                ->onDelete('cascade');
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
        Schema::dropIfExists('stores');
        Schema::dropIfExists('categories');
        Schema::dropIfExists('units');
        Schema::dropIfExists('partners');
        Schema::dropIfExists('products');
        Schema::dropIfExists('sales_meta');
    }
}
