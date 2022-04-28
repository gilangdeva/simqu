<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MesinModel extends Model
{
    protected $table = 'tb_master_mesin'; //disesuaikan dengan database
    protected $primaryKey = 'id_mesin'; //disesuaikan dengan database

    protected $fillable = [
    	'kode_mesin',
    	'nama_mesin',
        'id_departemen',
        'id_subdepartemen',
        'created_at',
        'updated_at'
    ];
}