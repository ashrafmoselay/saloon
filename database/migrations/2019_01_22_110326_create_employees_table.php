<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEmployeesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('employees', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->double('salary');
            $table->double('day_salary');
            $table->integer('working_days');
            $table->string('mobile')->nullable();
            $table->string('note')->nullable();
            $table->softDeletes();
            $table->timestamps();
        });
        Schema::create('employee_punishments_rewards', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('employee_id')->nullable();
            $table->foreign('employee_id')
                ->references('id')
                ->on('employees')
                ->onDelete('set null');
            $table->string('note');
            $table->string('type');
            $table->double('value');
            $table->softDeletes();
            $table->timestamps();
        });
        Schema::table('expenses', function (Blueprint $table) {
            $table->unsignedInteger('employee_id')->nullable();
            $table->foreign('employee_id')
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
        Schema::dropIfExists('employee_punishments_rewards');
        Schema::dropIfExists('employees');
        Schema::table('expenses', function (Blueprint $table) {
            $table->dropForeign('expenses_employee_id_foreign');
            $table->dropColumn('employee_id');
        });
    }
}
