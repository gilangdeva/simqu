<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DepartmentModel extends Model
{
    protected $table = 'tb_master_departemen'; //disesuaikan dengan database
    protected $primaryKey = 'id_departemen'; //disesuaikan dengan database

    protected $fillable = [
    	'kode_departemen',
    	'nama_departemen',
        'created_at',
        'updated_at'
    ];
}
