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
use Illuminate\Support\Facades\Http;
use App\Http\Controllers\DepartmentController;
use App\Http\Controllers\SubDepartmentController;
use App\Http\Controllers\MesinController;
use App\Http\Controllers\SatuanController;

class DefectController extends Controller
{
    // Menampilkan list defect
    public function defectlist() {
        //call function get Ora Database
        (new DepartmentController)->GetOraDepartemen();
        (new SubDepartmentController)->GetOraSubDepartemen();
        (new MesinController)->GetOraMesin();
        (new SatuanController)->GetOraSatuan();

        // Get all data from database
        $defect = DB::select("SELECT * FROM vg_list_defect");
        $jenis_user = session()->get('jenis_user');

        if($jenis_user <> "Administrator"){
            alert()->warning('GAGAL!', 'Anda Tidak Memiliki Akses!');
            return Redirect('/');
        }

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
        //call function get Ora Database
        (new DepartmentController)->GetOraDepartemen();
        (new SubDepartmentController)->GetOraSubDepartemen();
        (new MesinController)->GetOraMesin();
        (new SatuanController)->GetOraSatuan();

        $departemen = DB::select('SELECT id_departemen, nama_departemen FROM vg_list_departemen');
        $jenis_user = session()->get('jenis_user');

        if($jenis_user <> "Administrator"){
            alert()->warning('GAGAL!', 'Anda Tidak Memiliki Akses!');
            return Redirect('/');
        }

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
        $departemen = DB::select('SELECT id_departemen, nama_departemen FROM vg_list_departemen');
        $jenis_user = session()->get('jenis_user');

        $id_defect          = DB::select("SELECT id_defect FROM vid_defect");
        $id_defect          = $id_defect[0]->id_defect;

        // Parameters
        $defect->id_defect = $id_defect;
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

            return view('admin.master.defect-input',[
                'departemen'    => $departemen,
                'select'        => $defect,
                'menu'          => 'master', // selalu ada di tiap function dan disesuaikan
                'sub'           => '/defect',
                'jenis_user'    => $jenis_user
            ]);
        }

        // Check duplicate defect
        $defect_check = DB::select("SELECT defect FROM vg_list_defect WHERE defect = '".$defect->defect."'");
        if (isset($defect_check['0'])) {
            alert()->error('Gagal Menyimpan!', 'Maaf, Defect Ini Sudah Didaftarkan Dalam Sistem!');

            return view('admin.master.defect-input',[
                'departemen'    => $departemen,
                'select'        => $defect,
                'menu'          => 'master', // selalu ada di tiap function dan disesuaikan
                'sub'           => '/defect',
                'jenis_user'    => $jenis_user
            ]);
        }

        $host               = DB::table("tb_master_host")->orderBy('id_host','asc')->first();

        $nama_defect        = strtoupper($request->defect);
        $kode_defect        = strtoupper($request->kode_defect);
        $id_departemen      = $request->id_departemen;
        $critical           = $request->critical;
        $major              = $request->major;
        $minor              = $request->minor;
        $created_at         = date('Y-m-d H:i:s', strtotime('+0 hours'));
        $updated_at         = date('Y-m-d H:i:s', strtotime('+0 hours'));

        // Insert into ora DB
		$response = Http::asForm()->post($host->host.'/api/dfct', [
			'ID_DEFECT'             => $id_defect,
			'DEFECT'                => $nama_defect,
			'KODE_DEFECT'           => $kode_defect,
			'ID_DEPARTEMEN'         => $id_departemen,
			'CRITICAL'              => $critical,
			'MAJOR'                 => $major,
			'MINOR'                 => $minor,
			'CREATED_AT'            => date('Y-m-d H:i:s', strtotime('+0 hours')),
			'UPDATED_AT'            => date('Y-m-d H:i:s', strtotime('+0 hours'))
		]);

       // Insert data into database postgres
        $defect->save();
            alert()->success('Berhasil!', 'Data Sukses Disimpan!');

