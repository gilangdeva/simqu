<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

// Tambahkan source dibawah ini
use Illuminate\Support\Facades\DB;
use App\Models\DepartmentModel;
use App\Models\SubDepartmentModel;
use App\Models\MesinModel;
use App\Models\DefectModel;
use App\Models\DraftHeaderModel;
use App\Models\DraftDetailModel;

use Carbon\Carbon;
use Image;
use File;
use Crypt;
use Redirect;
use DateTime;
use RealRashid\SweetAlert\Facades\Alert;

class InspeksiFinalController extends Controller
{

    public $path;
    public $dimensions;

    public function __construct(){
        //specify path destination
        $this->path = public_path('/images/defect');
        //define dimention of photo
        $this->dimensions = ['500'];
        // $this->dimensions = ['245', '300', '500'];
    }

    // Menampilkan list inspeksi final
    public function FinalList(){
        $list_final = DB::select('SELECT * FROM vg_list_final');

        return view('inspeksi.final-list',
        [
            'list_final'    => $list_final,
            'menu'          => 'inspeksi',
            'sub'           => '/final'
        ]);
    }

    // Redirect ke window input inspeksi final
    public function FinalInput(){
        $departemen = DB::select("SELECT id_departemen, nama_departemen FROM vg_list_departemen");
        $defect = DB::select("SELECT id_defect, defect FROM vg_list_defect");
        $draft = DB::select("SELECT * FROM vg_draft_final WHERE id_user =".session()->get('id_user')); // Select untuk list draft sesuai session user login

        return view('inspeksi.final-input',[
            'departemen'    => $departemen,
            'defect'        => $defect,
            'draft'         => $draft,
            'menu'          => 'inspeksi', // selalu ada di tiap function dan disesuaikan
            'sub'           => '/final'
        ]);
    }

