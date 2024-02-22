<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddRegionIdShipment extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('shipment_detailes', function (Blueprint $table) {
            $table->unsignedBigInteger('region_id')->nullable()->after('color');
            $table->foreign('region_id')->references('id')
                ->on('regions')
                ->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('shipment_detailes', function (Blueprint $table) {
            $table->dropForeign('shipment_detailes_region_id_foreign');
            $table->dropColumn('region_id');
        });
    }
}
