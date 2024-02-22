<?php

use App\DamageOption;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddNoteDamages extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {

        Schema::create('damageoptions', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->timestamps();
        });
        Schema::table('damages', function (Blueprint $table) {
            $table->text('note')->nullable();
            $table->unsignedInteger('creator_id')->nullable();
            $table->unsignedInteger('damageoption_id')->nullable();
            $table->foreign('damageoption_id')
                ->references('id')
                ->on('damageoptions')
                ->onDelete('cascade');
            $table->foreign('creator_id')
                ->references('id')
                ->on('users')
                ->onDelete('cascade');
        });
        $list = ['سرقة','منتهي الصلاحية','كسر'];
        foreach($list as $item){
            DamageOption::query()->create(['name'=>$item]);
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('damages', function (Blueprint $table) {
            $table->dropForeign('damages_damageoption_id_foreign');
            $table->dropForeign('damages_creator_id_foreign');
            $table->dropColumn(['creator_id','damageoption_id','note']);
        });
        Schema::dropIfExists('damageoptions');
    }
}
