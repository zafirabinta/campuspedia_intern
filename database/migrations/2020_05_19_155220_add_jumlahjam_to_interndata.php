<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddJumlahjamToInterndata extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('intern_datas', function(Blueprint $table){
            $table->time('jumlah_jam');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('shop_intern_datas', function(Blueprint $table){
            $table->dropColumn(['jumlah_jam']);
        });
    }
}
