<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBanksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('banks', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->string('number')->nullable()->default(null);
            $table->double('balance');
            $table->double('percent')->nullable()->default(0);
            $table->timestamps();
        });
        Schema::create('bank_transactions', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('bank_id')->unsigned();
            $table->foreign('bank_id')->references('id')
                    ->on('banks')
                    ->onDelete('cascade');
            $table->date('op_date');
            $table->double('value');
            $table->double('total');
            $table->double('due');
            $table->integer('type');
            $table->integer('record_id')->nullable()->default(null);
            $table->string('note')->nullable();
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
        Schema::dropIfExists('bank_transactions');
        Schema::dropIfExists('banks');
    }
}
