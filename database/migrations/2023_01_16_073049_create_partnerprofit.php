<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePartnerprofit extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('partner_profit', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('partner_id');
            $table->foreign('partner_id')
                ->references('id')
                ->on('partners')
                ->onDelete('cascade');
            $table->double('value');
            $table->timestamps();
        });
        Schema::table('partners', function (Blueprint $table) {
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('partner_profit');
        Schema::table('partners', function (Blueprint $table) {
            $table->dropSoftDeletes();
        });
    }
}
