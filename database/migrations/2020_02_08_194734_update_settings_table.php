<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UpdateSettingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::table('settings')->insert([
            [ 'key' => 'subtract_expenses_profit', 'name' =>'subtract_expenses_profit', 'value'=>1],
            [ 'key' => 'logo', 'name' =>'Logo', 'value'=>''],
        ]);
        DB::table('banks')->insert([
            [ 'name' => 'الخزنة', 'balance' =>0,'currency'=>config('currency.default'), 'type'=>2],
        ]);

        Schema::table('bank_transactions', function (Blueprint $table) {
            $table->integer('transactionable_id')->nullable();
            $table->string('transactionable_type')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
}
