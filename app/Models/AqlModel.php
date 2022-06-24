<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AqlModel extends Model
{
    protected $table = 'tb_master_aql'; //disesuaikan dengan database
    protected $primaryKey = 'id_aql'; //disesuaikan dengan database

    protected $fillable = [
    	'level_aql',
        'kode_aql',
        'qty_lot_min',
        'qty_lot_max',
        'qty_sample_aql',
        'qty_accept_minor',
        'qty_accept_major',
        'created_at',
        'updated_at'
    ];
}
