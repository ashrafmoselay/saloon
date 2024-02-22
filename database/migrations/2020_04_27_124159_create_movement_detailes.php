<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMovementDetailes extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('movement_invoice', function (Blueprint $table) {
            $table->increments('id');
            $table->text('note')->nullable();
            $table->timestamps();
        });
        Schema::table('movements', function (Blueprint $table) {
            $table->unsignedInteger('invoice_id')->nullable()->after('id');
            $table->foreign('invoice_id')
                ->references('id')
                ->on('movement_invoice')
                ->onDelete('cascade');
        });
        $check = \App\Movement::get();
        if(!empty($check)) {
            $id = \App\MovementInvoice::create(['note' => 'التحويلات السابقة'])->id;
            /*$list = \App\Movement::groupBy(DB::raw('Date(created_at)'))
                            ->orderBy('created_at', 'DESC')->get();*/
            \DB::Statement("update movements set invoice_id=$id");
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('movements', function (Blueprint $table) {
            $table->dropForeign('movements_invoice_id_forign');
            $table->dropColumn('invoice_id');
        });
        Schema::dropIfExists('movement_invoice');
    }
}
