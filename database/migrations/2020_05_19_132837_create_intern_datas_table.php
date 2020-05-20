<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateInternDatasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('intern_datas', function (Blueprint $table) {
            $table->increments('id');
            $table->date('tanggal_kerja');
            $table->time('jam_masuk');
            $table->time('jam_pulang');
            $table->string('tugas');
            $table->string('kendala');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('intern_datas');
    }
}