            return view('admin.master.defect-input',[
                'departemen'    => $departemen,
                'select'        => $defect,
                'menu'          => 'master', // selalu ada di tiap function dan disesuaikan
                'sub'           => '/defect',
                'jenis_user'    => $jenis_user
            ]);
    }

    // fungsi untuk redirect ke halaman edit
    public function EditDefectData($id){
        $id = Crypt::decrypt($id);
        $departemen = DB::select('SELECT id_departemen, nama_departemen FROM vg_list_departemen');
        $jenis_user = session()->get('jenis_user');

        if($jenis_user <> "Administrator"){
            alert()->warning('GAGAL!', 'Anda Tidak Memiliki Akses!');
            return Redirect('/');
        }

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
        $departemen = DB::select('SELECT id_departemen, nama_departemen FROM vg_list_departemen');
        $jenis_user = session()->get('jenis_user');

        $id_defect              = $request->id_defect;
        $id_departemen          = $request->id_departemen;
        $kode_defect            = strtoupper($request->kode_defect);
        $defect                 = strtoupper($request->defect);
        $critical               = $request->critical;
        $major                  = $request->major;
        $minor                  = $request->minor;
        $updated_at             = date('Y-m-d H:i:s', strtotime('+0 hours'));

        $host = DB::table("tb_master_host")->orderBy('id_host','asc')->first();

        // Is there a change in kode data?
        if ($request->defect <> $request->original_defect){
        //cek apakah sudah ada di db
        $defect_check = DB::select("SELECT defect FROM vg_list_defect WHERE defect = '".$defect."' AND id_departemen = ".$id_departemen);
            if (isset($defect_check['0'])) {
                alert()->error('Gagal Menyimpan!', 'Maaf, Nama Ini Sudah Digunakan');

                $def = DefectModel::find($id_defect);

                return view('admin.master.defect-edit', [
                    'menu'          => 'master',
                    'sub'           => '/defect',
                    'defect'        => $def,
                    'departemen'    => $departemen,
                    'jenis_user'    => $jenis_user
                ]);

            } else {
                // Update into ora DB
                $response = Http::asForm()->put($host->host.'/api/udfct', [
                    'ID_DEFECT'             => $id_defect,
                    'DEFECT'                => $defect,
                    'KODE_DEFECT'           => $kode_defect,
                    'ID_DEPARTEMEN'         => $id_departemen,
                    'CRITICAL'              => $critical,
                    'MAJOR'                 => $major,
                    'MINOR'                 => $minor,
                    'CREATED_AT'            => date('Y-m-d H:i:s', strtotime('+0 hours')),
                    'UPDATED_AT'            => date('Y-m-d H:i:s', strtotime('+0 hours'))
                ]);

                //update data into db
                DefectModel::where('id_defect', $id_defect)->update([
                    'kode_defect'       => $kode_defect,
                    'defect'            => $defect,
                    'id_departemen'     => $id_departemen,
                    'critical'          => $critical,
                    'major'             => $major,
                    'minor'             => $minor,
                    'updated_at'        => $updated_at,
                ]);
                alert()->success('Sukses!', 'Data Berhasil Diperbarui!');
                return redirect('/defect');
            }
        } else {
            // Update into ora DB
            $response = Http::asForm()->put($host->host.'/api/udfct', [
                'ID_DEFECT'             => $id_defect,
                'DEFECT'                => $defect,
                'KODE_DEFECT'           => $kode_defect,
                'ID_DEPARTEMEN'         => $id_departemen,
                'CRITICAL'              => $critical,
                'MAJOR'                 => $major,
                'MINOR'                 => $minor,
                'CREATED_AT'            => date('Y-m-d H:i:s', strtotime('+0 hours')),
                'UPDATED_AT'            => date('Y-m-d H:i:s', strtotime('+0 hours'))
            ]);

            //update data into db
            DefectModel::where('id_defect', $id_defect)->update([
                'kode_defect'       => $kode_defect,
                'defect'            => $defect,
                'id_departemen'     => $id_departemen,
                'critical'          => $critical,
                'major'             => $major,
                'minor'             => $minor,
                'updated_at'        => $updated_at
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

            // delete data inspeksi di table oracle
            $host = DB::table("tb_master_host")->orderBy('id_host','asc')->first();
            $request = Http::delete($host->host.'/api/hdfct/'.$id_defect);// Url of your choosing

            // Move to department list page
            alert()->success('Berhasil!', 'Berhasil Menghapus Data!');
            return redirect('/defect');
        }
    }
}