    //Simpan data inspeksi final
    public function SaveFinalData(Request $request){
        // Controller Wawan
        $row = 0;
        $cek_id_header = $request->id_inspeksi_header;
        $departemen = DB::select("SELECT id_departemen, nama_departemen FROM vg_list_departemen");
        $defect = DB::select("SELECT id_defect, defect FROM vg_list_defect");
        $draft = DB::select("SELECT * FROM vg_draft_final WHERE id_user =".session()->get('id_user')); // Select untuk list draft sesuai session user login

        // Parameters Header
        $type_form = "Final"; // Final
        $tgl_inspeksi = $request->tgl_inspeksi;
        $shift = strtoupper($request->shift);
        $id_user = session()->get('id_user');
        $id_departemen = $request->id_departemen;
        $id_sub_departemen = $request->id_sub_departemen;
        $created_at = date('Y-m-d H:i:s', strtotime('+0 hours'));
        $updated_at = date('Y-m-d H:i:s', strtotime('+0 hours'));

        // Check if null
        if(($id_departemen == '') || ($id_departemen == 0)){
            $id_departemen = $request->id_departemen_ori;
        }

        if(($id_sub_departemen == '') || ($id_sub_departemen == 0)){
            $id_sub_departemen = $request->id_sub_departemen_ori;
        }

        if(($shift == '') || ($shift == 0)){
            $shift = $request->shift_ori;
        }

        $subdepartemen = DB::select("SELECT id_sub_departemen, nama_sub_departemen FROM vg_list_sub_departemen WHERE id_departemen =".$id_departemen);

        if(($cek_id_header == '') || ($cek_id_header == '0')){
            $id_header = DB::select("SELECT id_inspeksi_header FROM vg_list_id_header");
            $id_header = $id_header[0]->id_inspeksi_header;
            $row = 1;

            // CHECK ADA DRAFT ATAU TIDAK (WAWAN)
            $draft_data = DB::select("SELECT id_inspeksi_header FROM vg_draft_final WHERE id_user =".session()->get('id_user'));

            if(isset($draft_data[0])) {
                alert()->error('Gagal Menyimpan!', 'Anda memiliki data yang belum di post!');
                return Redirect::back();
            }

            // insert into database
            DB::table('draft_header')->insert([
                'id_inspeksi_header'    => $id_header,
                'type_form'             => $type_form,
                'tgl_inspeksi'          => $tgl_inspeksi,
                'shift'                 => $shift,
                'id_user'               => $id_user,
                'id_departemen'         => $id_departemen,
                'id_sub_departemen'     => $id_sub_departemen,
                'created_at'            => $created_at,
                'updated_at'            => $updated_at
            ]);
        } else {
            $id_header = $cek_id_header;
            // tidak insert karena sudah ada di database
            $row = 1;
        }

        // Parameters Detail
        $id_detail = DB::select("SELECT id_inspeksi_detail FROM vg_list_id_detail");
        $id_detail = $id_detail[0]->id_inspeksi_detail;
        $id_header = $id_header;
        $jam_mulai = new DateTime($request->jam_mulai);
        $jam_selesai = new DateTime($request->jam_selesai);
        $interval = $jam_mulai->diff($jam_selesai);
        $lama_inspeksi = $interval->format('%i');
        $jop = strtoupper($request->jop);
        $item = strtoupper($request->item);
        $id_defect = $request->id_defect;
        $kriteria = $request->kriteria;
        $qty_defect = $request->qty_defect;
        $qty_ready_pcs = $request->qty_ready_pcs;
        $status = $request->status;
        $keterangan = $request->keterangan;
        $qty_ready_pack = $request->qty_ready_pack;
        $qty_sample_aql = $request->qty_sample_aql;
        $qty_sample_riil = $request->qty_sample_riil;
        $qty_reject_all = $request->qty_reject_all;
        $hasil_verifikasi = $request->hasil_verifikasi;
        $creator = session()->get('id_user');
        $updater = session()->get('id_user');

        $capt_pict = $request->f_name;
        $pict_defect = $request->file('picture');
            if ($pict_defect <> '') {

                $this->validate($request, [
                    'picture' => 'required|image|mimes:jpg,png,jpeg'
                ]);

                $file = $pict_defect;

                // create filename with merging the timestamp and unique ID
                $f_name = Carbon::now()->timestamp . '_' . uniqid() . '.'. $file->getClientOriginalExtension();

                // upload original file (dimension hasn't been comppressed)
                // Image::make($file)->save($this->path . '/' . $f_name);

                //Looping array of image dimension that has been specify on contruct
                foreach ($this->dimensions as $row) {
                    //create image canvas according to dimension on array
                    $canvas = Image::canvas($row, $row);

                    //rezise according the dimension on array (still keep ratio)
                    $resizeImage  = Image::make($file)->resize($row, $row, function($constraint) {
                        $constraint->aspectRatio();
                    });

                    // insert image that compressed into canvas
                    $canvas->insert($resizeImage, 'center');

                    // move image in folder
                    $canvas->save($this->path . '/' . $f_name);
                }
            } 

            $pict_defect->picture = $f_name;


        // insert into database
        DB::table('draft_detail')->insert([
            'id_inspeksi_detail'    => $id_detail,
            'id_inspeksi_header'    => $id_header,
            'jam_mulai'             => $jam_mulai,
            'jam_selesai'           => $jam_selesai,
            'lama_inspeksi'         => $lama_inspeksi,
            'jop'                   => $jop,
            'item'                  => $item,
            'id_defect'             => $id_defect,
            'kriteria'              => $kriteria,
            'qty_defect'            => $qty_defect,
            'qty_ready_pcs'         => $qty_ready_pcs,
            'status'                => $status,
            'qty_ready_pcs'         => $qty_ready_pcs,
            'keterangan'            => $keterangan,
            'qty_ready_pack'        => $qty_ready_pack,
            'qty_sample_aql'        => $qty_sample_aql,
            'qty_sample_riil'       => $qty_sample_riil,
            'qty_reject_all'        => $qty_reject_all,
            'hasil_verifikasi'      => $hasil_verifikasi,
            'creator'               => $creator,
            'updater'               => $updater,
            'created_at'            => $created_at,
            'updated_at'            => $updated_at,
            'capt_pict'             => $f_name,
            'pict_defect'           => $pict_defect
        ]);

        if(($row == 0) || ($row == '')){
            alert()->success('Berhasil!', 'Data Sukses Disimpan!');
            return view('inspeksi.final-input',[
                'departemen'        => $departemen,
                'subdepartemen'     => $subdepartemen,
                'defect'            => $defect,
                'menu'              => 'inspeksi',
                'sub'               => '/final'
            ]);
        } else {
            $draft = DB::select("SELECT * FROM vg_draft_final WHERE id_user =".session()->get('id_user'));
            alert()->success('Berhasil!', 'Data Sukses Disimpan!');
            return view('inspeksi.final-input',[
                'id_header'         => $id_header,
                'tgl_inspeksi'      => $tgl_inspeksi,
                'shift'             => $shift,
                'id_departemen'     => $id_departemen,
                'departemen'        => $departemen,
                'id_sub_departemen' => $id_sub_departemen,
                'subdepartemen'     => $subdepartemen,
                'defect'            => $defect,
                'draft'             => $draft,
                'menu'              => 'inspeksi',
                'sub'               => '/final'
            ]);
        }
        //End Controller Wawan
    }
        // Fungsi hapus data draft
        public function DeleteFinalData($id){
            $id_detail = Crypt::decryptString($id);
            $departemen = DB::select("SELECT id_departemen, nama_departemen FROM vg_list_departemen");
            $subdepartemen = DB::select("SELECT id_sub_departemen, nama_sub_departemen FROM vg_list_sub_departemen");
            $defect = DB::select("SELECT id_defect, defect FROM vg_list_defect");
            $id_header = DB::select("SELECT id_inspeksi_header FROM draft_detail WHERE id_inspeksi_detail='".$id_detail."'");
            $id_header = $id_header[0]->id_inspeksi_header;

            $count_detail = DB::select("SELECT COUNT (id_inspeksi_detail) FROM vg_draft_final WHERE id_user=".session()->get('id_user')." GROUP BY id_inspeksi_header");
            $count = $count_detail[0]->count;

            if ($count == 1){
                $final_detail  = DB::table('draft_detail')->where('id_inspeksi_detail',$id_detail)->delete();
                $final_detail  = DB::table('draft_header')->where('id_inspeksi_header',$id_header)->delete();

                $draft = DB::select("SELECT * FROM vg_draft_final WHERE id_user =".session()->get('id_user'));
                return view('inspeksi.final-input',[
                    'id_header'         => 0,
                    'departemen'        => $departemen,
                    'subdepartemen'     => $subdepartemen,
                    'defect'            => $defect,
                    'draft'             => $draft,
                    'menu'              => 'inspeksi',
                    'sub'               => '/final'
                ]);
            } else if ($count > 1) {
                $final_detail  = DB::table('draft_detail')->where('id_inspeksi_detail',$id_detail)->delete();

                $draft = DB::select("SELECT * FROM vg_draft_final WHERE id_user =".session()->get('id_user'));
                $shift = strtoupper($draft[0]->shift);
                $tgl_inspeksi = $draft[0]->tgl_inspeksi;
                $id_departemen = $draft[0]->id_departemen;
                $id_sub_departemen = $draft[0]->id_sub_departemen;

                return view('inspeksi.final-input',[
                    'id_header'         => $id_header,
                    'tgl_inspeksi'      => $tgl_inspeksi,
                    'shift'             => $shift,
                    'departemen'        => $departemen,
                    'subdepartemen'     => $subdepartemen,
                    'defect'            => $defect,
                    'draft'             => $draft,
                    'id_departemen'     => $id_departemen,
                    'id_sub_departemen' => $id_sub_departemen,
                    'menu'              => 'inspeksi',
                    'sub'               => '/final'
                ]);
            }
        }

