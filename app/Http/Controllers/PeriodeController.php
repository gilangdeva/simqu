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
        $periode = PeriodeModel::orderBy('urutan', 'ASC')->orderBy('minggu_ke', 'ASC')->groupBy('tahun', 'id_periode')->get();
        $jenis_user = session()->get('jenis_user');

        if($jenis_user <> "Administrator"){
            alert()->warning('GAGAL!', 'Anda Tidak Memiliki Akses!');
            return Redirect('/');
        }

        return view('admin.master.periode-list',[
            'menu'          => 'master',
            'sub'           => '/periode',
            'periode'       => $periode,
            'jenis_user'    => $jenis_user
        ]);
    }

    // Redirect ke window input periode
    public function PeriodeInput(){
        $jenis_user = session()->get('jenis_user');

        if($jenis_user <> "Administrator"){
            alert()->warning('GAGAL!', 'Anda Tidak Memiliki Akses!');
            return Redirect('/');
        }

        return view('admin.master.periode-input',[
            'menu'          => 'master', // selalu ada di tiap function dan disesuaikan
            'sub'           => '/periode',
            'jenis_user'    => $jenis_user
        ]);
    }

    //Simpan data periode
    public function SavePeriodeData(Request $request){
        $periode = new PeriodeModel();
        $jenis_user = session()->get('jenis_user');

        // Parameters
        $periode->tahun = $request->tahun;
        $periode->bulan = $request->bulan;
        $periode->minggu_ke = $request->minggu_ke;
        $periode->tgl_mulai_periode = $request->tgl_mulai_periode;
        $periode->tgl_akhir_periode = $request->tgl_akhir_periode;


        if ($request->bulan =="Januari"){
            $periode->urutan = "1";
        } else if($request->bulan == "Februari"){
            $periode->urutan = "2";
        } else if($request->bulan == "Maret"){
            $periode->urutan = "3";
        } else if($request->bulan == "April"){
            $periode->urutan = "4";
        } else if($request->bulan == "Mei"){
            $periode->urutan = "5";
        } else if($request->bulan == "Juni"){
            $periode->urutan = "6";
        } else if($request->bulan == "Juli"){
            $periode->urutan = "7";
        } else if($request->bulan == "Agustus"){
            $periode->urutan = "8";
        } else if($request->bulan == "September"){
            $periode->urutan = "9";
        } else if($periode->bulan == "Oktober"){
            $periode->urutan = "10";
        } else if($periode->bulan == "November"){
            $periode->urutan = "11";
        } else if($periode->bulan == "Desember"){
            $periode->urutan = "12";
        }

        //Validasi data input
        if ($request->bulan == "0" || $request->minggu_ke == "0"){
            alert()->error('Gagal Input Data!', 'Maaf, Ada Kesalahan Penginputan Data!');

            return view('admin.master.periode-input',[
                'menu'          => 'master', // selalu ada di tiap function dan disesuaikan
                'sub'           => '/periode',
                'select'        => $periode,
                'jenis_user'    => $jenis_user
            ]);
        }

        // Check duplicate date
        $available_date_check = DB::select("SELECT * FROM vg_list_periode WHERE tahun = '".$request->tahun."' AND bulan = '".$request->bulan."' AND minggu_ke = '".$request->minggu_ke."'");
        if (isset($available_date_check['0'])) {
            alert()->error('Gagal Menyimpan!', 'Maaf, Periode Ini Sudah Didaftarkan Dalam Sistem!');

            return view('admin.master.periode-input',[
                'menu'          => 'master', // selalu ada di tiap function dan disesuaikan
                'sub'           => '/periode',
                'select'        => $periode,
                'jenis_user'    => $jenis_user
            ]);
        } else {
            // Insert data into database
            $periode->save();
            alert()->success('Berhasil!', 'Data Sukses Disimpan!');
            return redirect('/periode');
        }
    }

    // fungsi untuk redirect ke halaman edit
    public function EditPeriodeData($id){
        $id = Crypt::decrypt($id);
        $jenis_user = session()->get('jenis_user');

        if($jenis_user <> "Administrator"){
            alert()->warning('GAGAL!', 'Anda Tidak Memiliki Akses!');
            return Redirect('/');
        }

        // Select data based on ID
        $period = PeriodeModel::find($id);

        return view('admin.master.periode-edit', [
            'menu'          => 'master',
            'sub'           => '/periode',
            'periode'       => $period,
            'jenis_user'    => $jenis_user
        ]);
    }

    // simpan perubahan dari data yang sudah di edit
    public function SaveEditPeriodeData(Request $request){
        $jenis_user = session()->get('jenis_user');
        $id_periode = $request->id_periode;
        $tahun = $request->tahun;
        $bulan = $request->bulan;
        $minggu_ke = $request->minggu_ke;
        $tgl_mulai_periode = $request->tgl_mulai_periode;
        $tgl_akhir_periode = $request->tgl_akhir_periode;
        $updated_at = date('Y-m-d H:i:s', strtotime('+0 hours'));

        // Is there a change in date data?
        if ($request->tahun <> $request->original_tahun || $request->bulan <> $request->original_bulan || $request->minggu_ke <> $request->original_minggu_ke){
            // Check duplicate data
            $available_date_check = DB::select("SELECT * FROM vg_list_periode WHERE tahun = '".$request->tahun."' AND bulan = '".$request->bulan."' AND minggu_ke = '".$request->minggu_ke."'");
            if (isset($available_date_check['0'])) {
                alert()->error('Gagal!', 'Maaf, Periode Ini Sudah Didaftarkan Dalam Sistem!');

                $period = PeriodeModel::find($id_periode);

                return view('admin.master.periode-edit', [
                    'menu'          => 'master',
                    'sub'           => '/periode',
                    'periode'       => $period,
                    'jenis_user'    => $jenis_user
                ]);

            } else {
            // Update data into database
            PeriodeModel::where('id_periode', $id_periode)->update([
                'tahun'                   => $tahun,
                'bulan'                   => $bulan,
                'minggu_ke'               => $minggu_ke,
                'tgl_mulai_periode'       => $tgl_mulai_periode,
                'tgl_akhir_periode'       => $tgl_akhir_periode,
                'updated_at'              => $updated_at,
                ]);

                alert()->success('Sukses!', 'Data Berhasil Diperbarui!');
                return redirect('/periode');
            }
        } else {
            // Update data into database
            PeriodeModel::where('id_periode', $id_periode)->update([
                'tahun'                   => $tahun,
                'bulan'                   => $bulan,
                'minggu_ke'               => $minggu_ke,
                'tgl_mulai_periode'       => $tgl_mulai_periode,
                'tgl_akhir_periode'       => $tgl_akhir_periode,
                'updated_at'              => $updated_at,
            ]);

            alert()->success('Sukses!', 'Data Berhasil Diperbarui!');
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
        alert()->success('Berhasil!', 'Berhasil Menghapus Data!');
        return redirect('/periode');
    }
}

