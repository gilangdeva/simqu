<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

// Tambahkan source dibawah ini
use Illuminate\Support\Facades\DB;
use App\Models\PeriodeModel;
use Image;
use File;
use date;
use Crypt;
use Redirect;
use RealRashid\SweetAlert\Facades\Alert;

class PeriodeController extends Controller
{


    // Menampilkan list periode
    public function PeriodeList(){
        // Get all data from database
        $periode = PeriodeModel::all();

        return view('admin.master.periode-list',[
            'menu'  => 'master',
            'sub'   => '/periode',
            'periode' => $periode
        ]);
    }

    // Redirect ke window input periode
    public function PeriodeInput(){
        return view('admin.master.periode-input',[
            'menu'  => 'master', // selalu ada di tiap function dan disesuaikan
            'sub'   => '/periode'
        ]);
    }

    //Simpan data periode
    public function SavePeriodeData(Request $request){
        $periode = new PeriodeModel();

        // Parameters
        $periode->tahun = $request->tahun;
        $periode->bulan = $request->bulan;
        $periode->minggu_ke = $request->minggu_ke;
        $periode->tgl_mulai_periode = $request->tgl_mulai_periode;
        $periode->tgl_akhir_periode = $request->tgl_akhir_periode;

        // Check duplicate kode
        $available_date_check = DB::select("SELECT * FROM vg_list_periode WHERE tahun = '".$request->tahun."' AND bulan = '".$request->bulan."' AND minggu_ke = '".$request->minggu_ke."'");
        if (isset($available_date_check['0'])) {
            alert()->error('Gagal Menyimpan!', 'Maaf, kode ini sudah didaftarkan dalam sistem!');
            return Redirect::back();
        } else {
            // Insert data into database
            $periode->save();
            alert()->success('Berhasil!', 'Data sukses disimpan!');
            return redirect('/periode');
        }
    }


    // fungsi untuk redirect ke halaman edit
    public function EditPeriodeData($id){
        $id = Crypt::decrypt($id);

        // Select data based on ID
        $period = PeriodeModel::find($id);

        return view('admin.master.periode-edit', [
            'menu'  => 'master',
            'sub'   => '/periode',
            'periode' => $period,
        ]);
    }

    // simpan perubahan dari data yang sudah di edit
    public function SaveEditPeriodeData(Request $request){
        $id_periode = $request->id_periode;
        $tahun = $request->tahun;
        $bulan = $request->bulan;
        $minggu_ke = $request->minggu_ke;
        $tgl_mulai_periode = $request->tgl_mulai_periode;
        $tgl_akhir_periode = $request->tgl_akhir_periode;
        $updated_at = date('d-m-Y H:i:s', strtotime('+0 hours'));

        // Check duplicate kode
        $available_date_check = DB::select("SELECT * FROM vg_list_periode
        WHERE tahun = '".$request->tahun."' AND bulan = '".$request->bulan."' AND minggu_ke = '".$request->minggu_ke."'");
        if (isset($available_date_check['0'])) {
            alert()->error('Gagal Menyimpan!', 'Maaf, periode ini sudah didaftarkan dalam sistem!');
            return Redirect::back();
        } else  {
            // Update data into database
            PeriodeModel::where('id_periode', $id_periode)->update([
                'tahun'                   => $tahun,
                'bulan'                   => $bulan,
                'minggu_ke'               => $minggu_ke,
                'tgl_mulai_periode'       => $tgl_mulai_periode,
                'tgl_akhir_periode'       => $tgl_akhir_periode,
                'updated_at'              => $updated_at,
            ]);

            alert()->success('Sukses!', 'Data berhasil diperbarui!');
            return redirect('/periode');
        }
    }


    // Fungsi hapus data
    public function DeletePeriodeData($id){
        $id = Crypt::decryptString($id);

        // Delete process
        $period = PeriodeModel::find($id);
        $period->delete();

        // Move to periode list page
        alert()->success('Berhasil!', 'Berhasil menghapus data!');
        return redirect('/periode');
    }
}

