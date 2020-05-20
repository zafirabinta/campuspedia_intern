<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddJumlahJam3 extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::unprepared('CREATE TRIGGER add_jumlah_jam_3 AFTER INSERT ON `intern_datas` FOR EACH ROW
        BEGIN
            DECLARE lama_kerja TIME;
            DECLARE total TIME;
            SET lama_kerja = TIMEDIFF(`NEW.jam_pulang`, `NEW.jam_masuk`);
            
            IF (CAST("12:00:00" as time) < `NEW.jam_masuk` AND CAST("12:00:00" as time) < `NEW.jam_pulang` ) THEN
                SET lama_kerja = lama_kerja;
            ELSE
                IF (CAST("12:00:00" as time) > `NEW.jam_masuk` AND CAST("12:00:00" as time) < `NEW.jam_pulang`) THEN
                    IF (CAST("13:00:00" as time) > `NEW.jam_masuk` AND CAST("13:00:00" as time) < `NEW.jam_pulang`) THEN
                        SET `lama_kerja` = TIMEDIFF(`lama_kerja`, CAST("01:00:00" as time));
                    ELSE
                        SET `lama_kerja` = TIMEDIFF(`lama_kerja`, TIMEDIFF(`NEW.jam_pulang`, CAST("12:00:00" as time)));
                IF (CAST("16:00:00" as time) > `NEW.jam_masuk` AND CAST("16:00:00" as time) < `NEW.jam_pulang`) THEN
                    IF (CAST("17:00:00" as time) > `NEW.jam_masuk` AND CAST("17:00:00" as time) < `NEW.jam_pulang`) THEN
                        SET `lama_kerja` = TIMEDIFF(`lama_kerja`, CAST("01:00:00" as time));
                    ELSE
                        SET `lama_kerja` = TIMEDIFF(`lama_kerja`, TIMEDIFF(`NEW.jam_pulang`, CAST("16:00:00" as time)));
                IF (CAST("18:00:00" as time) > `NEW.jam_masuk` AND CAST("18:00:00" as time) < `NEW.jam_pulang`) THEN
                    IF (CAST("19:00:00" as time) > `NEW.jam_masuk` AND CAST("19:00:00" as time) < `NEW.jam_pulang`) THEN
                        SET `lama_kerja` = TIMEDIFF(`lama_kerja`, CAST("01:00:00" as time));
                    ELSE
                        SET `lama_kerja` = TIMEDIFF(`lama_kerja`, TIMEDIFF(`NEW.jam_pulang`, CAST("18:00:00" as time)));

		    UPDATE `intern_datas` SET `jumlah_jam` = `lama_kerja` WHERE `id` = `NEW.id`;
            
        END
            
             
                        
            ');
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        DB::unprepared('DROP TRIGGER `add_jumlah_jam_3`');
    }
}
