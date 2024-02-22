<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateExpensesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('expenses', function (Blueprint $table) {
            $table->increments('id');
            $table->string('note');
            $table->double('value');
            $table->unsignedInteger('partner_id')->nullable();
            $table->foreign('partner_id')
                ->references('id')
                ->on('partners')
                ->onDelete('set null');
            $table->timestamps();
        });
        Schema::create('tresury_tranactions', function (Blueprint $table) {
            $table->increments('id');
            $table->string('note');
            $table->double('value');
            $table->string('type');
            $table->integer('record_id')->nullable()->default(null);
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
        Schema::dropIfExists('expenses');
        Schema::dropIfExists('tresury_tranactions');
    }
}
