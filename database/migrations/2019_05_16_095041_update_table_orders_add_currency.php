<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UpdateTableOrdersAddCurrency extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->string('currency')->default('EGP')->after('total');
        });
        Schema::table('returns', function (Blueprint $table) {
            $table->string('currency')->default('EGP')->after('return_value');
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
            $table->dropColumn('currency');
        });
        Schema::table('returns', function (Blueprint $table) {
            $table->dropColumn('currency');
        });
    }
}
