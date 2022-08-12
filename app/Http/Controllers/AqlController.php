<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

// Tambahkan source dibawah ini
use Illuminate\Support\Facades\DB;
use App\Models\AqlModel;
use Image;
use File;
use date;
use Crypt;
use Redirect;
use RealRashid\SweetAlert\Facades\Alert;

class AqlController extends Controller {
    // Menampilkan list sample aql
    public function aqllist(){
        // Get all data from database
        $aql = DB::select("SELECT * FROM vg_list_aql");
        $jenis_user = session()->get('jenis_user');

        return view('admin.master.aql-list',[
            'menu'          => 'master',
            'sub'           => '/aql',
            'aql'           => $aql,
            'jenis_user'    => $jenis_user
        ]);
    }

    // Redirect ke window input aql
    public function AqlInput(){
        $jenis_user = session()->get('jenis_user');

        return view('admin.master.aql-input',[
            'menu'          => 'master', // selalu ada di tiap function dan disesuaikan
            'sub'           => '/aql',
            'jenis_user'    => $jenis_user
        ]);
    }

    //Simpan data aql
    public function SaveAqlData(Request $request){
        $aql = new AqlModel();
        $jenis_user = session()->get('jenis_user');

        // Parameters
        $aql->level_aql         = strtoupper($request->level_aql);
        $aql->kode_aql          = strtoupper($request->kode_aql);
        $aql->qty_lot_min       = $request->qty_lot_min;
        $aql->qty_lot_max       = $request->qty_lot_max;
        $aql->qty_sample_aql    = $request->qty_sample_aql;
        $aql->qty_accept_minor  = $request->qty_accept_minor;
        $aql->qty_accept_major  = $request->qty_accept_major;
        $aql->created_at        = $request->created_at;
        $aql->updated_at        = $request->updated_at;

        $check_aql = DB::select("SELECT id_aql FROM vg_list_aql WHERE level_aql = '".strtoupper($request->level_aql)."' AND kode_aql = '".strtoupper($request->kode_aql)."'");

        if(isset($check_aql)){
            alert()->error('Gagal!', 'Data AQL sudah terdaftar di sistem!');
            return view('admin.master.aql-input',[
                'menu'          => 'master', // selalu ada di tiap function dan disesuaikan
                'sub'           => '/aql',
                'select'        => $aql,
                'jenis_user'    => $jenis_user
            ]);
        } else {
            // Insert data into database
            $aql->save();
            alert()->success('Berhasil!', 'Data Sukses Disimpan!');
            return redirect('/aql');
        }
    }

    // fungsi untuk redirect ke halaman edit
    public function EditAqlData($id){
        $id = Crypt::decrypt($id);
        $jenis_user = session()->get('jenis_user');

        // Select data based on ID
        $e_aql = AqlModel::find($id);

        return view('admin.master.aql-edit', [
            'menu'          => 'master',
            'sub'           => '/aql',
            'aql'           => $e_aql,
            'jenis_user'    => $jenis_user
        ]);
    }

    // simpan perubahan dari data yang sudah di edit
    public function SaveEditAqlData(Request $request){
        $id_aql             = $request->id_aql;
        $level_aql          = strtoupper($request->level_aql);
        $kode_aql           = strtoupper($request->kode_aql);
        $qty_lot_min        = $request->qty_lot_min;
        $qty_lot_max        = $request->qty_lot_max;
        $qty_sample_aql     = $request->qty_sample_aql;
        $qty_accept_minor   = $request->qty_accept_minor;
        $qty_accept_major   = $request->qty_accept_major;
        $updated_at         = date('Y-m-d H:i:s', strtotime('+0 hours'));

        //update data into db
        AqlModel::where('id_aql', $id_aql)->update([
            'level_aql'         => $level_aql,
            'kode_aql'          => $kode_aql,
            'qty_lot_min'       => $qty_lot_min,
            'qty_lot_max'       => $qty_lot_max,
            'qty_sample_aql'    => $qty_sample_aql,
            'qty_accept_minor'  => $qty_accept_minor,
            'qty_accept_major'  => $qty_accept_major,
            'updated_at'        => $updated_at,
        ]);
        alert()->success('Sukses!', 'Data Berhasil Diperbarui!');
        return redirect('/aql');
    }

    // Fungsi hapus data
    public function DeleteAqlData($id){
        $id = Crypt::decryptString($id);

        // Select table user to get user default value
        $e_aql = AqlModel::find($id, ['kode_aql']);

        $creator_check = DB::select('SELECT * FROM tb_inspeksi_detail WHERE creator = '.$id);
        // Check user already used in other table or not yet
        if (isset($creator_check[0])) {
            Alert::error("Gagal!", 'Data Ini Tidak Dapat Dihapus Karena Sudah Dipakai Tabel Lain!');
            return Redirect::back();
        } else {
            // Delete process
            $e_aql = AqlModel::find($id);
            $e_aql->delete();

            // Move to users list page
            alert()->success('Berhasil!', 'Berhasil Menghapus');
            return redirect('/aql');
        }
    }

    //Fungsi activation level
    public function ActivateLevel(Request $request){
        $level = $request->level;
        // $level_target = DB::select("SELECT * FROM tb_master_aql WHERE level_aql ='".$level."'");
        // $activation = "Activated";
        $activation = DB::table('tb_master_aql')
            ->where('level_aql', '>=', $level)
            ->update([
                'status_level' => 'Activated'
            ]);
        $not_active = DB::table('tb_master_aql')
        ->where('level_aql', '<>', $level)
        ->update([
            'status_level' => 'Not Active'
        ]);
        $aql = DB::select("SELECT * FROM vg_list_aql WHERE status_level = 'Activated'");

        $jenis_user = session()->get('jenis_user');

        return view('admin.master.aql-list',[
            'menu'          => 'master',
            'sub'           => '/aql',
            'aql'           => $aql,
            'jenis_user'    => $jenis_user
        ]);
    }

}
