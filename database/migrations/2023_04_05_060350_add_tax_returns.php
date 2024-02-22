<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddTaxReturns extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('returns', function (Blueprint $table) {
            $table->double('tax')->nullable()->default(0);
        });
        Schema::table('expenses', function (Blueprint $table) {
            $table->double('tax')->nullable()->default(0);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('returns', function (Blueprint $table) {
            $table->dropColumn('tax');
        });
        Schema::table('expenses', function (Blueprint $table) {
            $table->dropColumn('tax');
        });
    }
}
