<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UpdateShipmentUserId extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('shipments', function (Blueprint $table) {
            $table->unsignedBigInteger('user_id')->nullable()->after('shipping_status');
        });
        Schema::create('senders', function (Blueprint $table) {
            $table->increments('id');
            $table->string('sender_name');
            $table->string('sender_mobile');
            $table->timestamps();
        });
        Schema::table('shipment_detailes', function (Blueprint $table) {
            $table->string('sender_id')->nullable()->after('color');
            $table->string('sender')->nullable()->after('color');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('shipments', function (Blueprint $table) {
            $table->dropColumn('user_id');
        });
        Schema::dropIfExists('senders');
        Schema::table('shipment_detailes', function (Blueprint $table) {
            $table->dropColumn(['sender_id','sender']);
        });
    }
}
