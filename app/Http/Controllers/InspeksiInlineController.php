<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

// Tambahkan source dibawah ini
use Illuminate\Support\Facades\DB;
use App\Models\InspeksiHeaderModel;
use App\Models\InspeksiDetailModel;
use App\Models\DepartmentModel;
use App\Models\SubDepartmentModel;
use App\Models\MesinModel;
use App\Models\DefectModel;
use Image;
use File;
use Crypt;
use Redirect;
use RealRashid\SweetAlert\Facades\Alert;

class InspeksiInlineController extends Controller
{
    // Menampilkan list inspeksi inline
    public function InlineList(){
        $inline = DB::select("SELECT tgl_inspeksi, shift, nama_user, nama_departemen, nama_sub_departemen FROM vg_list_inline");

        return view('inspeksi.inline-list',
        [
            'menu'  => 'inspeksi',
            'sub'   => '/inline',
            'inline' => $inline
        ]);
    }

    // Redirect ke window input inspeksi inline
    public function InlineInput(){
        $departemen = DB::select('SELECT id_departemen, nama_departemen FROM vg_list_departemen');
        $subdepartemen = DB::select('SELECT id_sub_departemen, nama_sub_departemen FROM vg_list_sub_departemen');
        $mesin = DB::select('SELECT id_mesin, nama_mesin FROM vg_list_mesin');
        $defect = DB::select('SELECT id_defect, defect FROM vg_list_defect');
        $users = DB::select('SELECT id_user, nama_user FROM vw_list_users');

        return view('inspeksi.inline-input',[
            'departemen'    => $departemen,
            'mesin'         => $mesin,
            'subdepartemen' => $subdepartemen,
            'defect'        => $defect,
            'users'         => $users,
            'menu'  => 'inspeksi', // selalu ada di tiap function dan disesuaikan
            'sub'   => '/inline'
        ]);
    }

    //Simpan data inspeksi inline
    public function SaveInlineData(Request $request){
        $inlineheader = new InspeksiHeaderModel();
        $inlinedetail = new InspeksiDetailModel();

        // Parameters
        $inlineheader->tgl_inspeksi = $request->tgl_inspeksi;
        $inlineheader->shift = strtoupper($request->shift);
        $inlineheader->id_user    = $request->id_user;
        $inlineheader->id_departemen = $request->id_departemen;
        $inlineheader->id_sub_departemen = $request->id_sub_departemen;

        $inlinedetail->id_mesin = $request->id_mesin;
        $inlinedetail->qty_1 = $request->qty_1; //100
        $inlinedetail->qty_5 = $request->qty_1*5; //500
        $inlinedetail->pic = $request->pic;
        $inlinedetail->jam_mulai = $request->jam_mulai;
        $inlinedetail->jam_selesai = $request->jam_selesai;
        $inlinedetail->lama_inspeksi = 0;
        $inlinedetail->jop = $request->jop;
        $inlinedetail->item = $request->item;
        $inlinedetail->id_defect = $request->id_defect;
        $inlinedetail->kriteria = $request->kriteria;
        $inlinedetail->qty_defect = $request->qty_defect;
        $inlinedetail->qty_ready_pcs = $request->qty_ready_pcs;
        $inlinedetail->qty_sampling = $request->qty_sampling;
        $inlinedetail->penyebab = $request->penyebab;
        $inlinedetail->status = $request->status;
        $inlinedetail->keterangan = $request->keterangan;
        $inlinedetail->creator = 0;

        // Insert data into database
        $inlineheader->save();
        $inlinedetail->save();

            alert()->success('Berhasil!', 'Data Sukses Disimpan!');
            return redirect('/inline');
    }

    // fungsi untuk redirect ke halaman edit
    public function EditInlineData($id){
        $id = Crypt::decrypt($id);
        $departemen = DB::select('SELECT id_departemen, nama_departemen FROM vg_list_departemen');
        $subdepartemen = DB::select('SELECT id_sub_departemen, nama_sub_departemen FROM vg_list_departemen');
        $mesin = DB::select('SELECT id_mesin, nama_mesin FROM vg_list_mesin');

        // Select data based on ID
        $inspekinl = InspeksiHeaderModel::find($id);

        return view('inspeksi.inline-edit',[
            'departemen'    => $departemen,
            'subdepartemen' => $subdepartemen,
            'mesin' => $mesin,
            'inline' => $inspekinl,
            // 'inspeksidetail'    => $inspekinl,
            'menu'  => 'inspeksi', // selalu ada di tiap function dan disesuaikan
            'sub'   => '/inline'
        ]);
    }

    // simpan perubahan dari data yang sudah di edit
    public function SaveEditInlineData(Request $request){

        $shift = strtoupper($request->shift);
        $id_user    = $request->id_user;
        $id_departemen = $request->id_departemen;
        $id_sub_departemen = $request->id_sub_departemen;
        $id_mesin = $request->id_mesin;
        $qty_1 = $request->qty_1;
        $qty_5 = $request->qty_5;
        $pic = $request->pic;
        $jam_mulai = $request->jam_mulai;
        $jam_selesai = $request->jam_selesai;
        $lama_inspeksi = $request->lama_inspeksi;
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
        $creator = session()->get('user_id');
        $updated_at = date('Y-m-d H:i:s', strtotime('+0 hours'));

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

}
