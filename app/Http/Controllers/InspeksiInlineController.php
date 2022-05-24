<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

// Tambahkan source dibawah ini
use Illuminate\Support\Facades\DB;
use App\Models\InspeksiInlineModel;
use App\Models\DepartmentController;
use App\Models\SubDepartmentController;
use App\Models\MesinController;
use App\Models\DefectController;
use Image;
use File;
use Crypt;
use Redirect;
use RealRashid\SweetAlert\Facades\Alert;

class InspeksiInlineController extends Controller
{
    // Menampilkan list inspeksi inline
    public function InspeksiInlineList(){
        // Get all data from database
        // $inspeksiinline = InspeksiInlineModel::all();
        // $defect = DefectModel::all();
        // $inspeksiinline = InspeksiInlineModel::

        $inspeklist = DB::select("SELECT tgl_inspeksi, shift, nama_user, nama_departemen, nama_sub_departemen FROM vg_list_inline");

        return view('inspeksi.inspeksiinline-list',
        // compact('inspeksiinline'),
        [
            'menu'  => 'inspeksi',
            'sub'   => '/inspeksiinline',
            'inspeksiinline' => $inspeklist
        ]);
    }

    // Redirect ke window input inspeksi inline
    public function InspeksiInlineInput(){
        $departemen = DB::select('SELECT id_departemen, nama_departemen FROM vg_list_departemen');
        $mesin = DB::select('SELECT id_mesin, nama_mesin FROM vg_list_mesin');
        $defect = DB::select('SELECT id_defect, defect FROM vg_list_defect');

        return view('inspeksi.inspeksiinline-input',[
            'departemen'    => $departemen,
            'mesin'         => $mesin,
            'menu'  => 'inspeksi', // selalu ada di tiap function dan disesuaikan
            'sub'   => '/inspeksiinline'
        ]);
    }

    //Simpan data inspeksi inline
    public function SaveInspeksiInlineData(Request $request){
        $inspeksiheader = new InspeksiHeaderModel();
        $inspeksidetail = new InspeksiDetailModel();

        // Parameters
        $inspeksiheader->tgl_inspeksi = $request->tgl_inspeksi;
        $inspeksiheader->shift = strtoupper($request->shift);
        $inspeksiheader->id_user    = $request->id_user;
        $inspeksiheader->id_departemen = $request->id_departemen;
        $inspeksiheader->id_sub_departemen = $request->id_sub_departemen;

        $inspeksidetail->id_mesin = $request->id_mesin;
        $inspeksidetail->qty_1 = $request->qty_1; //100
        $inspeksidetail->qty_5 = $request->qty_1*5; //500
        $inspeksidetail->pic = $request->pic;
        $inspeksidetail->jam_mulai = $request->jam_mulai;
        $inspeksidetail->jam_selesai = $request->jam_selesai;
        $inspeksidetail->lama_inspeksi = 0;
        $inspeksidetail->jop = $request->jop;
        $inspeksidetail->item = $request->item;
        $inspeksidetail->id_defect = $request->id_defect;
        $inspeksidetail->kriteria = $request->kriteria;
        $inspeksidetail->qty_defect = $request->qty_defect;
        $inspeksidetail->qty_ready_pcs = $request->qty_ready_pcs;
        $inspeksidetail->qty_sampling = $request->qty_sampling;
        $inspeksidetail->penyebab = $request->penyebab;
        $inspeksidetail->status = $request->status;
        $inspeksidetail->keterangan = $request->keterangan;
        $inspeksidetail->creator = 0;

        // Insert data into database
        $inspeksiinline->save();
        $inspeksidetail->save();

            alert()->success('Berhasil!', 'Data Sukses Disimpan!');
            return redirect('/inspeksiinline');
    }

    // fungsi untuk redirect ke halaman edit
    public function EditInspeksiInlineData($id){
        $id = Crypt::decrypt($id);
        $departemen = DB::select('SELECT id_departemen, nama_departemen FROM vg_list_departemen');
        $mesin = DB::select('SELECT id_mesin, nama_mesin FROM vg_list_mesin');

        // Select data based on ID
        $inspekinl = InspeksiInlineModel::find($id);

        return view('inspeksi.inspeksiinline-edit',[
            'departemen'    => $departemen,
            'mesin' => $mesin,
            'inspekinline' => $inspekinl,
            'menu'  => 'inspeksi', // selalu ada di tiap function dan disesuaikan
            'sub'   => '/inspeksiinline'
        ]);
    }

    // simpan perubahan dari data yang sudah di edit
    public function SaveEditInspeksiInlineData(Request $request){

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
