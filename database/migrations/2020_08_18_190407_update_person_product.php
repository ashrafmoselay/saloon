<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UpdatePersonProduct extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('persons', function (Blueprint $table) {
            $table->string('mobile2')->nullable();
            $table->string('address')->nullable();
            $table->boolean('remember_review_balance')->default(false);
            $table->date('remember_date')->nullable();
        });
        Schema::create('person_comments', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('user_id');
            $table->unsignedInteger('person_id');
            $table->foreign('person_id')
                ->references('id')
                ->on('persons')
                ->onDelete('cascade');
            $table->string('comment')->nullable();
            $table->timestamps();
        });
        Schema::table('products', function (Blueprint $table) {
            $table->boolean('is_service')->default(false);
        });
        Schema::table('order_detailes', function (Blueprint $table) {
            $table->boolean('is_service')->default(false);
        });

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('persons', function (Blueprint $table) {
            $table->dropColumn(['mobile2','address','remember_review_balance','remember_date']);
        });
        Schema::dropIfExists('person_comments');
        Schema::table('products', function (Blueprint $table) {
            $table->dropColumn('is_service');
        });
        Schema::table('order_detailes', function (Blueprint $table) {
            $table->dropColumn('is_service');
        });
    }
}
