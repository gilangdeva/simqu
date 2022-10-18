<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PeriodeModel extends Model
{
    protected $table = 'tb_master_periode'; //disesuaikan dengan database
    protected $primaryKey = 'id_periode'; //disesuaikan dengan database

    protected $fillable = [
    	'tahun',
    	'bulan',
        'minggu_ke',
        'created_at',
        'tgl_mulai_periode',
        'tgl_akhir_periode',
        'updated_at',
        'urutan',
    ];
}
