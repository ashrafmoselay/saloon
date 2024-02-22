<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddServiceEmployeeDatetime extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('order_detailes', function (Blueprint $table) {
            $table->string('serive_datetime')->nullable()->after('comment');
            $table->string('employee_id')->nullable()->after('comment');
            $table->string('employee_name')->nullable()->after('comment');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('order_detailes', function (Blueprint $table) {
            $table->dropColumn(['serive_datetime','employee_id','employee_name']);
        });
    }
}
