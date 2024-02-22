<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePartnerStores extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('partners', function (Blueprint $table) {
            $table->dropColumn('percent');
        });
        Schema::create('partner_stores', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('partner_id');
            $table->foreign('partner_id')
                ->references('id')
                ->on('partners')
                ->onDelete('cascade');
            $table->unsignedInteger('store_id');
            $table->foreign('store_id')
                ->references('id')
                ->on('stores')
                ->onDelete('cascade');
            $table->double('percent');
            $table->timestamps();
        });
        Schema::table('expenses', function (Blueprint $table) {
            $treasury_id = \App\Bank::where('type',2)->first()->id;
            $table->unsignedBigInteger('bank_id')->default($treasury_id)->after('value');
        });
        $treasury_id = \App\Bank::where('type',2)->first()->id;
        \App\Order::query()->update(['bank_id'=>$treasury_id]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('partners', function (Blueprint $table) {
            $table->double('percent')->nullable()->after('value');
        });
        Schema::dropIfExists('partner_stores');
        Schema::table('expenses', function (Blueprint $table) {
            $table->dropColumn('bank_id');
        });
    }
}