        // Fungsi hapus data list
        public function DeleteFinalDataList($id){
            $id_detail = Crypt::decryptString($id);
            $id_header = DB::select("SELECT id_inspeksi_header FROM tb_inspeksi_detail WHERE id_inspeksi_detail='".$id_detail."'");
            $id_header = $id_header[0]->id_inspeksi_header;
            $count_detail = DB::select("SELECT COUNT ($id_detail) FROM vg_list_final WHERE id_inspeksi_header='".$id_header."' GROUP BY id_inspeksi_header");            $count = $count_detail[0]->count;
            if ($count == 1){
                $final_detail  = DB::table('tb_inspeksi_detail')->where('id_inspeksi_detail',$id_detail)->delete();
                $final_detail  = DB::table('tb_inspeksi_header')->where('id_inspeksi_header',$id_header)->delete();
                return redirect('/final');
            } else if ($count > 1) {
                $final_detail  = DB::table('tb_inspeksi_detail')->where('id_inspeksi_detail',$id_detail)->delete();
                return redirect('/final');
            }
        }

        //Fungsi post final into list
        public function PostFinal(){
            // Get ID Header
            $data = DB::select("SELECT COUNT(id_inspeksi_detail) as total_data, id_inspeksi_header  FROM vg_draft_final  WHERE id_user='".session()->get('id_user')."' GROUP BY id_inspeksi_header ");
            $id_header = $data[0]->id_inspeksi_header; // ID Header
            $count_detail = $data[0]->total_data; // Total Baris Detail

            $draft_header = DB::table('draft_header')->SELECT('id_inspeksi_header','tgl_inspeksi','shift','id_departemen','id_sub_departemen','created_at','updated_at')->WHERE('id_inspeksi_header',$id_header)->first();

            $type_form = "Final"; // Final
            $tgl_inspeksi = $draft_header->tgl_inspeksi;
            $shift = strtoupper($draft_header->shift);
            $id_user = session()->get('id_user');
            $id_departemen = $draft_header->id_departemen;
            $id_sub_departemen = $draft_header->id_sub_departemen;

            // insert into database
            DB::table('tb_inspeksi_header')->insert([
            'id_inspeksi_header'    => $id_header,
            'type_form'             => $type_form,
            'tgl_inspeksi'          => $tgl_inspeksi,
            'shift'                 => $shift,
            'id_user'               => $id_user,
            'id_departemen'         => $id_departemen,
            'id_sub_departemen'     => $id_sub_departemen,
            'created_at'            => date('Y-m-d H:i:s', strtotime('+0 hours')),
            'updated_at'            => date('Y-m-d H:i:s', strtotime('+0 hours'))
        ]);

        for ($i=0; $i<$count_detail; $i++) {
            // Get ID Detail
            $get_id_detail = DB::select("SELECT id_inspeksi_detail FROM vg_draft_final WHERE id_inspeksi_header ='".$id_header."'");
            $id_detail = $get_id_detail[$i]->id_inspeksi_detail;

            $draft_detail  = DB::table('draft_detail')->SELECT(
                'id_inspeksi_detail',
                'jam_mulai',
                'jam_selesai',
                'lama_inspeksi',
                'jop',
                'item',
                'id_defect',
                'kriteria',
                'qty_defect',
                'qty_ready_pcs',
                'status',
                'keterangan',
                'qty_ready_pack',
                'qty_sample_aql',
                'qty_sample_riil',
                'qty_reject_all',
                'hasil_verifikasi',
                'capt_pict',
                'pict_defect'

            )->where('id_inspeksi_detail', $id_detail)->first();

            $jam_mulai = new DateTime($draft_detail->jam_mulai);
            $jam_selesai = new DateTime($draft_detail->jam_selesai);
            $interval = $jam_mulai->diff($jam_selesai);
            $lama_inspeksi = $interval->format('%i');
            $jop = $draft_detail->jop;
            $item = $draft_detail->item;
            $id_defect = $draft_detail->id_defect;
            $kriteria = $draft_detail->kriteria;
            $qty_defect = $draft_detail->qty_defect;
            $qty_ready_pcs = $draft_detail->qty_ready_pcs;
            $status = $draft_detail->status;
            $keterangan = $draft_detail->keterangan;
            $qty_ready_pack = $draft_detail->qty_ready_pack;
            $qty_sample_aql = $draft_detail->qty_sample_aql;
            $qty_sample_riil = $draft_detail->qty_sample_riil;
            $qty_reject_all = $draft_detail->qty_reject_all;
            $hasil_verifikasi = $draft_detail->hasil_verifikasi;
            $created_at = date('Y-m-d H:i:s', strtotime('+0 hours'));
            $updated_at = date('Y-m-d H:i:s', strtotime('+0 hours'));
            $creator = session()->get('id_user');
            $updater = session()->get('id_user');
            $capt_pict = $draft_detail->capt_pict;
            $pict_defect = $draft_detail->pict_defect;

            // insert into database
            DB::table('tb_inspeksi_detail')->insert([
                'id_inspeksi_detail'    => $id_detail,
                'id_inspeksi_header'    => $id_header,
                'jam_mulai'             => $jam_mulai,
                'jam_selesai'           => $jam_selesai,
                'lama_inspeksi'         => $lama_inspeksi,
                'jop'                   => $jop,
                'item'                  => $item,
                'id_defect'             => $id_defect,
                'kriteria'              => $kriteria,
                'qty_defect'            => $qty_defect,
                'qty_ready_pcs'         => $qty_ready_pcs,
                'status'                => $status,
                'keterangan'            => $keterangan,
                'qty_ready_pack'        => $qty_ready_pack,
                'qty_sample_aql'        => $qty_sample_aql,
                'qty_sample_riil'       => $qty_sample_riil,
                'qty_reject_all'        => $qty_reject_all,
                'hasil_verifikasi'      => $hasil_verifikasi,
                'created_at'            => $created_at,
                'updated_at'            => $updated_at,
                'creator'               => $creator,
                'updater'               => $updater,
                'capt_pict'             => $capt_pict,
                'pict_defect'           => $pict_defect
            ]);
        }
            // Delete header
            $delete_header = DB::table('draft_header')->where('id_inspeksi_header', $id_header)->delete();

            // Delete detail
            $delete_detail = DB::table('draft_detail')->where('id_inspeksi_header', $id_header)->delete();
            return redirect('/final');
        }

