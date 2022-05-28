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
        $inline = DB::select('SELECT tgl_inspeksi, shift, nama_user, nama_departemen,  nama_sub_departemen FROM vg_draft_header');

        return view('inspeksi.inline-list',
        [
            'menu'      => 'inspeksi',
            'sub'       => '/inline',
            'inline'    => $inline,
        ]);
    }

    // Redirect ke window input inspeksi inline
    public function InlineInput(){
        $departemen = DB::select("SELECT id_departemen, nama_departemen FROM vg_list_departemen");
        $subdepartemen = DB::select("SELECT id_sub_departemen, nama_sub_departemen FROM vg_list_sub_departemen");
        $mesin = DB::select("SELECT id_mesin, nama_mesin FROM vg_list_mesin");
        $defect = DB::select("SELECT id_defect, defect FROM vg_list_defect");
        $users = DB::select("SELECT id_user, nama_user FROM vw_list_users");
        $draftheader = DB::select("SELECT tgl_inspeksi, shift, nama_user, nama_departemen, nama_sub_departemen FROM vg_draft_header");
        $draftdetail = DB::select("SELECT * FROM vg_draft_detail");
        $id_header = DB::select("SELECT id_inspeksi_header FROM vg_list_id_header");
        $id_detail = DB::select("SELECT id_inspeksi_detail FROM vg_list_id_detail");

        return view('inspeksi.inline-input',[
            'departemen'    => $departemen,
            'mesin'         => $mesin,
            'subdepartemen' => $subdepartemen,
            'defect'        => $defect,
            'users'         => $users,
            'draftheader'   => $draftheader,
            'draftdetail'   => $draftdetail,
            'id_header'     => $id_header,
            'id_detail'     => $id_detail,

            'menu'          => 'inspeksi', // selalu ada di tiap function dan disesuaikan
            'sub'           => '/inline'

        ]);
    }

    //Simpan data inspeksi inline
    public function SaveInlineData(Request $request){
        // Parameters Header
        $id_header = $request->id_inspeksi_header;
        $tgl_inspeksi = $request->tgl_inspeksi;
        $shift = strtoupper($request->shift);
        $id_user = session()->get('id_user');
        $id_departemen = $request->id_departemen;
        $id_sub_departemen = $request->id_sub_departemen;
        // $created_at = Carbon::now()->timestamp;
        // $updated_at = Carbon::now()->timestamp;


        // Parameter detail
        $id_detail = $request->id_inspeksi_detail;
        $id_mesin = $request->id_mesin;
        $qty_1 = $request->qty_1;
        $qty_5 = $request->qty_1*5;
        $pic    = $request->pic;
        $jam_mulai  = $request->jam_mulai;
        $jam_selesai    = $request->jam_selesai;
        $jop        = $request->jop;
        $item       = $request->item;
        $id_defect  = $request->id_defect;
        $kriteria    = $request->kriteria;
        $qty_defect = $request->qty_defect;
        $qty_ready_pcs  = $request->qty_ready_pcs;
        $qty_sample_aql = $request->qty_sample_aql;
        $qty_sample_riil    = $request->qty_sample_riil;
        $qty_reject_all  = $request->qty_reject_all;
        $hasil_verifikasi   = $request->hasil_verifikasi;
        $ket_status     = $request->status;
        $keterangan     = $request->keterangan;
        $creator        = session()->get('id_user');
        $updater        = session()->get('id_user');
        // $created_at     = Carbon::now()->timestamp;
        // $updated_at     = Carbon::now()->timestamp;


        //function laravel untuk simpan / insert data into database
        // Konsep menjadi VC

            $id_header = $request->input('id_inspeksi_header');
            $tgl_inspeksi = $request->input('tgl_inspeksi');
            $shift = $request->input('shift');
            $id_user = session()->get('id_user');
            $id_departemen = $request->input('id_departemen');
            $id_sub_departemen = $request->input('id_sub_departemen');
            $created_at = $request->input('created_at');
            $updated_at = $request->input('updated_at');
            $data=array('id_inspeksi_header'=>$id_header,"tgl_inspeksi"=>$tgl_inspeksi,"shift"=>$shift,"id_user"=>$id_user, "id_departemen"=>$id_departemen, "id_sub_departemen"=>$id_sub_departemen);
            DB::table('draft_header')->insert($data);


            $id_detail = $request->input('id_inspeksi_detail');
            $id_mesin = $request->input('id_mesin');
            $qty_1 = $request->input('qty_1');
            $qty_5 = $request->qty_1*5;
            $pic    = $request->input('pic');
            $jam_mulai  = $request->input('jam_mulai');
            $jam_selesai    = $request->input('jam_selesai');
            $jop        = $request->input('jop');
            $item       = $request->input('item');
            $id_defect  = $request->input('id_defect');
            $kriteria    = $request->input('kriteria');
            $ket_status     = $request->input('status');
            $qty_defect = $request->input('qty_defect');
            $qty_ready_pcs  = $request->input('qty_ready_pcs');
            $qty_sample_aql = $request->input('qty_sample_aql');
            $qty_sample_riil    = $request->input('qty_sample_riil');
            $qty_reject_all  = $request->input('qty_reject_all');
            $hasil_verifikasi   = $request->input('hasil_verifikasi');
            $keterangan     = $request->input('keterangan');
            $creator        = session()->get('id_user');
            $updater        = session()->get('id_user');
            // $created_at     = Carbon::now()->timestamp;
            // $updated_at     = Carbon::now()->timestamp;
            $data2=array('id_inspeksi_detail'=>$id_detail,'id_inspeksi_header'=>$id_header,"id_mesin"=>$id_mesin,"qty_1"=>$qty_1,"qty_5"=>$qty_5, "pic"=>$pic, "jam_mulai"=>$jam_mulai, "jam_selesai"=>$jam_selesai, "status"=>$ket_status, "keterangan"=>$keterangan,
            'jop'=>$jop,"item"=>$item,"id_defect"=>$id_defect,"kriteria"=>$kriteria, "qty_defect"=>$qty_defect, "qty_ready_pcs"=>$qty_ready_pcs, "qty_sample_aql"=>$qty_sample_aql,
            'qty_sample_riil'=>$qty_sample_riil,"qty_reject_all"=>$qty_reject_all,"hasil_verifikasi"=>$hasil_verifikasi,"creator"=>$creator, "updater"=>$updater, "created_at"=>$created_at, "updated_at"=>$updated_at);
            DB::table('draft_detail')->insert($data2);


        //set value from parameter into model
        // $draftheader->tgl_inspeksi = $tgl_inspeksi;
        // $draftheader->shift = $shift;
        // $draftheader->id_user    = session()->get('id_user');
        // $draftheader->id_departemen = $request->id_departemen;
        // $draftheader->id_sub_departemen = $request->id_sub_departemen;

        // $draftdetail->id_mesin = $request->id_mesin;
        // $draftdetail->qty_1 = $request->qty_1; //100
        // $draftdetail->qty_5 = $request->qty_1*5; //500
        // $draftdetail->pic = $request->pic;
        // $draftdetail->jam_mulai = $request->jam_mulai;
        // $draftdetail->jam_selesai = $request->jam_selesai;
        // $draftdetail->lama_inspeksi = 0;
        // $draftdetail->jop = $request->jop;
        // $draftdetail->item = $request->item;
        // $draftdetail->id_defect = $request->id_defect;
        // $draftdetail->kriteria = $request->kriteria;
        // $draftdetail->qty_defect = $request->qty_defect;
        // $draftdetail->qty_ready_pcs = $request->qty_ready_pcs;
        // $draftdetail->qty_sampling = $request->qty_sampling;
        // $draftdetail->penyebab = $request->penyebab;
        // $draftdetail->status = 0;
        // $draftdetail->keterangan = $request->keterangan;
        // $draftdetail->creator = 0;

        // Insert data into database
        // $draftheader->save();
        // $draftdetail->save();

        alert()->success('Berhasil!', 'Data Sukses Disimpan!');
        return redirect('/inline-input');
    }

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
    // }

}



// -- public.vg_draft_header source

// CREATE OR REPLACE VIEW public.vg_draft_header
// AS SELECT h.id_inspeksi_header,
//     h.type_form,
//     h.tgl_inspeksi,
//     h.shift,
//     u.nama_user,
//     dp.nama_departemen,
//     sd.nama_sub_departemen,
//     h.created_at,
//     h.updated_at
//    FROM draft_header h
//      LEFT JOIN tb_master_users u ON h.id_user = u.id_user
//      LEFT JOIN tb_master_departemen dp ON h.id_departemen = dp.id_departemen
//      LEFT JOIN tb_master_sub_departemen sd ON h.id_sub_departemen = sd.id_sub_departemen;
