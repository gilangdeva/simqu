<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

// Tambahkan source dibawah ini
use Illuminate\Support\Facades\DB;
use App\Models\DepartmentModel;
use Image;
use File;
use Crypt;
use Redirect;
use RealRashid\SweetAlert\Facades\Alert;

class DepartmentController extends Controller
{


    // Menampilkan list departemen
    public function DepartmentList(){
        // Get all data from database
        $department = DepartmentModel::all();

        return view('admin.master.department-list',[
            'menu'  => 'master',
            'sub'   => '/department',
            'department' => $department
        ]);
    }

    // Redirect ke window input department
    public function DepartmentInput(){
        return view('admin.master.department-input',[
            'menu'  => 'master', // selalu ada di tiap function dan disesuaikan
            'sub'   => '/department'
        ]);
    }

    //Simpan data departemen
    public function SaveDepartmentData(Request $request){
        $department = new DepartmentModel();

        // Parameters
        $department->kode_departemen = strtolower($request->kode_departemen);
        $department->nama_departemen = strtoupper($request->nama_departemen);

        // Check duplicate kode
        $kode_department_check = DB::select("SELECT kode_departemen FROM tb_master_departemen WHERE kode_departemen = '".$request->kode_departemen."'");
        if (isset($kode_department_check['0'])) {  
            alert()->error('Gagal Menyimpan!', 'Maaf, kode ini sudah didaftarkan dalam sistem!');
            return Redirect::back();
        }

        // Check duplicate nama
        $nama_department_check = DB::select("SELECT nama_departemen FROM tb_master_departemen WHERE nama_departemen = '".$request->nama_departemen."'");
        if (isset($nama_department_check['0'])) {  
            alert()->error('Gagal Menyimpan!', 'nama, kode ini sudah didaftarkan dalam sistem!');
            return Redirect::back();
        }

       // Insert data into database
        $department->save();
            alert()->success('Berhasil!', 'Data sukses disimpan!');
            return redirect('/department');
    }


    // fungsi untuk redirect ke halaman edit
    public function EditDepartmentData($id){
        $id = Crypt::decrypt($id);

        // Select data based on ID
        $departemen = DepartmentModel::find($id);
        
        return view('admin.master.department-edit', [
            'menu'  => 'master',
            'sub'   => '/department',
            'department' => $departemen,
        ]);
    }

    // simpan perubahan dari data yang sudah di edit
    public function SaveEditDepartmentData(Request $request){
        $id_departemen = $request->id_departemen;
        $kode_departemen = strtolower($request->kode_departemen);
        $nama_departemen = strtoupper($request->nama_departemen);
        $updated_at = date('Y-m-d H:i:s', strtotime('+0 hours'));
 


        // return $request;


        {
            // Update data into database
            DepartmentModel::where('id_departemen', $id_departemen)->update([
                'kode_departemen'         => $kode_departemen,
                'nama_departemen'         => $nama_departemen,
                'updated_at'              => $updated_at,
            ]);
            
            alert()->success('Sukses!', 'Data berhasil diperbarui!');
            return redirect('/department');
        }
    } 
    

    // Fungsi hapus data
    public function DeleteDepartmentData($id){
        $id = Crypt::decryptString($id);
        
        // Select table user to get user default value
        $departemen = DepartmentModel::find($id, ['kode_departemen']);
        
        $creator_check = DB::select('SELECT * FROM tb_inspeksi_detail WHERE creator = '.$id);
        // Check user already used in other table or not yet
        if (isset($creator_check[0])) {
            Alert::error("Gagal!", 'Data ini tidak dapat dihapus karena sudah dipakai tabel lain!');
            return Redirect::back(); 
        }
        {
            // Delete process
            $departemen = DepartmentModel::find($id);
            $departemen->delete();

            // Move to department list page
            alert()->success('Berhasil!', 'Berhasil menghapus data!');
            return redirect('/department');
        }
    }
}