        //Fungsi Filter List
    public function FilterFinalList(Request $request){
        if (request()->start_date || request()->end_date) {
            $start_date     = $request->start_date;
            $end_date       = $request->end_date;
            $type_search    = $request->type_search;
            $text_search    = strtoupper($request->text_search);

                if ($type_search =="JOP") {
                    $list_final = DB::table('vg_list_final')
                        ->where('tgl_inspeksi', '>=', $start_date)
                        ->where('tgl_inspeksi', '<=', $end_date)
                        ->where('jop', 'LIKE', "%{$text_search}%")
                        ->get();
                } else if ($type_search =="ITEM"){
                    $list_final = DB::table('vg_list_final')
                        ->where('tgl_inspeksi', '>=', $start_date)
                        ->where('tgl_inspeksi', '<=', $end_date)
                        ->where('item', 'LIKE', "%{$text_search}%")
                        ->get();
                } else if ($type_search =="INSPEKTOR"){
                    $list_final = DB::table('vg_list_final')
                        ->where('tgl_inspeksi', '>=', $start_date)
                        ->where('tgl_inspeksi', '<=', $end_date)
                        ->where('nama_user', 'LIKE', "%{$text_search}%")
                        ->get();
                } else {
                    $list_final = DB::table('vg_list_final')
                    ->where('tgl_inspeksi', '>=', $start_date)
                    ->where('tgl_inspeksi', '<=', $end_date)
                    ->get();
                }

            return view('inspeksi.final-list',
            [
                'list_final'   => $list_final,
                'menu'          => 'inspeksi',
                'sub'           => '/final'
            ]);
        } else {
            $list_final = DB::select("SELECT * FROM vg_list_final");
            return view('inspeksi.final-list',
            [
                'list_final'   => $list_final,
                'menu'          => 'inspeksi',
                'sub'           => '/final'
            ]);
        }

    }
}
