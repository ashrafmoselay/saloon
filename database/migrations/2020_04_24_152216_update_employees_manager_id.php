<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UpdateEmployeesManagerId extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('employees', function (Blueprint $table) {
            $table->unsignedInteger('manager_id')->nullable();
            $table->double('target')->nullable();
            $table->foreign('manager_id')
                ->references('id')
                ->on('employees')
                ->onDelete('set null');
        });
        Schema::table('orders', function (Blueprint $table) {
            $table->unsignedInteger('manager_id')->nullable();
            $table->foreign('manager_id')
                ->references('id')
                ->on('employees')
                ->onDelete('set null');
        });
        Schema::table('returns', function (Blueprint $table) {
            $table->unsignedInteger('manager_id')->nullable();
            $table->foreign('manager_id')
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
        Schema::table('employees', function (Blueprint $table) {
            $table->dropForeign('employees_manager_id_foreign');
            $table->dropColumn(['manager_id','target']);
        });
        Schema::table('orders', function (Blueprint $table) {
            $table->dropForeign('orders_manager_id_foreign');
            $table->dropColumn('manager_id');
        });
    }
}
