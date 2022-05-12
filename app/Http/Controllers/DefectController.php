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
    public function defectlist(){
        // Get all data from database
        $defect = DefectModel::all();

        return view('admin.master.defect-list',[
            'menu'  => 'master',
            'sub'   => '/defect',
            'defect' => $defect
        ]);
    }

    // Redirect ke window input defect
    public function DefectInput(){
        return view('admin.master.defect-input',[
            'menu'  => 'master', // selalu ada di tiap function dan disesuaikan
            'sub'   => '/defect'
        ]);
    }

    //Simpan data defect
    public function SaveDefectData(Request $request){
        $defect = new DefectModel();

        // Parameters
        $defect->kode_defect = $request->kode_defect;
        $defect->defect = $request->defect;

        // Check duplicate kode
        $kode_check = DB::select("SELECT kode_defect FROM vg_list_defect WHERE kode_defect = '".$request->kode_defect."'");
        if (isset($kode_check['0'])) {  
            alert()->error('Gagal Menyimpan!', 'Maaf, kode defect ini sudah didaftarkan dalam sistem!');
            return Redirect::back();
        }

        // Check duplicate defect
        $defect_check = DB::select("SELECT defect FROM vg_list_defect WHERE defect = '".$request->defect."'");
        if (isset($defect_check['0'])) {  
            alert()->error('Gagal Menyimpan!', 'Maaf, defect ini sudah didaftarkan dalam sistem!');
            return Redirect::back();
        }        


       // Insert data into database
        $defect->save();
            alert()->success('Berhasil!', 'Data sukses disimpan!');
            return redirect('/defect');
    }


    // fungsi untuk redirect ke halaman edit
    public function EditDefectData($id){
        $id = Crypt::decrypt($id);

        // Select data based on ID
        $def = DefectModel::find($id);
        
        return view('admin.master.defect-edit', [
            'menu'  => 'master',
            'sub'   => '/defect',
            'defect' => $def,
        ]);
    }

    // simpan perubahan dari data yang sudah di edit
    public function SaveEditDefectData(Request $request){
        $id_defect = $request->id_defect;
        $kode_defect = $request->kode_defect;
        $defect = $request->defect;
        $updated_at = date('Y-m-d H:i:s', strtotime('+0 hours'));
 


        // return $request;

        // Check duplicate kode
        $kode_check = DB::select("SELECT kode_defect FROM vg_list_defect WHERE kode_defect = '".$request->kode_defect."'");
        if (isset($kode_check['0'])) {  
            alert()->error('Gagal Menyimpan!', 'Maaf, kode defect ini sudah didaftarkan dalam sistem!');
            return Redirect::back();
        }

        // Check duplicate defect
        $defect_check = DB::select("SELECT defect FROM vg_list_defect WHERE defect = '".$request->defect."'");
        if (isset($defect_check['0'])) {  
            alert()->error('Gagal Menyimpan!', 'Maaf, defect ini sudah didaftarkan dalam sistem!');
            return Redirect::back();
        }     


        {
            // Update data into database
            DefectModel::where('id_defect', $id_defect)->update([
                'kode_defect'              => $kode_defect,
                'defect'                   => $defect,
                'updated_at'               => $updated_at,
            ]);
            
            alert()->success('Sukses!', 'Data berhasil diperbarui!');
            return redirect('/defect');
        }
    } 
    

    // Fungsi hapus data
    public function DeleteDefectData($id){
        $id = Crypt::decryptString($id);
        
        // Select table user to get user default value
        // $def = DefectModel::find($id, ['kode_defect']);
        
        // Check user already used in other table or not yet
        $defect_check = DB::select('SELECT * FROM tb_inspeksi_detail WHERE id_defect = '.$id); 
        if (isset($defect_check[0])) {
            Alert::error("Gagal!", 'Data ini tidak dapat dihapus karena sudah dipakai tabel lain!');
            return Redirect::back(); 
        } else {
            // Delete process
            $def = DefectModel::find($id);
            $def->delete();

            // Move to defect list page
            alert()->success('Berhasil!', 'Berhasil menghapus data!');
            return redirect('/defect');
        }
    }
}
