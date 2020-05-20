<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class InternData extends Model
{
    protected $fillable = ['tanggal_kerja', 'jam_masuk', 'jam_pulang', 'tugas', 'kendala'];
}
