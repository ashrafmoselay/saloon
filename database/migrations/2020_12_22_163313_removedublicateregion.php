<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class Removedublicateregion extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {

        $persons = \App\Person::whereNotNull('region_id')->get();
        foreach ($persons as $p){
            $region = \App\Region::where('name',$p->region->name)->first();
            $p->region_id = $region->id;
            $p->update();
            \App\Region::where('name',$p->region->name)
                ->where('id','<>',$region->id)
                ->delete();
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
}
