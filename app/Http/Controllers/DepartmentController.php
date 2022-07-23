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
        $jenis_user = session()->get('jenis_user');

        return view('admin.master.department-list',[
            'menu'          => 'master',
            'sub'           => '/department',
            'department'    => $department,
            'jenis_user'    => $jenis_user
        ]);
    }

    // Redirect ke window input department
    public function DepartmentInput(){
        $jenis_user = session()->get('jenis_user');
        return view('admin.master.department-input',[
            'menu'          => 'master', // selalu ada di tiap function dan disesuaikan
            'sub'           => '/department',
            'jenis_user'    => $jenis_user
        ]);
    }

    //Simpan data departemen
    public function SaveDepartmentData(Request $request){
        $department = new DepartmentModel();

        // Parameters
        $department->kode_departemen = strtoupper($request->kode_departemen);
        $department->nama_departemen = strtoupper($request->nama_departemen);
        $department->creator         = session()->get('user_id');
        $department->pic             = session()->get('user_id');
        $jenis_user = session()->get('jenis_user');

        // Check duplicate kode
        $kode_department_check = DB::select("SELECT kode_departemen FROM vg_list_departemen WHERE kode_departemen = '".$department->kode_departemen."'");
        if (isset($kode_department_check['0'])) {
            alert()->error('Gagal Menyimpan!', 'Maaf, Kode Ini Sudah Didaftarkan Dalam Sistem!');
            return Redirect::back();
        }

        // Check duplicate nama
        $nama_department_check = DB::select("SELECT nama_departemen FROM vg_list_departemen WHERE nama_departemen = '".$department->nama_departemen."'");
        if (isset($nama_department_check['0'])) {
            alert()->error('Gagal Menyimpan!', 'Maaf, Nama Ini Sudah Didaftarkan Dalam Sistem!');
            return Redirect::back();
        }

       // Insert data into database
        $department->save();
        alert()->success('Berhasil!', 'Data Sukses Disimpan!');
        return redirect('/department');
    }

    // fungsi untuk redirect ke halaman edit
    public function EditDepartmentData($id){
        $id = Crypt::decrypt($id);
        $jenis_user = session()->get('jenis_user');

        // Select data based on ID
        $departemen = DepartmentModel::find($id);

        return view('admin.master.department-edit', [
            'menu'          => 'master',
            'sub'           => '/department',
            'department'    => $departemen,
            'jenis_user'    => $jenis_user
        ]);
    }

    // simpan perubahan dari data yang sudah di edit
    public function SaveEditDepartmentData(Request $request){
        $id_departemen = $request->id_departemen;
        $kode_departemen = strtoupper($request->kode_departemen);
        $nama_departemen = strtoupper($request->nama_departemen);
        $updated_at = date('Y-m-d H:i:s', strtotime('+0 hours'));
        $jenis_user = session()->get('jenis_user');

        // is there a change in nama departemen data?
        if ($request->nama_departemen <> $request->original_nama_departemen){
            // Check duplicate nama
            $nama_check = DB::select("SELECT nama_departemen FROM vg_list_departemen WHERE nama_departemen = '".$nama_departemen."'");
            if (isset($nama_check['0'])) {
                alert()->error('Gagal Menyimpan!', 'Maaf, Nama Departemen Ini Sudah Didaftarkan Dalam Sistem!');
                return Redirect::back();
               } else {
                   //update data into database
                   DepartmentModel::where('id_departemen', $id_departemen)->update([
                      'kode_departemen'         => $kode_departemen,
                      'nama_departemen'         => $nama_departemen,
                      'updated_at'              => $updated_at,
                   ]);
                   alert()->success('Sukses!', 'Data Berhasil Diperbarui!');
                   return redirect('/department');
               }

            } else {
                //update data into database
                DepartmentModel::where('id_departemen', $id_departemen)->update([
                   'kode_departemen'         => $kode_departemen,
                   'nama_departemen'         => $nama_departemen,
                   'updated_at'              => $updated_at,
                ]);
                alert()->success('Sukses!', 'Data Berhasil Diperbarui!');
                return redirect('/department');
            }
    }

    // Fungsi hapus data
    public function DeleteDepartmentData($id){
        $id = Crypt::decryptString($id);
        $jenis_user = session()->get('jenis_user');

        // Delete process
        $department = DepartmentModel::find($id);
        $department->delete();

        // Move to department list page
        alert()->success('Berhasil!', 'Berhasil Menghapus Data!');
        return redirect('/department');
    }
}
