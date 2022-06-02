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

class InspeksiFinalController extends Controller
{
    // Menampilkan list inspeksi final
    public function FinalList(){
<<<<<<< HEAD
        $final = DB::select("SELECT tgl_inspeksi, shift, nama_user, nama_departemen, nama_sub_departemen FROM vg_list_inline");

        return view('admin.inspeksi.final-list',
        [
            'menu'  => 'inspeksi',
            'sub'   => '/final',
            'final' => $final
=======
        $list_final = DB::select('SELECT * FROM vg_list_final');

        return view('inspeksi.final-list',
        [
            'menu'      => 'inspeksi',
            'sub'       => '/final',
            'final'     => $list_final,
>>>>>>> e66c3fa489879a92896867fb708ca2a31895f690
        ]);
    }

    // Redirect ke window input inspeksi final
    public function FinalInput(){
        $departemen = DB::select("SELECT id_departemen, nama_departemen FROM vg_list_departemen");
<<<<<<< HEAD
        // $subdepartemen = DB::select("SELECT id_sub_departemen, nama_sub_departemen FROM vg_list_sub_departemen");
        // $mesin = DB::select("SELECT id_mesin, nama_mesin FROM vg_list_mesin");
        $defect = DB::select("SELECT id_defect, defect FROM vg_list_defect");
        $draftheader = DB::select("SELECT tgl_inspeksi, shift, nama_user, nama_departemen, nama_sub_departemen FROM vg_draft_header");
        $draftdetail = DB::select("SELECT * FROM vg_draft_detail");

        return view('admin.inspeksi.final-input',[
            'departemen'    => $departemen,
            // 'mesin'         => $mesin,
            // 'subdepartemen' => $subdepartemen,
            'defect'        => $defect,
            'draftheader'   => $draftheader,
            'draftdetail'   => $draftdetail,
            'menu'          => 'final', // selalu ada di tiap function dan disesuaikan
=======
        $defect = DB::select("SELECT id_defect, defect FROM vg_list_defect");
        $draft = DB::select("SELECT * FROM vg_draft_final WHERE id_user =".session()->get('id_user')); // Select untuk list draft sesuai session user login

        return view('inspeksi.final-input',[
            'departemen'    => $departemen,
            'defect'        => $defect,
            'draft'         => $draft,
            'menu'          => 'inspeksi', // selalu ada di tiap function dan disesuaikan
>>>>>>> e66c3fa489879a92896867fb708ca2a31895f690
            'sub'           => '/final'
        ]);
    }

    //Simpan data inspeksi final
    public function SaveFinalData(Request $request){
        // Controller Wawan
        $row = 0;
        $cek_id_header = $request->id_inspeksi_header;
        $departemen = DB::select("SELECT id_departemen, nama_departemen FROM vg_list_departemen");
        $defect = DB::select("SELECT id_defect, defect FROM vg_list_defect");
<<<<<<< HEAD
        $draftheader = DB::select("SELECT tgl_inspeksi, shift, nama_user, nama_departemen, nama_sub_departemen FROM vg_draft_header");
        $draftdetail = DB::select("SELECT * FROM vg_draft_detail");

        // Parameters Header
        $type_form = "final"; // Final
=======
        $draft = DB::select("SELECT * FROM vg_draft_final WHERE id_user =".session()->get('id_user')); // Select untuk list draft sesuai session user login

        // Parameters Header
        $type_form = "Final"; // Final
>>>>>>> e66c3fa489879a92896867fb708ca2a31895f690
        $tgl_inspeksi = $request->tgl_inspeksi;
        $shift = strtoupper($request->shift);
        $id_user = session()->get('id_user');
        $id_departemen = $request->id_departemen;
        $id_sub_departemen = $request->id_sub_departemen;
<<<<<<< HEAD
        $subdepartemen = DB::select("SELECT id_sub_departemen, nama_sub_departemen FROM vg_list_sub_departemen WHERE id_departemen =".$id_departemen);
        $mesin = DB::select("SELECT id_mesin, nama_mesin FROM vg_list_mesin WHERE id_sub_departemen =".$id_sub_departemen);
        $created_at = date('Y-m-d H:i:s', strtotime('+0 hours'));
        $updated_at = date('Y-m-d H:i:s', strtotime('+0 hours'));

        
=======
        $created_at = date('Y-m-d H:i:s', strtotime('+0 hours'));
        $updated_at = date('Y-m-d H:i:s', strtotime('+0 hours'));


>>>>>>> e66c3fa489879a92896867fb708ca2a31895f690
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

<<<<<<< HEAD
=======
        $subdepartemen = DB::select("SELECT id_sub_departemen, nama_sub_departemen FROM vg_list_sub_departemen WHERE id_departemen =".$id_departemen);

>>>>>>> e66c3fa489879a92896867fb708ca2a31895f690
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
<<<<<<< HEAD
            // tidak insert karena sudah ada di database 
            $row = 1;
        }
            
=======
            // tidak insert karena sudah ada di database
            $row = 1;
        }

>>>>>>> e66c3fa489879a92896867fb708ca2a31895f690
        // Parameters Detail
        $id_detail = DB::select("SELECT id_inspeksi_detail FROM vg_list_id_detail");
        $id_detail = $id_detail[0]->id_inspeksi_detail;
        $id_header = $id_header;
<<<<<<< HEAD
        $id_mesin  = $request->id_mesin;
=======
>>>>>>> e66c3fa489879a92896867fb708ca2a31895f690
        $jam_mulai = $request->jam_mulai;
        $jam_selesai = $request->jam_selesai;
        $lama_inspeksi = 0;
        $jop = $request->jop;
        $item = $request->item;
        $id_defect = $request->id_defect;
        $kriteria = $request->kriteria;
        $qty_defect = $request->qty_defect;
<<<<<<< HEAD
        $qty_ready_pcs = $request->qty_ready_pcs;
=======
        $penyebab = $request->penyebab;
>>>>>>> e66c3fa489879a92896867fb708ca2a31895f690
        $status = $request->status;
        $keterangan = $request->keterangan;
        $qty_ready_pack = $request->qty_ready_pack;
        $qty_sample_aql = $request->qty_sample_aql;
        $qty_sample_riil = $request->qty_sample_riil;
        $qty_reject_all = $request->qty_reject_all;
        $hasil_verifikasi = $request->hasil_verifikasi;
        $creator = session()->get('id_user');
        $updater = session()->get('id_user');
<<<<<<< HEAD
=======
        $created_at = date('Y-m-d H:i:s', strtotime('+0 hours'));
        $updated_at = date('Y-m-d H:i:s', strtotime('+0 hours'));
>>>>>>> e66c3fa489879a92896867fb708ca2a31895f690

        // insert into database
        DB::table('draft_detail')->insert([
            'id_inspeksi_detail'    => $id_detail,
            'id_inspeksi_header'    => $id_header,
<<<<<<< HEAD
            'id_mesin'              => $id_mesin,
=======
>>>>>>> e66c3fa489879a92896867fb708ca2a31895f690
            'jam_mulai'             => $jam_mulai,
            'jam_selesai'           => $jam_selesai,
            'jop'                   => $jop,
            'item'                  => $item,
            'id_defect'             => $id_defect,
            'kriteria'              => $kriteria,
            'qty_defect'            => $qty_defect,
<<<<<<< HEAD
            'qty_ready_pcs'         => $qty_ready_pcs,
=======
            'penyebab'              => $penyebab,
>>>>>>> e66c3fa489879a92896867fb708ca2a31895f690
            'status'                => $status,
            'keterangan'            => $keterangan,
            'qty_ready_pack'        => $qty_ready_pack,
            'qty_sample_aql'        => $qty_sample_aql,
            'qty_sample_riil'       => $qty_sample_riil,
            'qty_reject_all'        => $qty_reject_all,
<<<<<<< HEAD
            'creator'               => $creator,
            'updater'               => $updater
=======
            'hasil_verifikasi'      => $hasil_verifikasi,
            'creator'               => $creator,
            'updater'               => $updater,
            'created_at'            => $created_at,
            'updated_at'            => $updated_at
>>>>>>> e66c3fa489879a92896867fb708ca2a31895f690
        ]);

        if(($row == 0) || ($row == '')){
            alert()->success('Berhasil!', 'Data Sukses Disimpan!');
            return view('inspeksi.final-input',[
                'departemen'        => $departemen,
                'subdepartemen'     => $subdepartemen,
<<<<<<< HEAD
                'mesin'             => $mesin,
                'defect'            => $defect,
                'draftheader'       => $draftheader,
                'draftdetail'       => $draftdetail,
=======
                'defect'            => $defect,
>>>>>>> e66c3fa489879a92896867fb708ca2a31895f690
                'menu'              => 'inspeksi',
                'sub'               => '/final'
            ]);
        } else {
            alert()->success('Berhasil!', 'Data Sukses Disimpan!');
            return view('inspeksi.final-input',[
                'id_header'         => $id_header,
                'tgl_inspeksi'      => $tgl_inspeksi,
                'shift'             => $shift,
                'id_departemen'     => $id_departemen,
                'departemen'        => $departemen,
                'id_sub_departemen' => $id_sub_departemen,
                'subdepartemen'     => $subdepartemen,
<<<<<<< HEAD
                'mesin'             => $mesin,
                'defect'            => $defect,
                'draftheader'       => $draftheader,
                'draftdetail'       => $draftdetail,
=======
                'defect'            => $defect,
                'draft'             => $draft,
>>>>>>> e66c3fa489879a92896867fb708ca2a31895f690
                'menu'              => 'inspeksi',
                'sub'               => '/final'
            ]);
        }
        //End Controller Wawan
    }
<<<<<<< HEAD

    //  fungsi untuk redirect ke halaman edit
    // public function EditInlineData($id){
    //     $id = Crypt::decrypt($id);
    //     $departemen = DB::select("SELECT id_departemen, nama_departemen FROM vg_list_departemen");
    //     $subdepartemen = DB::select("SELECT id_sub_departemen, nama_sub_departemen FROM vg_list_departemen");
    //     $mesin = DB::select("SELECT id_mesin, nama_mesin FROM vg_list_mesin");

    //     // Select data based on ID
    //     $inspekinl = InspeksiHeaderModel::find($id);

    //     return view('inspeksi.inline-edit',[
    //         'departemen'    => $departemen,
    //         'subdepartemen' => $subdepartemen,
    //         'mesin' => $mesin,
    //         'inline' => $inspekinl,
    //         // 'inspeksidetail'    => $inspekinl,
    //         'menu'  => 'inspeksi', // selalu ada di tiap function dan disesuaikan
    //         'sub'   => '/inline'
    //     ]);
    // }

    // simpan perubahan dari data yang sudah di edit
    // public function SaveEditInlineData(Request $request){
        // call sequence number header
        // $id_header = A401


        // $count_data = 10

        // call sequence number detail
        // for (i=0; i<10; i++)
            // $id_detail = DB::select("SELECT id_detail FROM view_id_detail");

            // simpan variable detail dengan  $id_detail = && $id_header =

        // end for

        // $shift = strtoupper($request->shift);
        // $id_user    = $request->id_user;
        // $id_departemen = $request->id_departemen;
        // $id_sub_departemen = $request->id_sub_departemen;
        // $id_mesin = $request->id_mesin;
        // $qty_1 = $request->qty_1;
        // $qty_5 = $request->qty_5;
        // $pic = $request->pic;
        // $jam_mulai = $request->jam_mulai;
        // $jam_selesai = $request->jam_selesai;
        // $lama_inspeksi = $request->lama_inspeksi;
        // $jop = $request->jop;
        // $item = $request->item;
        // $id_defect = $request->id_defect;
        // $kriteria = $request->kriteria;
        // $qty_defect = $request->qty_defect;
        // $qty_ready_pcs = $request->qty_ready_pcs;
        // $qty_sampling = $request->qty_sampling;
        // $penyebab = $request->penyebab;
        // $status = $request->status;
        // $keterangan = $request->keterangan;
        // $creator = session()->get('user_id');
        // $updated_at = date('Y-m-d H:i:s', strtotime('+0 hours'));

        // // Is there a change in kode data?
        // if ($request->nama_sub_departemen <> $request->original_nama_sub_departemen){
        //     //cek apakah sudah ada di db
        //     $namasub_check = DB::select("SELECT nama_sub_departemen FROM vg_list_sub_departemen WHERE nama_sub_departemen = '".$nama_sub_departemen."'");
        //     if (isset($namasub_check['0'])) {
        //         alert()->error('Gagal Menyimpan!', 'Maaf, Nama Ini Sudah Digunakan');
        //         return Redirect::back();
        //     } else {
        //         //update data into db
        //         SubDepartmentModel::where('id_sub_departemen', $id_sub_departemen)->update([
        //             'id_departemen'               => $id_departemen,
        //             'kode_sub_departemen'         => $kode_sub_departemen,
        //             'nama_sub_departemen'         => $nama_sub_departemen,
        //             'updated_at'                  => $updated_at,
        //         ]);
        //         alert()->success('Sukses!', 'Data Berhasil Diperbarui!');
        //         return redirect('/subdepartment');
        //     }
        // } else  {
        //     // Update data into database
        //     SubDepartmentModel::where('id_sub_departemen', $id_sub_departemen)->update([
        //         'id_departemen'               => $id_departemen,
        //         'kode_sub_departemen'         => $kode_sub_departemen,
        //         'nama_sub_departemen'         => $nama_sub_departemen,
        //         'updated_at'                  => $updated_at,
        //     ]);

        //     alert()->success('Sukses!', 'Data Berhasil Diperbarui!');
        //     return redirect('/subdepartment');
        // }
    }


=======
            // Fungsi hapus data
            public function DeleteFinalData($id){
                $id = Crypt::decryptString($id);

                $final_detail  = DB::table('draft_detail')->where('id_inspeksi_detail',$id)->delete();
                return redirect('/final-input');
        }
}
>>>>>>> e66c3fa489879a92896867fb708ca2a31895f690
