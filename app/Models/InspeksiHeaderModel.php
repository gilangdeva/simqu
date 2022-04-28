<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class InspeksiHeaderModel extends Model
{
    protected $table = 'tb_inspeksi_header';
    protected $primaryKey = 'id_inspeksi_header';

    protected $fillable = [
        'id_user',
        'tgl_inspeksi',
        'id_shift'
    ];    
}
