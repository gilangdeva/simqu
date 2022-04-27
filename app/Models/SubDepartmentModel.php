<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SubDepartmentModel extends Model
{
    protected $table = 'tb_master_sub_departemen'; //disesuaikan dgn database
    protected $primaryKey = 'id_sub_departemen'; //disesuaikan dgn database

    protected $fillable = [
    	'id_departemen',
    	'kode_sub_departemen',
        'nama_sub_departemen',
        'klasifikasi_proses'
    ];
}
