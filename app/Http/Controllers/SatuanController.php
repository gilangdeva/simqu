<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

// Tambahkan source dibawah ini
use Illuminate\Support\Facades\DB;
use App\Models\SatuanModel;
use Image;
use File;
use date;
use Crypt;
use Redirect;
use RealRashid\SweetAlert\Facades\Alert;

class SatuanController extends Controller
{
    // Menampilkan list satuan
    public function satuanlist(){
        // Get all data from database
        $satuan = DB::select('SELECT * FROM vg_list_satuan');

        return view('admin.master.satuan-list',[
            'menu'   => 'master',
            'sub'    => '/satuan',
            'satuan' => $satuan
        ]);
    }

    // Redirect ke window input satuan
    public function SatuanInput(){
        return view('admin.master.satuan-input',[
            'menu'  => 'master', // selalu ada di tiap function dan disesuaikan
            'sub'   => '/satuan'
        ]);
    }

    //Simpan data satuan
    public function SaveSatuanData(Request $request){
        $satuan = new SatuanModel();

        // Parameters
        $satuan->kode_satuan = strtoupper($request->kode_satuan);
        $satuan->nama_satuan = strtoupper($request->nama_satuan);

        // Check duplicate kode
        $kode_satuan_check = DB::select("SELECT kode_satuan FROM vg_list_satuan WHERE kode_satuan = '".$satuan->kode_satuan."'");
        if (isset($kode_satuan_check['0'])) {
            alert()->error('Gagal Menyimpan!', 'Maaf, Kode Satuan Ini Sudah Didaftarkan Dalam Sistem!');
            return Redirect::back();
        }

        // Check duplicate defect
        $nama_satuan_check = DB::select("SELECT nama_satuan FROM vg_list_satuan WHERE nama_satuan = '".$satuan->nama_satuan."'");
        if (isset($nama_satuan_check['0'])) {
            alert()->error('Gagal Menyimpan!', 'Maaf, Nama Satuan Ini Sudah Didaftarkan Dalam Sistem!');
            return Redirect::back();
        }

       // Insert data into database
        $satuan->save();
            alert()->success('Berhasil!', 'Data Sukses Disimpan!');
            return redirect('/satuan');
    }

    // fungsi untuk redirect ke halaman edit
    public function EditSatuanData($id){
        $id = Crypt::decrypt($id);

        // Select data based on ID
        $sat = SatuanModel::find($id);

        return view('admin.master.satuan-edit', [
            'menu'      => 'master',
            'sub'       => '/satuan',
            'satuan'    => $sat,
        ]);
    }

    // simpan perubahan dari data yang sudah di edit
    public function SaveEditSatuanData(Request $request){
        $id_satuan            = $request->id_satuan;
        $kode_satuan          = strtoupper($request->kode_satuan);
        $nama_satuan          = strtoupper($request->nama_satuan);
        $updated_at           = date('Y-m-d H:i:s', strtotime('+0 hours'));

        // Is there a change in kode data?
        if ($request->nama_satuan <> $request->original_nama_satuan){
        //cek apakah sudah ada di db
        $satuan_check = DB::select("SELECT nama_satuan FROM vg_list_satuan WHERE nama_satuan = '".$nama_satuan."'");
            if (isset($satuan_check['0'])) {
                alert()->error('Gagal Menyimpan!', 'Maaf, Satuan Ini Sudah Digunakan');
                return Redirect::back();
            } else {
                //update data into db
                SatuanModel::where('id_satuan', $id_satuan)->update([
                    'kode_satuan'       => $kode_satuan,
                    'nama_satuan'       => $nama_satuan,
                    'updated_at'        => $updated_at,
                ]);
                alert()->success('Sukses!', 'Data Berhasil Diperbarui!');
                return redirect('/satuan');
            }
        } else {
                //update data into db
                SatuanModel::where('id_satuan', $id_satuan)->update([
                    'kode_satuan'       => $kode_satuan,
                    'nama_satuan'       => $nama_satuan,
                    'updated_at'        => $updated_at,
                ]);
                alert()->success('Sukses!', 'Data Berhasil Diperbarui!');
                return redirect('/satuan');
        }
    }

    // Fungsi hapus data
    public function DeleteSatuanData($id){
        $id = Crypt::decryptString($id);

        // Select table user to get user default value
        $sat = SatuanModel::find($id, ['kode_satuan']);

        $creator_check = DB::select('SELECT * FROM tb_inspeksi_detail WHERE creator = '.$id);
        // Check user already used in other table or not yet
        if (isset($creator_check[0])) {
            Alert::error("Gagal!", 'Data Ini Tidak Dapat Dihapus Karena Sudah Dipakai Tabel Lain!');
            return Redirect::back();
        } else {
            // Delete process
            $sat = SatuanModel::find($id);
            $sat->delete();

            // Move to users list page
            alert()->success('Berhasil!', 'Berhasil Menghapus Data!');
            return redirect('/satuan');
        }
    }
}

