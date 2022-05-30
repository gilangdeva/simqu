<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DraftHeaderModel extends Model
{
    protected $table = 'draft_header'; //disesuaikan dengan database
    protected $primaryKey = 'id_inspeksi_header'; //disesuaikan dengan database
    protected $keyType = 'string';

    protected $fillable = [
        'id_inspeksi_detail',
        'type_form',
        'tgl_inspeksi',
        'shift',
        'id_user',
        'id_departemen',
        'id_sub_departemen',
        'created_at',
        'updated_at',
    ];
}
