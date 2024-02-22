<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddEmployeeType extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
       Schema::table('employees', function (Blueprint $table) {
            $table->dropColumn(['working_days','day_salary','salary']);
        });
        Schema::table('employees', function (Blueprint $table) {
            $table->string('type')->default('normal')->after('note');
            $table->double('percent')->default(0)->after('note');
            $table->integer('working_days')->nullable()->after('name');
            $table->double('day_salary')->nullable()->after('name');
            $table->double('salary')->nullable()->after('name');
        });

        Schema::table('orders', function (Blueprint $table) {
            $table->dropForeign('orders_markter_id_foreign');
            $table->dropForeign('orders_sale_id_foreign');
        });
        Schema::table('orders', function (Blueprint $table) {
            $table->foreign('markter_id')
                ->references('id')
                ->on('employees')
                ->onDelete('cascade');
            $table->foreign('sale_id')
                ->references('id')
                ->on('employees')
                ->onDelete('cascade');
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
            $table->dropColumn(['type','percent']);
        });
        Schema::table('orders', function (Blueprint $table) {
            $table->dropForeign('orders_markter_id_foreign');
            $table->dropForeign('orders_sale_id_foreign');
        });
        Schema::table('orders', function (Blueprint $table) {
            $table->foreign('markter_id')
                ->references('id')
                ->on('persons')
                ->onDelete('cascade');
            $table->foreign('sale_id')
                ->references('id')
                ->on('persons')
                ->onDelete('cascade');
        });
    }
}
