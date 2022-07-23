<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

// Tambahkan source dibawah ini
use Illuminate\Support\Facades\DB;
use App\Models\DefectModel;
use Image;
use File;
use date;
use Crypt;
use Redirect;
use RealRashid\SweetAlert\Facades\Alert;

class DefectController extends Controller
{
    // Menampilkan list defect
    public function defectlist() {
        // Get all data from database
        $defect = DB::select("SELECT * FROM vg_list_defect");
        $jenis_user = session()->get('jenis_user');

        return view('admin.master.defect-list',[
            'menu'          => 'master',
            'sub'           => '/defect',
            'defect'        => $defect,
            'jenis_user'    => $jenis_user
        ]);
    }

    public function getSubDefect($id){
        $defect = DB::select("SELECT id_defect, defect FROM tb_master_defect WHERE id_departemen = ".$id);
        return json_encode($defect);
    }

    public function getKriteria($id){
        $kriteria = DB::select("SELECT kriteria FROM vw_dropdown_kriteria WHERE id_defect = ".$id);
        return json_encode($kriteria);
    }

    // Redirect ke window input defect
    public function DefectInput(){
        $departemen = DB::select('SELECT id_departemen, nama_departemen FROM vg_list_departemen');
        $jenis_user = session()->get('jenis_user');

        return view('admin.master.defect-input',[
            'departemen'   => $departemen,
            'menu'          => 'master', // selalu ada di tiap function dan disesuaikan
            'sub'           => '/defect',
            'jenis_user'    => $jenis_user
        ]);
    }

    //Simpan data defect
    public function SaveDefectData(Request $request){
        $defect = new DefectModel();

        // Parameters
        $defect->id_departemen = $request->id_departemen;
        $defect->kode_defect = strtoupper($request->kode_defect);
        $defect->defect = strtoupper($request->defect);
        $defect->critical = $request->critical;
        $defect->major = $request->major;
        $defect->minor = $request->minor;
        $jenis_user = session()->get('jenis_user');

        // Check duplicate kode
        $kode_check = DB::select("SELECT kode_defect FROM vg_list_defect WHERE kode_defect = '".$defect->kode_defect."'");
        if (isset($kode_check['0'])) {
            alert()->error('Gagal Menyimpan!', 'Maaf, Kode Defect Ini Sudah Didaftarkan Dalam Sistem!');
            return Redirect::back();
        }

        // Check duplicate defect
        $defect_check = DB::select("SELECT defect FROM vg_list_defect WHERE defect = '".$defect->defect."'");
        if (isset($defect_check['0'])) {
            alert()->error('Gagal Menyimpan!', 'Maaf, Defect Ini Sudah Didaftarkan Dalam Sistem!');
            return Redirect::back();
        }

       // Insert data into database
        $defect->save();
            alert()->success('Berhasil!', 'Data Sukses Disimpan!');
            return redirect('/defect');
    }

    // fungsi untuk redirect ke halaman edit
    public function EditDefectData($id){
        $id = Crypt::decrypt($id);
        $departemen = DB::select('SELECT id_departemen, nama_departemen FROM vg_list_departemen');
        $jenis_user = session()->get('jenis_user');

        // Select data based on ID
        $def = DefectModel::find($id);

        return view('admin.master.defect-edit', [
            'menu'          => 'master',
            'sub'           => '/defect',
            'defect'        => $def,
            'departemen'    => $departemen,
            'jenis_user'    => $jenis_user
        ]);
    }

    // simpan perubahan dari data yang sudah di edit
    public function SaveEditDefectData(Request $request){
        $id_defect              = $request->id_defect;
        $id_departemen          = $request->id_departemen;
        $kode_defect            = strtoupper($request->kode_defect);
        $defect                 = strtoupper($request->defect);
        $updated_at             = date('Y-m-d H:i:s', strtotime('+0 hours'));

        // Is there a change in kode data?
        if ($request->defect <> $request->original_defect){
        //cek apakah sudah ada di db
        $defect_check = DB::select("SELECT defect FROM vg_list_defect WHERE defect = '".$defect."'");
            if (isset($defect_check['0'])) {
                alert()->error('Gagal Menyimpan!', 'Maaf, Nama Ini Sudah Digunakan');
                return Redirect::back();
            } else {
                //update data into db
                DefectModel::where('id_defect', $id_defect)->update([
                    'kode_defect'       => $kode_defect,
                    'defect'            => $defect,
                    'id_departemen'     => $id_departemen,
                    'updated_at'        => $updated_at,
                ]);
                alert()->success('Sukses!', 'Data Berhasil Diperbarui!');
                return redirect('/defect');
            }
        } else {
             //update data into db
             DefectModel::where('id_defect', $id_defect)->update([
                'kode_defect'       => $kode_defect,
                'defect'            => $defect,
                'id_departemen'     => $id_departemen,
                'updated_at'        => $updated_at,
            ]);
            alert()->success('Sukses!', 'Data Berhasil Diperbarui!');
            return redirect('/defect');
    }


    }

    // Fungsi hapus data
    public function DeleteDefectData($id){
        $id = Crypt::decryptString($id);
        $jenis_user = session()->get('jenis_user');

        $creator_check = DB::select('SELECT * FROM tb_inspeksi_detail WHERE creator = '.$id);
        // Check user already used in other table or not yet
        if (isset($creator_check[0])) {
            Alert::error("Gagal!", 'Data ini tidak dapat dihapus karena sudah dipakai tabel lain!');
            return Redirect::back();
        } else {
            // Delete process
            $defect = DefectModel::find($id);
            $defect->delete();

            // Move to department list page
            alert()->success('Berhasil!', 'Berhasil Menghapus Data!');
            return redirect('/defect');
        }
    }
}
