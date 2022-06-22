<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SatuanModel extends Model
{
    protected $table = 'tb_master_satuan'; //disesuaikan dengan database
    protected $primaryKey = 'id_satuan'; //disesuaikan dengan database

    protected $fillable = [
        'kode_satuan',
        'nama_satuan',
        'created_at',
        'updated_at'
    ];
}
