<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

// Tambahkan source dibawah ini
use Illuminate\Support\Facades\DB;
use App\Models\DepartmentModel;
use App\Models\SubDepartmentModel;
use App\Models\MesinModel;
use App\Models\DefectModel;
use App\Models\DraftHeaderModel;
use App\Models\DraftDetailModel;

use Carbon\Carbon;
use Image;
use File;
use Crypt;
use Redirect;
use RealRashid\SweetAlert\Facades\Alert;

class InspeksiInlineController extends Controller
{
    // Menampilkan list inspeksi inline
    public function InlineList(){
        $list_inline = DB::select('SELECT * FROM vw_list_inline');

        return view('inspeksi.inline-list',
        [
            'menu'      => 'inspeksi',
            'sub'       => '/inline',
            'inline'    => $list_inline,
        ]);
    }

    // Redirect ke window input inspeksi inline
    public function InlineInput(){
        $departemen = DB::select("SELECT id_departemen, nama_departemen FROM vg_list_departemen");
        $defect = DB::select("SELECT id_defect, defect FROM vg_list_defect");
        $draft = DB::select("SELECT * FROM vw_draft_inline WHERE id_user =".session()->get('id_user')); // Select untuk list draft sesuai session user login

        return view('inspeksi.inline-input',[
            'departemen'    => $departemen,
            'defect'        => $defect,
            'draft'         => $draft,
            'menu'          => 'inspeksi', // selalu ada di tiap function dan disesuaikan
            'sub'           => '/inline'
        ]);
    }

    //Simpan data inspeksi inline
    public function SaveInlineData(Request $request){
        // Controller Wawan
        $row = 0;
        $cek_id_header = $request->id_inspeksi_header;
        $departemen = DB::select("SELECT id_departemen, nama_departemen FROM vg_list_departemen");
        $defect = DB::select("SELECT id_defect, defect FROM vg_list_defect");
        $draft = DB::select("SELECT * FROM vw_draft_inline WHERE id_user =".session()->get('id_user')); // Select untuk list draft sesuai session user login

        // Parameters Header
        $type_form = "Inline"; // Inline
        $tgl_inspeksi = $request->tgl_inspeksi;
        $shift = strtoupper($request->shift);
        $id_user = session()->get('id_user');
        $id_departemen = $request->id_departemen;
        $id_sub_departemen = $request->id_sub_departemen;
        $created_at = date('Y-m-d H:i:s', strtotime('+0 hours'));
        $updated_at = date('Y-m-d H:i:s', strtotime('+0 hours'));


        // Check if null
        if(($id_departemen == '') || ($id_departemen == 0)){
            $id_departemen = $request->id_departemen_ori;
        }

        if(($id_sub_departemen == '') || ($id_sub_departemen == 0)){
            $id_sub_departemen = $request->id_sub_departemen_ori;
        }

        if(($shift == '') || ($shift == 0)){
            $shift = $request->shift_ori;
        }

        $subdepartemen = DB::select("SELECT id_sub_departemen, nama_sub_departemen FROM vg_list_sub_departemen WHERE id_departemen =".$id_departemen);
        $mesin = DB::select("SELECT id_mesin, nama_mesin FROM vg_list_mesin WHERE id_sub_departemen =".$id_sub_departemen);

        if(($cek_id_header == '') || ($cek_id_header == '0')){
            $id_header = DB::select("SELECT id_inspeksi_header FROM vg_list_id_header");
            $id_header = $id_header[0]->id_inspeksi_header;
            $row = 1;
            // insert into database
            DB::table('draft_header')->insert([
                'id_inspeksi_header'    => $id_header,
                'type_form'             => $type_form,
                'tgl_inspeksi'          => $tgl_inspeksi,
                'shift'                 => $shift,
                'id_user'               => $id_user,
                'id_departemen'         => $id_departemen,
                'id_sub_departemen'     => $id_sub_departemen,
                'created_at'            => $created_at,
                'updated_at'            => $updated_at
            ]);
        } else {
            $id_header = $cek_id_header;
            // tidak insert karena sudah ada di database
            $row = 1;
        }

        // Parameters Detail
        $id_detail = DB::select("SELECT id_inspeksi_detail FROM vg_list_id_detail");
        $id_detail = $id_detail[0]->id_inspeksi_detail;
        $id_header = $id_header;
        $id_mesin = $request->id_mesin;
        $qty_1 = $request->qty_1;
        $qty_5 = $request->qty_1*5;
        $pic = $request->pic;
        $jam_mulai = $request->jam_mulai;
        $jam_selesai = $request->jam_selesai;
        $lama_inspeksi = 0;
        $jop = $request->jop;
        $item = $request->item;
        $id_defect = $request->id_defect;
        $kriteria = $request->kriteria;
        $qty_defect = $request->qty_defect;
        $qty_ready_pcs = $request->qty_ready_pcs;
        $qty_sampling = $request->qty_sampling;
        $penyebab = $request->penyebab;
        $status = $request->status;
        $keterangan = $request->keterangan;
        $creator = session()->get('id_user');
        $updater = session()->get('id_user');

        // insert into database
        DB::table('draft_detail')->insert([
            'id_inspeksi_detail'    => $id_detail,
            'id_inspeksi_header'    => $id_header,
            'id_mesin'              => $id_mesin,
            'qty_1'                 => $qty_1,
            'qty_5'                 => $qty_5,
            'pic'                   => $pic,
            'jam_mulai'             => $jam_mulai,
            'jam_selesai'           => $jam_selesai,
            'jop'                   => $jop,
            'item'                  => $item,
            'id_defect'             => $id_defect,
            'kriteria'              => $kriteria,
            'qty_defect'            => $qty_defect,
            'qty_ready_pcs'         => $qty_ready_pcs,
            'qty_sampling'          => $qty_sampling,
            'penyebab'              => $penyebab,
            'status'                => $status,
            'keterangan'            => $keterangan,
            'creator'               => $creator,
            'updater'               => $updater
        ]);

        if(($row == 0) || ($row == '')){
            alert()->success('Berhasil!', 'Data Sukses Disimpan!');
            return view('inspeksi.inline-input',[
                'departemen'        => $departemen,
                'subdepartemen'     => $subdepartemen,
                'mesin'             => $mesin,
                'defect'            => $defect,
                'menu'              => 'inspeksi',
                'sub'               => '/inline'
            ]);
        } else {
            alert()->success('Berhasil!', 'Data Sukses Disimpan!');
            return view('inspeksi.inline-input',[
                'id_header'         => $id_header,
                'tgl_inspeksi'      => $tgl_inspeksi,
                'shift'             => $shift,
                'id_departemen'     => $id_departemen,
                'departemen'        => $departemen,
                'id_sub_departemen' => $id_sub_departemen,
                'subdepartemen'     => $subdepartemen,
                'mesin'             => $mesin,
                'defect'            => $defect,
                'draft'             => $draft,
                'menu'              => 'inspeksi',
                'sub'               => '/inline'
            ]);
        }
        //End Controller Wawan
    }
            // Fungsi hapus data
            public function DeleteInlineData($id){
                $id = Crypt::decryptString($id);

                $inline_detail  = DB::table('draft_detail')->where('id_inspeksi_detail',$id)->delete();
                return redirect('/inline-input');

        }
}