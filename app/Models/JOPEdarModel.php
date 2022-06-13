<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class JOPEdarModel extends Model
{
    protected $table = 'tb_master_jop'; //disesuaikan dengan database
    protected $primaryKey = 'jop'; //disesuaikan dengan database

    protected $fillable = [
        'jop',
    	'tgl_jop',
        'nama_barang',
        'order',
        'hasil_produksi',
        'kurang',
        'creator',
        'created_at',
        'pic',
        'updated_at'
    ];

}
