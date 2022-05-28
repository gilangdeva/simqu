<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DraftDetailModel extends Model
{
    protected $table = 'draft_detail'; //disesuaikan dengan database
    protected $primaryKey = 'id_inspeksi_detail'; //disesuaikan dengan database

    protected $fillable = [
        'id_inspeksi_header',
        'id_mesin',
        'qty_1',
        'qty_5',
        'pic',
        'jam_mulai',
        'jam_selesai',
        'lama_inspeksi',
        'jop',
        'item',
        'id_defect',
        'kriteria',
        'qty_defect',
        'qty_ready_pcs',
        'qty_sampling',
        'penyebab',
        'status',
        'keterangan',
        'qty_ready_pack',
        'qty_sample_aql',
        'qty_sample_riil',
        'qty_reject_all',
        'hasil_verifikasi',
        'created_at',
        'creator',
        'updated_at',
        'updater',
    ];
}
