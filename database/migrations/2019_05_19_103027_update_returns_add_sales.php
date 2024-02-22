<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UpdateReturnsAddSales extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('returns', function (Blueprint $table) {
            $table->string('sales_value')->nullable()->default('0')->after('return_value');
            $table->unsignedInteger('sale_id')->nullable();
            $table->foreign('sale_id')
                ->references('id')
                ->on('employees')
                ->onDelete('set null');
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
            $table->dropForeign('returns_sale_id_foreign');
            $table->dropColumn(['sales_value','sale_id']);
        });
    }
}
