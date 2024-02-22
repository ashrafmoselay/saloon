<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUserPointsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user_points', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('user_id');
            $table->double('balance');
            $table->unsignedBigInteger('order_id')->nullable();
            $table->timestamps();
        });
        DB::table('settings')->insert([
            [ 'key' => 'point_value', 'name' =>'point_value', 'value'=>0],
        ]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('user_points');
    }
}
