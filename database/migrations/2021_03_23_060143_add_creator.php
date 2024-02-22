<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddCreator extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $firstUser = 1;//\App\User::first()->id;
        Schema::table('expenses', function (Blueprint $table)use($firstUser) {
            $table->unsignedBigInteger('creator_id')->nullable()->default($firstUser);
        });
        Schema::table('movement_invoice', function (Blueprint $table)use($firstUser) {
            $table->unsignedBigInteger('creator_id')->nullable()->default($firstUser);
        });
        Schema::table('bank_transactions', function (Blueprint $table)use($firstUser) {
            $table->unsignedBigInteger('creator_id')->nullable()->default($firstUser);
        });
        Schema::table('transactions', function (Blueprint $table)use($firstUser) {
            $table->unsignedBigInteger('creator_id')->nullable()->default($firstUser);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('expenses', function (Blueprint $table) {
            $table->dropColumn('creator_id');
        });
        Schema::table('movement_invoice', function (Blueprint $table) {
            $table->dropColumn('creator_id');
        });
        Schema::table('bank_transactions', function (Blueprint $table) {
            $table->dropColumn('creator_id');
        });
        Schema::table('transactions', function (Blueprint $table) {
            $table->dropColumn('creator_id');
        });
    }
}
