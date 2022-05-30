<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class InspeksiHeaderModel extends Model
{
    protected $table = 'tb_inspeksi_header'; //disesuaikan dengan database
    protected $primaryKey = 'id_inspeksi_header'; //disesuaikan dengan database

    protected $fillable = [
    	'type_form',
    	'tgl_inspeksi',
        'shift',
        'id_user',
        'id_sub_departemen',
        'created_at',
        'updated_at'
    ];
}
