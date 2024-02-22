<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateGovernmentAreasTurpoShipment extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('governments', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->timestamps();
        });
        Schema::create('areas', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('government_id');
            $table->foreign('government_id')
                ->references('id')
                ->on('governments')
                ->onDelete('cascade');
            $table->string('name');
            $table->timestamps();
        });
        Schema::table('persons', function (Blueprint $table) {
            $table->unsignedInteger('area_id')->nullable();
            $table->foreign('area_id')
                ->references('id')
                ->on('areas')
                ->onDelete('set null');
        });

        Schema::table('orders', function (Blueprint $table) {
            $table->boolean('is_shipped')->default(0);
            $table->double('shipment_amount')->default(0)->nullable;
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->dropColumn('is_shipped', 'shipment_amount');
        });
        Schema::table('persons', function (Blueprint $table) {
            $table->dropForeign('persons_area_id_foreign');
            $table->dropColumn('area_id');
        });
        Schema::dropIfExists('areas');
        Schema::dropIfExists('governments');
    }
}