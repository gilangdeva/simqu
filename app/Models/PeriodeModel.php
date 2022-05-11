<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PeriodeModel extends Model
{
    protected $table = 'tb_master_periode'; //disesuaikan dengan database
    protected $primaryKey = 'id_periode'; //disesuaikan dengan database

    protected $dates = [
        'tgl_mulai_periode',
        'tgl_akhir_periode'
    ];

    protected $fillable = [
    	'tahun',
    	'bulan',
        'minggu_ke',
        'created_at',
        'updated_at'
    ];
}
