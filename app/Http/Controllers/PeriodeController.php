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
use Illuminate\Support\Facades\Http;

class PeriodeController extends Controller
{
    // Menampilkan list periode
    public function PeriodeList(){
        // Get all data from database
        // $periode = PeriodeModel::orderBy('urutan', 'ASC')->orderBy('minggu_ke', 'ASC')->groupBy('tahun', 'id_periode')->get();
        $periode = DB::select("SELECT * from vg_periode");
        $jenis_user = session()->get('jenis_user');
        $id_periode = DB::select("SELECT id_periode FROM tb_master_periode");
        $tahun = DB::select("SELECT tahun FROM tb_master_periode");
        $bulan = DB::select("SELECT bulan FROM tb_master_periode");
        $minggu_ke = DB::select("SELECT minggu_ke FROM tb_master_periode");

        if($jenis_user <> "Administrator"){
            alert()->warning('GAGAL!', 'Anda Tidak Memiliki Akses!');
            return Redirect('/');
        }

        // // Insert into ora DB
		// $response = Http::asForm()->where('tahun', $tahun AND 'bulan', $bulan)->update($host->host.'/api/prd', [
		// 	'ID_PERIODE'            => $id_periode
		// ]);

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
        $id_periode = DB::select("SELECT id_periode FROM vid_periode");
        $id_periode = $id_periode[0]->id_periode;
        $jenis_user = session()->get('jenis_user');

        // Parameters
        $periode->tahun = $request->tahun;
        $periode->bulan = strtoupper($request->bulan);
        $periode->id_periode = $id_periode;
        $periode->minggu_ke = $request->minggu_ke;
        $periode->tgl_mulai_periode = $request->tgl_mulai_periode;
        $periode->tgl_akhir_periode = $request->tgl_akhir_periode;

        $host               = DB::table("tb_master_host")->orderBy('id_host','asc')->first();
        $jenis_user         = session()->get('jenis_user');
        $tahun              = $request->tahun;
        $bulan              = strtoupper($periode->bulan);
        $minggu_ke          = $request->minggu_ke;
        $tgl_mulai_periode  = $request->tgl_mulai_periode;
        $tgl_akhir_periode  = $request->tgl_akhir_periode;
        $updated_at         = date('Y-m-d H:i:s', strtotime('+0 hours'));

        if ($bulan =="JANUARI"){
            $periode->urutan = "1";
        } else if($bulan == "FEBRUARI"){
            $periode->urutan = "2";
        } else if($bulan == "MARET"){
            $periode->urutan = "3";
        } else if($bulan == "APRIL"){
            $periode->urutan = "4";
        } else if($bulan == "MEI"){
            $periode->urutan = "5";
        } else if($bulan == "JUNI"){
            $periode->urutan = "6";
        } else if($bulan == "JULI"){
            $periode->urutan = "7";
        } else if($bulan == "AGUSTUS"){
            $periode->urutan = "8";
        } else if($bulan == "SEPTEMBER"){
            $periode->urutan = "9";
        } else if($bulan == "OKTOBER"){
            $periode->urutan = "10";
        } else if($bulan == "NOVEMBER"){
            $periode->urutan = "11";
        } else if($bulan == "DESEMBER"){
            $periode->urutan = "12";
        }else{
            $periode->urutan = "0";
        }

        $urutan     = $periode->urutan;

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
        // Insert into ora DB
        $response = Http::asForm()->post($host->host.'/api/prd', [
            'ID_PERIODE'            => $id_periode,
            'TAHUN'                 => $tahun,
            'BULAN'                 => $bulan,
            'MINGGU_KE'             => $minggu_ke,
            'TGL_MULAI_PERIODE'     => $tgl_mulai_periode,
            'TGL_AKHIR_PERIODE'     => $tgl_akhir_periode,
            'URUTAN'                => $urutan,
            'CREATED_AT'            => date('Y-m-d H:i:s', strtotime('+0 hours')),
            'UPDATED_AT'            => date('Y-m-d H:i:s', strtotime('+0 hours'))
        ]);

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
        $bulan = strtoupper($request->bulan);
        $minggu_ke = $request->minggu_ke;
        $tgl_mulai_periode = $request->tgl_mulai_periode;
        $tgl_akhir_periode = $request->tgl_akhir_periode;
        $updated_at = date('Y-m-d H:i:s', strtotime('+0 hours'));

        $host = DB::table("tb_master_host")->orderBy('id_host','asc')->first();

        if ($bulan =="JANUARI"){
            $urutan = "1";
        } else if($bulan == "FEBRUARI"){
            $urutan = "2";
        } else if($bulan == "MARET"){
            $urutan = "3";
        } else if($bulan == "APRIL"){
            $urutan = "4";
        } else if($bulan == "MEI"){
            $urutan = "5";
        } else if($bulan == "JUNI"){
            $urutan = "6";
        } else if($bulan == "JULI"){
            $urutan = "7";
        } else if($bulan == "AGUSTUS"){
            $urutan = "8";
        } else if($bulan == "SEPTEMBER"){
            $urutan = "9";
        } else if($bulan == "OKTOBER"){
            $urutan = "10";
        } else if($bulan == "NOVEMBER"){
            $urutan = "11";
        } else if($bulan == "DESEMBER"){
            $urutan = "12";
        }else{
            $urutan = "0";
        }

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
                'urutan'                  => $urutan
                ]);
            }

            // Update into ora DB
            $response = Http::asForm()->put($host->host.'/api/pupd', [
                'ID_PERIODE'            => $id_periode,
                'TAHUN'                 => $tahun,
                'BULAN'                 => $bulan,
                'MINGGU_KE'             => $minggu_ke,
                'TGL_MULAI_PERIODE'     => $tgl_mulai_periode,
                'TGL_AKHIR_PERIODE'     => $tgl_akhir_periode,
                'URUTAN'                => $urutan,
                'CREATED_AT'            => date('Y-m-d H:i:s', strtotime('+0 hours')),
                'UPDATED_AT'            => date('Y-m-d H:i:s', strtotime('+0 hours'))
            ]);

            alert()->success('Sukses!', 'Data Berhasil Diperbarui!');
            return redirect('/periode');
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

        // delete data inspeksi di table oracle
        $host = DB::table("tb_master_host")->orderBy('id_host','asc')->first();
        $request = Http::delete($host->host.'/api/pdel/'.$id);// Url of your choosing

        // Move to periode list page
        alert()->success('Berhasil!', 'Berhasil Menghapus Data!');
        return redirect('/periode');
    }
}

