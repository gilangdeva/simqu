<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DefectDetailModel extends Model
{
    protected $table = 'tb_master_defect_detail'; //disesuaikan dengan database
    protected $primaryKey = 'id_master_defect_detail'; //disesuaikan dengan database

    protected $fillable = [
    	'id_master_defect_header',
    	'kode_defect',
        'defect'
    ];
}
