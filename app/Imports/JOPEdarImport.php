<?php

namespace App\Imports;

use App\Models\JOPEdarModel;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithChunkReading;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class JOPEdarImport implements ToModel, WithHeadingRow, WithChunkReading
{
    public function model(array $row){
        if(isset($row['jop'])){
            foreach($row as $data) {
                $jop = new JOPEdarModel();
                $jop = JOPEdarModel::find($row['jop']);

                if (empty($jop)) {
                    return new JOPEdarModel([
                        'jop'               => $row['jop'],
                        'tgl_jop'           => $row['tgl_job'],
                        'nama_barang'       => $row['nama_barang'],
                        'order'             => $row['order'],
                        'hasil_produksi'    => $row['hp'],
                        'pic'               => session()->get('id_user'),
                        'creator'           => session()->get('id_user'),
                    ]);
                }
            }
        }
    }

    public function chunkSize(): int {
        return 5000;
    }
}
