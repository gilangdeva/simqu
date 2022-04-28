<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

// Tambahkan source dibawah ini
use Illuminate\Support\Facades\DB;
use App\Models\InspeksiHeaderModel;
use Image;
use File;
use date;
use Crypt;
use Redirect;
use RealRashid\SweetAlert\Facades\Alert;

class InspeksiHeaderController extends Controller
{
    
    // Menampilkan list inpeksi header
    public function InspeksiHeaderList(){
        // Get all data from database
        $inspeksiheader = InspeksiHeaderModel::all();

        return view('admin.master.inspeksiheader-list',[
            'menu'  => 'master',
            'sub'   => '/inspeksiheader',
            'inspeksiheader' => $inspeksiheader
        ]);
    }

    // Redirect ke window input inspeksiheader
    public function InspeksiHeaderInput(){
        return view('admin.master.inspeksiheader-input',[
            'menu'  => 'master', // selalu ada di tiap function dan disesuaikan
            'sub'   => '/inspeksiheader'
        ]);
    }

    //Simpan data inspeksiheader
    public function SaveInspeksiHeaderData(Request $request){
        $inspeksiheader = new InspeksiHeaderModel();

        // Parameters
        $inspeksiheader->id_user = strtoupper($request->id_user);
        $inspeksiheader->tgl_inspeksi = $request->tgl_mulai_periode;
        $inspeksiheader->id_shift = strtoupper($request->id_shift);


       // Insert data into database
        $inspeksiheader->save();
            alert()->success('Berhasil!', 'Data sukses disimpan!');
            return redirect('/inspeksiheader');
    }


    // fungsi untuk redirect ke halaman edit
    public function EditInspeksiHeaderData($id){
        $id = Crypt::decrypt($id);

        // Select data based on ID
        $inspeksiheader = InspeksiHeaderModel::find($id);
        
        return view('admin.master.inspeksiheader-edit', [
            'menu'  => 'master',
            'sub'   => '/inspeksiheader',
            'subdepartment' => $inspeksiheader,
        ]);
    }

    // simpan perubahan dari data yang sudah di edit
    public function SaveEditInspeksiHeaderData(Request $request){
        $id_inspeksi_header = $request->id_inspeksi_header;
        $id_user = strtoupper($request->id_user);
        $tgl_inspeksi = $request->tgl_inspeksi;
        $id_shift = strtoupper($request->id_shift);
        $updated_at = date('Y-m-d H:i:s', strtotime('+0 hours'));
 


        // return $request;


        {
            // Update data into database
            InspeksiHeaderModel::where('id_inspeksi_header', $id_inspeksi_header)->update([
                'id_user'                  => $id_user,
                'tgl_inspeksi'             => $tgl_inspeksi,
                'id_shift'                 => $id_shift,
                'updated_at'               => $updated_at,
            ]);
            
            alert()->success('Sukses!', 'Data berhasil diperbarui!');
            return redirect('/inpeksiheader');
        }
    }

    // Fungsi hapus data
    public function DeleteInspeksiHeaderData($id){
        $id = Crypt::decryptString($id);
        
        // Select table user to get user default value
        $inspeksiheader = InspeksiHeaderModel::find($id, ['tgl_inspeksi']);
        
        $creator_check = DB::select('SELECT * FROM tb_inspeksi_detail WHERE creator = '.$id);
        // Check user already used in other table or not yet
        if (isset($creator_check[0])) {
            Alert::error("Gagal!", 'Data ini tidak dapat dihapus karena sudah dipakai tabel lain!');
            return Redirect::back(); 
        }
        {
            // Delete process
            $inspeksiheader = InspeksiHeaderModel::find($id);
            $inspeksiheader->delete();

            // Move to inpeksi header list page
            alert()->success('Berhasil!', 'Berhasil menghapus data!');
            return redirect('/inspeksiheader');
        }
    }
}





