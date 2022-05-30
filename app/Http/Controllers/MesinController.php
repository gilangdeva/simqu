<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

// Tambahkan source dibawah ini
use Illuminate\Support\Facades\DB;
use App\Models\MesinModel;
use Image;
use File;
use date;
use Crypt;
use Redirect;
use RealRashid\SweetAlert\Facades\Alert;

class MesinController extends Controller
{
    // Menampilkan list mesin
    public function MesinList(){
        // Get all data from database
        $mesin = DB::select('SELECT * FROM vg_list_mesin');

        return view('admin.master.mesin-list',[
            'menu'  => 'master',
            'sub'   => '/mesin',
            'mesin' => $mesin
        ]);
    }

    // Redirect ke window input mesin
    public function MesinInput(){
        $departemen = DB::select('SELECT id_departemen, nama_departemen FROM vg_list_departemen');
        $subdepartemen = DB::select('SELECT id_sub_departemen, nama_sub_departemen FROM vg_list_sub_departemen');

        return view('admin.master.mesin-input',[
            'departemen'   => $departemen,
            'subdepartemen' => $subdepartemen,
            'menu'  => 'master', // selalu ada di tiap function dan disesuaikan
            'sub'   => '/mesin'
        ]);
    }

    //Simpan data mesin
    public function SaveMesinData(Request $request){
        $mesin = new MesinModel();

        // Parameters
        $mesin->id_departemen = $request->id_departemen;
        $mesin->id_sub_departemen = $request->id_sub_departemen;
        $mesin->kode_mesin = strtoupper($request->kode_mesin);
        $mesin->nama_mesin = strtoupper($request->nama_mesin);

        // Validation data input
        if ($request->id_departemen == "0" || $request->id_sub_departemen =="0"){
            alert()->error('Gagal Input Data!', 'Maaf, Ada Kesalahan Penginputan Data!');
            return Redirect::back();
        }

        // Check duplicate kode
        $kode_check = DB::select("SELECT kode_mesin FROM vg_list_mesin WHERE kode_mesin = '".$request->kode_mesin."'");
        if (isset($kode_check['0'])) {
            alert()->error('Gagal Menyimpan!', 'Maaf, kode mesin ini sudah didaftarkan dalam sistem!');
            return Redirect::back();
        }

        // Check duplicate nama
        $nama_check = DB::select("SELECT nama_mesin FROM vg_list_mesin WHERE nama_mesin = '".$request->nama_mesin."'");
        if (isset($nama_check['0'])) {
            alert()->error('Gagal Menyimpan!', 'Maaf, nama mesin ini sudah didaftarkan dalam sistem!');
            return Redirect::back();
        }


       // Insert data into database
        $mesin->save();
            alert()->success('Berhasil!', 'Data sukses disimpan!');
            return redirect('/mesin');
    }


    // fungsi untuk redirect ke halaman edit
    public function EditMesinData($id){
        $id = Crypt::decrypt($id);
        $departemen = DB::select('SELECT id_departemen, nama_departemen FROM vg_list_departemen');
        $subdepartemen = DB::select('SELECT id_sub_departemen, nama_sub_departemen FROM vg_list_sub_departemen');

        // Select data based on ID
        $machine = MesinModel::find($id);

        return view('admin.master.mesin-edit', [
            'menu'  => 'master',
            'sub'   => '/mesin',
            'mesin' => $machine,
            'departemen' => $departemen,
            'subdepartemen' => $subdepartemen,
        ]);
    }

    // simpan perubahan dari data yang sudah di edit
    public function SaveEditMesinData(Request $request){
        $id_mesin = $request->id_mesin;
        $id_departemen = $request->id_departemen;
        $id_sub_departemen = $request->id_sub_departemen;
        $kode_mesin = strtoupper($request->kode_mesin);
        $nama_mesin = strtoupper($request->nama_mesin);
        $updated_at = date('Y-m-d H:i:s', strtotime('+0 hours'));



        // is there a change in kode mesin data?
        if ($request->kode_mesin <> $request->original_kode_mesin){
         // Check duplicate kode
         $kode_check = DB::select("SELECT kode_mesin FROM vg_list_mesin WHERE kode_mesin = '".$request->kode_mesin."'");
         if (isset($kode_check['0'])) {
             alert()->error('Gagal Menyimpan!', 'Maaf, kode mesin ini sudah didaftarkan dalam sistem!');
             return Redirect::back();
         } else {
             //update data into database
             MesinModel::where('id_mesin', $id_mesin)->update([
                'kode_mesin'              => $kode_mesin,
                'nama_mesin'              => $nama_mesin,
                'id_departemen'           => $id_departemen,
                'id_sub_departemen'       => $id_sub_departemen,
                'updated_at'              => $updated_at,
             ]);
             alert()->success('Sukses!', 'Data berhasil diperbarui!');
             return redirect('/mesin');
         }
        }

        // is there a change in nama mesin data?
        if ($request->nama_mesin <> $request->original_nama_mesin){
         // Check duplicate nama
         $nama_check = DB::select("SELECT nama_mesin FROM vg_list_mesin WHERE nama_mesin = '".$request->nama_mesin."'");
         if (isset($nama_check['0'])) {
             alert()->error('Gagal Menyimpan!', 'Maaf, nama mesin ini sudah didaftarkan dalam sistem!');
             return Redirect::back();
         }
            } else {
                //update data into database
                MesinModel::where('id_mesin', $id_mesin)->update([
                   'kode_mesin'              => $kode_mesin,
                   'nama_mesin'              => $nama_mesin,
                   'id_departemen'           => $id_departemen,
                   'id_sub_departemen'       => $id_sub_departemen,
                   'updated_at'              => $updated_at,
                ]);
                alert()->success('Sukses!', 'Data berhasil diperbarui!');
                return redirect('/mesin');
            }

        {
            // Update data into database
            MesinModel::where('id_mesin', $id_mesin)->update([
                'kode_mesin'              => $kode_mesin,
                'nama_mesin'              => $nama_mesin,
                'id_departemen'           => $id_departemen,
                'id_sub_departemen'       => $id_sub_departemen,
                'updated_at'              => $updated_at,
            ]);

            alert()->success('Sukses!', 'Data berhasil diperbarui!');
            return redirect('/mesin');
        }
    }


     // Fungsi hapus data
     public function DeleteMesinData($id){
        $id = Crypt::decryptString($id);

        // Select table user to get user default value
        $machine = MesinModel::find($id, ['kode_mesin']);

        $creator_check = DB::select('SELECT * FROM tb_inspeksi_detail WHERE creator = '.$id);
        // Check user already used in other table or not yet
        if (isset($creator_check[0])) {
            Alert::error("Gagal!", 'Data ini tidak dapat dihapus karena sudah dipakai tabel lain!');
            return Redirect::back();
        }
        {
            // Delete process
            $machine = MesinModel::find($id);
            $machine->delete();

            // Move to users list page
            alert()->success('Berhasil!', 'Berhasil menghapus data!');
            return redirect('/mesin');
        }
     }
}
