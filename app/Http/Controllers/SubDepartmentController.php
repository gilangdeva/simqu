<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

// Tambahkan source dibawah ini
use Illuminate\Support\Facades\DB;
use App\Models\SubDepartmentModel;
use Image;
use File;
use Crypt;
use Redirect;
use RealRashid\SweetAlert\Facades\Alert;
use Illuminate\Support\Facades\Http;
use App\Http\Controllers\DepartmentController;
use App\Http\Controllers\MesinController;
use App\Http\Controllers\SatuanController;

class SubDepartmentController extends Controller
{
    public static function GetOraSubDepartemen(){
        //Get data from REST API
		$host = DB::table("tb_master_host")->orderBy('id_host', 'desc')->first();
        $request = Http::get($host->host.'/api/divi');// Url of your choosing
        $x = count(json_decode($request, true));

        DB::select("DELETE from tb_tmp_sub_departemen");

        // insert data to database postgres
        for ($i = 0; $i < $x; $i++) {
            $id_subdepartemen       = $request[$i]['id_subdepartemen'];
            $kode_subdepartemen     = $request[$i]['kode_subdepartemen'];
            $nama_subdepartemen     = $request[$i]['nama_subdepartemen'];
            $id_departemen          = $request[$i]['id_departemen'];
            $klasifikasi_proses     = $request[$i]['klasifikasi_proses'];

            //insert into database master
            DB::select("INSERT INTO tb_master_sub_departemen (id_sub_departemen, kode_sub_departemen, nama_sub_departemen, id_departemen, klasifikasi_proses)
            VALUES (".$id_subdepartemen.", '".$kode_subdepartemen."', '".$nama_subdepartemen."', '".$id_departemen."', '".$klasifikasi_proses."') ON CONFLICT (id_sub_departemen) DO UPDATE SET kode_sub_departemen = excluded.kode_sub_departemen, nama_sub_departemen = excluded.nama_sub_departemen, id_departemen = excluded.id_departemen, klasifikasi_proses = excluded.klasifikasi_proses");

            // insert into temp
            DB::select("INSERT INTO tb_tmp_sub_departemen (id_sub_departemen, kode_sub_departemen, nama_sub_departemen, id_departemen, klasifikasi_proses)
            VALUES (".$id_subdepartemen.", '".$kode_subdepartemen."', '".$nama_subdepartemen."', '".$id_departemen."', '".$klasifikasi_proses."') ON CONFLICT (id_sub_departemen) DO UPDATE SET kode_sub_departemen = excluded.kode_sub_departemen, nama_sub_departemen = excluded.nama_sub_departemen, id_departemen = excluded.id_departemen, klasifikasi_proses = excluded.klasifikasi_proses");
        }
    }

    // Menampilkan list subdepartemen
    public function SubDepartmentList(){
        // Call function Ora Database
        $this->GetOraSubDepartemen();
        (new DepartmentController)->GetOraDepartemen();
        (new MesinController)->GetOraMesin();
        (new SatuanController)->GetOraSatuan();

        // Get all data from database
        $subdepartment = DB::select('SELECT * FROM vg_rest_sub_departemen');
        $jenis_user = session()->get('jenis_user');

        if($jenis_user <> "Administrator"){
            alert()->warning('GAGAL!', 'Anda Tidak Memiliki Akses!');
            return Redirect('/');
        }

        return view('admin.master.subdepartment-list',[
            'menu'              => 'master',
            'sub'               => '/subdepartment',
            'subdepartment'     => $subdepartment,
            'jenis_user'        => $jenis_user
        ]);
    }

    // // Redirect ke window input subdepartment
    // public function SubDepartmentInput(){
    //     $departemen = DB::select('SELECT id_departemen, nama_departemen FROM vg_list_departemen');
    //     $jenis_user = session()->get('jenis_user');

    //     if($jenis_user <> "Administrator"){
    //         alert()->warning('GAGAL!', 'Anda Tidak Memiliki Akses!');
    //         return Redirect('/');
    //     }

    //     return view('admin.master.subdepartment-input',[
    //         'departemen'    => $departemen,
    //         'menu'          => 'master', // selalu ada di tiap function dan disesuaikan
    //         'sub'           => '/subdepartment',
    //         'jenis_user'    => $jenis_user
    //     ]);
    // }

    // //Simpan data subdepartemen
    // public function SaveSubDepartmentData(Request $request){
    //     $departemen = DB::select('SELECT id_departemen, nama_departemen FROM vg_list_departemen');
    //     $jenis_user = session()->get('jenis_user');
    //     $subdepartment = new SubDepartmentModel();

    //     // Parameters
    //     $subdepartment->id_departemen = $request->id_departemen;
    //     $subdepartment->kode_sub_departemen = strtoupper($request->kode_sub_departemen);
    //     $subdepartment->nama_sub_departemen = strtoupper($request->nama_sub_departemen);
    //     $subdepartment->klasifikasi_proses = strtoupper($request->klasifikasi_proses);

    //     // Validation data input
    //     if ($request->id_departemen == "0"){
    //         alert()->error('Gagal Input Data!', 'Maaf, Anda belum memilih Departemen!');

    //         return view('admin.master.subdepartment-input',[
    //             'departemen'    => $departemen,
    //             'menu'          => 'master', // selalu ada di tiap function dan disesuaikan
    //             'select'        => $subdepartment,
    //             'sub'           => '/subdepartment',
    //             'jenis_user'    => $jenis_user
    //         ]);
    //     }

    //     // Check duplicate kode
    //     $kode_sub_department_check = DB::select("SELECT kode_sub_departemen FROM vg_list_sub_departemen WHERE kode_sub_departemen = '".strtoupper ($subdepartment->kode_sub_departemen)."'");
    //     if (isset($kode_sub_department_check['0'])) {
    //         alert()->error('Gagal Menyimpan!', 'Maaf, Kode Ini Sudah Didaftarkan Dalam Sistem!');
    //         return view('admin.master.subdepartment-input',[
    //             'departemen'    => $departemen,
    //             'menu'          => 'master', // selalu ada di tiap function dan disesuaikan
    //             'select'        => $subdepartment,
    //             'sub'           => '/subdepartment',
    //             'jenis_user'    => $jenis_user
    //         ]);
    //     }

    //     // Check duplicate nama
    //     $nama_sub_department_check = DB::select("SELECT nama_sub_departemen FROM vg_list_sub_departemen WHERE nama_sub_departemen = '".strtoupper ($subdepartment->nama_sub_departemen)."'");
    //     if (isset($nama_sub_department_check['0'])) {
    //         alert()->error('Gagal Menyimpan!', 'Maaf, Nama Ini Sudah Didaftarkan Dalam Sistem!');
    //         return view('admin.master.subdepartment-input',[
    //             'departemen'    => $departemen,
    //             'menu'          => 'master', // selalu ada di tiap function dan disesuaikan
    //             'select'        => $subdepartment,
    //             'sub'           => '/subdepartment',
    //             'jenis_user'    => $jenis_user
    //         ]);
    //     }

    //     // Insert data into database
    //     $subdepartment->save();

    //         alert()->success('Berhasil!', 'Data Sukses Disimpan!');
    //         return redirect('/subdepartment');

    // }


    // // fungsi untuk redirect ke halaman edit
    // public function EditSubDepartmentData($id){
    //     $id = Crypt::decrypt($id);
    //     $departemen = DB::select('SELECT id_departemen, nama_departemen FROM vg_list_departemen');
    //     $jenis_user = session()->get('jenis_user');

    //     if($jenis_user <> "Administrator"){
    //         alert()->warning('GAGAL!', 'Anda Tidak Memiliki Akses!');
    //         return Redirect('/');
    //     }

    //     // Select data based on ID
    //     $subdepartemen = SubDepartmentModel::find($id);

    //     return view('admin.master.subdepartment-edit', [
    //         'menu'          => 'master',
    //         'sub'           => '/subdepartment',
    //         'subdepartment' => $subdepartemen,
    //         'departemen'    => $departemen,
    //         'jenis_user'    => $jenis_user
    //     ]);
    // }

    // // simpan perubahan dari data yang sudah di edit
    // public function SaveEditSubDepartmentData(Request $request){
    //     $departemen = DB::select('SELECT id_departemen, nama_departemen FROM vg_list_departemen');
    //     $jenis_user = session()->get('jenis_user');

    //     $id_sub_departemen = $request->id_sub_departemen;
    //     $id_departemen = $request->id_departemen;
    //     $kode_sub_departemen = strtoupper($request->kode_sub_departemen);
    //     $nama_sub_departemen = strtoupper($request->nama_sub_departemen);
    //     $klasifikasi_proses = $request->klasifikasi_proses;
    //     $updated_at = date('Y-m-d H:i:s', strtotime('+0 hours'));

    //     // Is there a change in kode data?
    //     if ($request->nama_sub_departemen <> $request->original_nama_sub_departemen){
    //         //cek apakah sudah ada di db
    //         $namasub_check = DB::select("SELECT nama_sub_departemen FROM vg_list_sub_departemen WHERE nama_sub_departemen = '".$nama_sub_departemen."'");
    //         if (isset($namasub_check['0'])) {
    //             alert()->error('Gagal Menyimpan!', 'Maaf, Nama Ini Sudah Digunakan');

    //             // Select data based on ID
    //             $subdepartemen = SubDepartmentModel::find($id_sub_departemen);

    //             return view('admin.master.subdepartment-edit', [
    //                 'menu'          => 'master',
    //                 'sub'           => '/subdepartment',
    //                 'subdepartment' => $subdepartemen,
    //                 'departemen'    => $departemen,
    //                 'jenis_user'    => $jenis_user
    //             ]);

    //         } else {
    //             //update data into db
    //             SubDepartmentModel::where('id_sub_departemen', $id_sub_departemen)->update([
    //                 'id_departemen'               => $id_departemen,
    //                 'kode_sub_departemen'         => $kode_sub_departemen,
    //                 'nama_sub_departemen'         => $nama_sub_departemen,
    //                 'updated_at'                  => $updated_at,
    //             ]);
    //             alert()->success('Sukses!', 'Data Berhasil Diperbarui!');
    //             return redirect('/subdepartment');
    //         }
    //     } else  {
    //         // Update data into database
    //         SubDepartmentModel::where('id_sub_departemen', $id_sub_departemen)->update([
    //             'id_departemen'               => $id_departemen,
    //             'kode_sub_departemen'         => $kode_sub_departemen,
    //             'nama_sub_departemen'         => $nama_sub_departemen,
    //             'klasifikasi_proses'          => $klasifikasi_proses,
    //             'updated_at'                  => $updated_at,
    //         ]);

    //         alert()->success('Sukses!', 'Data Berhasil Diperbarui!');
    //         return redirect('/subdepartment');
    //     }
    // }


    // // Fungsi hapus data
    // public function DeleteSubDepartmentData($id){
    //     $id = Crypt::decryptString($id);

    //     // Select table user to get user default value
    //     $subdepartemen = SubDepartmentModel::find($id, ['kode_sub_departemen']);

    //     $creator_check = DB::select('SELECT * FROM tb_inspeksi_detail WHERE creator = '.$id);
    //     // Check user already used in other table or not yet
    //     if (isset($creator_check[0])) {
    //         Alert::error("Gagal!", 'Data Ini Tidak Dapat Dihapus Karena Sudah Dipakai Tabel Lain!');
    //         return Redirect::back();
    //     } else {
    //         // Delete process
    //         $subdepartemen = SubDepartmentModel::find($id);
    //         $subdepartemen->delete();

    //         // Move to users list page
    //         alert()->success('Berhasil!', 'Berhasil Menghapus Data!');
    //         return redirect('/subdepartment');
    //     }
    // }
}
