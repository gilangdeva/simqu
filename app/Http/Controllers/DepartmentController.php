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
use Illuminate\Support\Facades\Http;
use App\Http\Controllers\SubDepartmentController;
use App\Http\Controllers\MesinController;
use App\Http\Controllers\SatuanController;

class DepartmentController extends Controller
{
    public static function GetOraDepartemen(){
        //Get data from REST API
		$host = DB::table("tb_master_host")->orderBy('id_host', 'desc')->first();
        $request = Http::get($host->host.'/api/dept');// Url of your choosing
        $x = count(json_decode($request, true));

        DB::select("DELETE from tb_tmp_departemen");

        // insert data to database postgres
        for ($i = 0; $i < $x; $i++) {
            $id_departemen      = $request[$i]['id_departemen'];
            $kode_departemen    = $request[$i]['kode_departemen'];
            $nama_departemen    = $request[$i]['nama_departemen'];

            //insert into database master
            DB::select("INSERT INTO tb_master_departemen (id_departemen, kode_departemen, nama_departemen)
            VALUES (".$id_departemen.", '".$kode_departemen."', '".$nama_departemen."') ON CONFLICT (id_departemen) DO UPDATE SET kode_departemen = excluded.kode_departemen, nama_departemen = excluded.nama_departemen");

            // insert into temp
            DB::select("INSERT INTO tb_tmp_departemen (id_departemen, kode_departemen, nama_departemen)
            VALUES (".$id_departemen.", '".$kode_departemen."', '".$nama_departemen."') ON CONFLICT (id_departemen) DO UPDATE SET kode_departemen = excluded.kode_departemen, nama_departemen = excluded.nama_departemen");
        }
    }

    // Menampilkan list departemen
    public function DepartmentList(){
        //call function get Ora Database
        $this->GetOraDepartemen();
        (new SubDepartmentController)->GetOraSubDepartemen();
        (new MesinController)->GetOraMesin();
        (new SatuanController)->GetOraSatuan();

        // Get all data from database
        // $department = DepartmentModel::all();
        $department = DB::select("SELECT * FROM vw_rest_departemen");
        $jenis_user = session()->get('jenis_user');

        if($jenis_user <> "Administrator"){
            alert()->warning('GAGAL!', 'Anda Tidak Memiliki Akses!');
            return Redirect('/');
        }

        return view('admin.master.department-list',[
            'menu'          => 'master',
            'sub'           => '/department',
            'department'    => $department,
            'jenis_user'    => $jenis_user,
        ]);
    }

    // // Redirect ke window input department
    // public function DepartmentInput(){
    //     $jenis_user = session()->get('jenis_user');

    //     if($jenis_user <> "Administrator"){
    //         alert()->warning('GAGAL!', 'Anda Tidak Memiliki Akses!');
    //         return Redirect('/');
    //     }

    //     return view('admin.master.department-input',[
    //         'menu'          => 'master', // selalu ada di tiap function dan disesuaikan
    //         'sub'           => '/department',
    //         'jenis_user'    => $jenis_user
    //     ]);
    // }

    // //Simpan data departemen
    // public function SaveDepartmentData(Request $request){
    //     $department = new DepartmentModel();

    //     // Parameters
    //     $department->kode_departemen = strtoupper($request->kode_departemen);
    //     $department->nama_departemen = strtoupper($request->nama_departemen);
    //     $department->creator         = session()->get('user_id');
    //     $department->pic             = session()->get('user_id');
    //     $jenis_user                  = session()->get('jenis_user');


    //     // Check duplicate kode
    //     $kode_department_check = DB::select("SELECT kode_departemen FROM vg_list_departemen WHERE kode_departemen = '".$department->kode_departemen."'");
    //     if (isset($kode_department_check['0'])) {
    //         alert()->error('Gagal Menyimpan!', 'Maaf, Kode Ini Sudah Didaftarkan Dalam Sistem!');
    //         return view('admin.master.department-input',[
    //             'menu'          => 'master', // selalu ada di tiap function dan disesuaikan
    //             'sub'           => '/department',
    //             'select'        => $department,
    //             'jenis_user'    => $jenis_user
    //         ]);
    //     }

    //     // Check duplicate nama
    //     $nama_department_check = DB::select("SELECT nama_departemen FROM vg_list_departemen WHERE nama_departemen = '".$department->nama_departemen."'");
    //     if (isset($nama_department_check['0'])) {
    //         alert()->error('Gagal Menyimpan!', 'Maaf, Nama Ini Sudah Didaftarkan Dalam Sistem!');
    //         return view('admin.master.department-input',[
    //             'menu'          => 'master', // selalu ada di tiap function dan disesuaikan
    //             'sub'           => '/department',
    //             'select'        => $department,
    //             'jenis_user'    => $jenis_user
    //         ]);
    //     }

    //    // Insert data into database
    //     $department->save();
    //     alert()->success('Berhasil!', 'Data Sukses Disimpan!');
    //     return redirect('/department');
    // }

    // // fungsi untuk redirect ke halaman edit
    // public function EditDepartmentData($id){
    //     $id = Crypt::decrypt($id);
    //     $jenis_user = session()->get('jenis_user');

    //     if($jenis_user <> "Administrator"){
    //         alert()->warning('GAGAL!', 'Anda Tidak Memiliki Akses!');
    //         return Redirect('/');
    //     }

    //     // Select data based on ID
    //     $departemen = DepartmentModel::find($id);

    //     return view('admin.master.department-edit', [
    //         'menu'          => 'master',
    //         'sub'           => '/department',
    //         'department'    => $departemen,
    //         'jenis_user'    => $jenis_user
    //     ]);
    // }

    // // simpan perubahan dari data yang sudah di edit
    // public function SaveEditDepartmentData(Request $request){
    //     $id_departemen = $request->id_departemen;
    //     $kode_departemen = strtoupper($request->kode_departemen);
    //     $nama_departemen = strtoupper($request->nama_departemen);
    //     $updated_at = date('Y-m-d H:i:s', strtotime('+0 hours'));
    //     $jenis_user = session()->get('jenis_user');
    //     $departemen = DepartmentModel::find($id_departemen);

    //     // is there a change in nama departemen data?
    //     if ($request->nama_departemen <> $request->original_nama_departemen){
    //         // Check duplicate nama
    //         $nama_check = DB::select("SELECT nama_departemen FROM vg_list_departemen WHERE nama_departemen = '".$nama_departemen."'");
    //         if (isset($nama_check['0'])) {
    //             alert()->error('Gagal Menyimpan!', 'Maaf, Nama Departemen Ini Sudah Didaftarkan Dalam Sistem!');
    //             return view('admin.master.department-edit', [
    //                 'menu'          => 'master',
    //                 'sub'           => '/department',
    //                 'department'    => $departemen,
    //                 'jenis_user'    => $jenis_user
    //             ]);
    //            } else {
    //                //update data into database
    //                DepartmentModel::where('id_departemen', $id_departemen)->update([
    //                   'kode_departemen'         => $kode_departemen,
    //                   'nama_departemen'         => $nama_departemen,
    //                   'updated_at'              => $updated_at,
    //                ]);
    //                alert()->success('Sukses!', 'Data Berhasil Diperbarui!');
    //                return redirect('/department');
    //            }

    //         } else {
    //             //update data into database
    //             DepartmentModel::where('id_departemen', $id_departemen)->update([
    //                'kode_departemen'         => $kode_departemen,
    //                'nama_departemen'         => $nama_departemen,
    //                'updated_at'              => $updated_at,
    //             ]);
    //             alert()->success('Sukses!', 'Data Berhasil Diperbarui!');
    //             return redirect('/department');
    //         }
    // }

    // // Fungsi hapus data
    // public function DeleteDepartmentData($id){
    //     $id = Crypt::decryptString($id);
    //     $jenis_user = session()->get('jenis_user');

    //     // Delete process
    //     $department = DepartmentModel::find($id);
    //     $department->delete();

    //     // Move to department list page
    //     alert()->success('Berhasil!', 'Berhasil Menghapus Data!');
    //     return redirect('/department');
    // }
}
