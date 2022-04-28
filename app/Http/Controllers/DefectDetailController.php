<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

// Tambahkan source dibawah ini
use Illuminate\Support\Facades\DB;
use App\Models\DefectDetailModel;
use Image;
use File;
use date;
use Crypt;
use Redirect;
use RealRashid\SweetAlert\Facades\Alert;

class DefectDetailController extends Controller
{


    // Menampilkan list mesin
    public function defectdetaillist(){
        // Get all data from database
        $defectdetail = DefectDetailModel::all();

        return view('admin.master.defectdetail-list',[
            'menu'  => 'master',
            'sub'   => '/defectdetail',
            'defectdetail' => $defectdetail
        ]);
    }

    // Redirect ke window input mesin
    public function DefectDetailInput(){
        return view('admin.master.defectdetail-input',[
            'menu'  => 'master', // selalu ada di tiap function dan disesuaikan
            'sub'   => '/defectdetail'
        ]);
    }

    //Simpan data mesin
    public function SaveDefectDetailData(Request $request){
        $defectdetail = new DefectDetailModel();

        // Parameters
        $defectdetail->kode_defect = strtolower($request->kode_defect);
        $defectdetail->defect = $request->defect;
        $defectdetail->id_master_defect_header = 0; // nanti diganti

        // Check duplicate kode
        $kode_check = DB::select("SELECT kode_defect FROM vg_list_def_detail WHERE kode_defect = '".$request->kode_defect."'");
        if (isset($kode_check['0'])) {  
            alert()->error('Gagal Menyimpan!', 'Maaf, kode defect ini sudah didaftarkan dalam sistem!');
            return Redirect::back();
        }

        // Check duplicate defect
        $defect_check = DB::select("SELECT defect FROM vg_list_def_detail WHERE defect = '".$request->defect."'");
        if (isset($nama_check['0'])) {  
            alert()->error('Gagal Menyimpan!', 'Maaf, defect ini sudah didaftarkan dalam sistem!');
            return Redirect::back();
        }        


       // Insert data into database
        $defectdetail->save();
            alert()->success('Berhasil!', 'Data sukses disimpan!');
            return redirect('/defectdetail');
    }


    // fungsi untuk redirect ke halaman edit
    public function EditDefectDetailData($id){
        $id = Crypt::decrypt($id);

        // Select data based on ID
        $defdetail = DefectDetailModel::find($id);
        
        return view('admin.master.defectdetail-edit', [
            'menu'  => 'master',
            'sub'   => '/defectdetail',
            'defectdetail' => $defdetail,
        ]);
    }

    // simpan perubahan dari data yang sudah di edit
    public function SaveEditDefectDetailData(Request $request){
        $id_master_defect_detail = $request->id_master_defect_detail;
        $kode_defect = strtolower($request->kode_defect);
        $defect = $request->defect;
        $updated_at = date('Y-m-d H:i:s', strtotime('+0 hours'));
 


        // return $request;


        {
            // Update data into database
            DefectDetailModel::where('id_master_defect_detail', $id_master_defect_detail)->update([
                'kode_defect'              => $kode_defect,
                'defect'                   => $defect,
                'id_master_defect_header'  => 0,  
                'updated_at'               => $updated_at,
            ]);
            
            alert()->success('Sukses!', 'Data berhasil diperbarui!');
            return redirect('/defectdetail');
        }
    } 
    

    // Fungsi hapus data
    public function DeleteDefectDetailData($id){
        $id = Crypt::decryptString($id);
        
        // Select table user to get user default value
        $defdetail = DefectDetailModel::find($id, ['kode_defect']);
        
        $creator_check = DB::select('SELECT * FROM tb_inspeksi_detail WHERE creator = '.$id);
        // Check user already used in other table or not yet
        if (isset($creator_check[0])) {
            Alert::error("Gagal!", 'Data ini tidak dapat dihapus karena sudah dipakai tabel lain!');
            return Redirect::back(); 
        }
        {
            // Delete process
            $defdetail = DefectDetailModel::find($id);
            $defdetail->delete();

            // Move to department list page
            alert()->success('Berhasil!', 'Berhasil menghapus data!');
            return redirect('/defectdetail');
        }
    }
}

