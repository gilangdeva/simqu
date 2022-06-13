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

class InspeksiInlineController extends Controller
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

    // Menampilkan list inspeksi inline
    public function InlineList(){
        $start_date     = date('Y-m-01', strtotime('+0 hours'));
        $end_date       = date('Y-m-d', strtotime('+0 hours'));

        $list_inline = DB::table('vg_list_inline')
        ->where('tgl_inspeksi', '>=', $start_date)
        ->where('tgl_inspeksi', '<=', $end_date)
        ->get();

        return view('inspeksi.inline-list',
        [
            'list_inline'   => $list_inline,
            'menu'          => 'inspeksi',
            'sub'           => '/inline'
        ]);
    }

    // Redirect ke window input inspeksi inline
    public function InlineInput(){
        $departemen = DB::select("SELECT id_departemen, nama_departemen FROM vg_list_departemen");
        $defect = DB::select("SELECT id_defect, defect FROM vg_list_defect");
        $draft = DB::select("SELECT * FROM vg_draft_inline WHERE id_user =".session()->get('id_user')); // Select untuk list draft sesuai session user login

        return view('inspeksi.inline-input',[
            'departemen'    => $departemen,
            'defect'        => $defect,
            'draft'         => $draft,
            'menu'          => 'inspeksi', // selalu ada di tiap function dan disesuaikan
            'sub'           => '/inline'
        ]);
    }

    //Simpan data inspeksi inline
    public function SaveInlineData(Request $request){
        // Controller Wawan
        $row = 0;
        $cek_id_header = $request->id_inspeksi_header;
        $departemen = DB::select("SELECT id_departemen, nama_departemen FROM vg_list_departemen");
        $defect = DB::select("SELECT id_defect, defect FROM vg_list_defect");
        $draft = DB::select("SELECT * FROM vg_draft_inline WHERE id_user =".session()->get('id_user')); // Select untuk list draft sesuai session user login

        // Parameters Header
        $type_form = "Inline"; // Inline
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
        $mesin = DB::select("SELECT id_mesin, nama_mesin FROM vg_list_mesin WHERE id_sub_departemen =".$id_sub_departemen);

        if(($cek_id_header == '') || ($cek_id_header == '0')){
            $id_header = DB::select("SELECT id_inspeksi_header FROM vg_list_id_header");
            $id_header = $id_header[0]->id_inspeksi_header;
            $row = 1;

            // CHECK ADA DRAFT ATAU TIDAK (WAWAN)
            $draft_data = DB::select("SELECT id_inspeksi_header FROM vg_draft_inline WHERE id_user =".session()->get('id_user'));

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
        $id_mesin = $request->id_mesin;
        $qty_1 = $request->qty_1;
        $qty_5 = $request->qty_1*5;
        $pic = strtoupper($request->pic);
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
        $qty_sampling = $request->qty_sampling;
        $penyebab = $request->penyebab;
        $status = $request->status;
        $keterangan = $request->keterangan;
        $creator = session()->get('id_user');
        $updater = session()->get('id_user');
        $created_at = date('Y-m-d H:i:s', strtotime('+0 hours'));
        $updated_at = date('Y-m-d H:i:s', strtotime('+0 hours'));
        $capt_pict = $request->f_name;

        $pict_defect = $request->file('picture');
        if ($pict_defect <> '') {
            $this->validate($request, [
                'picture' => 'required|image|mimes:jpg,png,jpeg'
            ]);

            $file = $pict_defect;

            // create filename with merging the timestamp and unique ID
            $f_name = Carbon::now()->timestamp . '_' . uniqid() . '.'. $file->getClientOriginalExtension();

            // $f_name = $capt_pict .'.'. $file->getClientOriginalExtension();

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

        // insert into database
        DB::table('draft_detail')->insert([
            'id_inspeksi_detail'    => $id_detail,
            'id_inspeksi_header'    => $id_header,
            'id_mesin'              => $id_mesin,
            'qty_1'                 => $qty_1,
            'qty_5'                 => $qty_5,
            'pic'                   => $pic,
            'jam_mulai'             => $jam_mulai,
            'jam_selesai'           => $jam_selesai,
            'lama_inspeksi'         => $lama_inspeksi,
            'jop'                   => $jop,
            'item'                  => $item,
            'id_defect'             => $id_defect,
            'kriteria'              => $kriteria,
            'qty_defect'            => $qty_defect,
            'qty_ready_pcs'         => $qty_ready_pcs,
            'qty_sampling'          => $qty_sampling,
            'penyebab'              => $penyebab,
            'status'                => $status,
            'keterangan'            => $keterangan,
            'creator'               => $creator,
            'updater'               => $updater,
            'created_at'            => $created_at,
            'updated_at'            => $updated_at,
            'capt_pict'             => $f_name,
            'pict_defect'           => $pict_defect
        ]);

        if(($row == 0) || ($row == '')){
            alert()->success('Berhasil!', 'Data Sukses Disimpan!');
            return view('inspeksi.inline-input',[
                'departemen'        => $departemen,
                'subdepartemen'     => $subdepartemen,
                'mesin'             => $mesin,
                'defect'            => $defect,
                'menu'              => 'inspeksi',
                'sub'               => '/inline'
            ]);
        } else {
            $draft = DB::select("SELECT * FROM vg_draft_inline WHERE id_user =".session()->get('id_user')); // Select untuk list draft sesuai session user login
            alert()->success('Berhasil!', 'Data Sukses Disimpan!');
            return view('inspeksi.inline-input',[
                'id_header'         => $id_header,
                'tgl_inspeksi'      => $tgl_inspeksi,
                'shift'             => $shift,
                'id_departemen'     => $id_departemen,
                'departemen'        => $departemen,
                'id_sub_departemen' => $id_sub_departemen,
                'subdepartemen'     => $subdepartemen,
                'mesin'             => $mesin,
                'defect'            => $defect,
                'draft'             => $draft,
                'menu'              => 'inspeksi',
                'sub'               => '/inline'
            ]);
        }
        //End Controller Wawan
    }
        // Fungsi hapus data draft
        public function DeleteInlineData($id){
            $id_detail = Crypt::decryptString($id);
            $departemen = DB::select("SELECT id_departemen, nama_departemen FROM vg_list_departemen");
            $subdepartemen = DB::select("SELECT id_sub_departemen, nama_sub_departemen FROM vg_list_sub_departemen");
            $defect = DB::select("SELECT id_defect, defect FROM vg_list_defect");
            $id_header = DB::select("SELECT id_inspeksi_header FROM draft_detail WHERE id_inspeksi_detail='".$id_detail."'");
            $id_header = $id_header[0]->id_inspeksi_header;

            $count_detail = DB::select("SELECT COUNT (id_inspeksi_detail) FROM vg_draft_inline WHERE id_user=".session()->get('id_user')." GROUP BY id_inspeksi_header");
            $count = $count_detail[0]->count;

            if ($count == 1){
                $inline_detail  = DB::table('draft_detail')->where('id_inspeksi_detail',$id_detail)->delete();
                $inline_detail  = DB::table('draft_header')->where('id_inspeksi_header',$id_header)->delete();

                $draft = DB::select("SELECT * FROM vg_draft_inline WHERE id_user =".session()->get('id_user')); // Select untuk list draft sesuai session user login
                // $shift = strtoupper($draft[0]->shift);
                // $tgl_inspeksi = $draft[0]->tgl_inspeksi;
                // $id_departemen = $draft[0]->id_departemen;
                // $id_sub_departemen = $draft[0]->id_sub_departemen;
                // $mesin = DB::select("SELECT id_mesin, nama_mesin FROM vg_list_mesin WHERE id_sub_departemen =".$id_sub_departemen);

                return view('inspeksi.inline-input',[
                    'id_header'         => 0, //di set 0, nanti ketika save maka akan dapat id header baru
                    // 'tgl_inspeksi'      => $tgl_inspeksi,
                    // 'shift'             => $shift,
                    // 'mesin'             => $mesin,
                    // 'defect'            => $defect,
                    'departemen'        => $departemen,
                    'subdepartemen'     => $subdepartemen,
                    'defect'            => $defect,
                    'draft'             => $draft,
                    // 'id_departemen'     => $id_departemen,
                    // 'id_sub_departemen' => $id_sub_departemen,
                    'menu'              => 'inspeksi',
                    'sub'               => '/inline'
                ]);
            } else if ($count > 1) {
                $inline_detail  = DB::table('draft_detail')->where('id_inspeksi_detail',$id_detail)->delete();

                $draft = DB::select("SELECT * FROM vg_draft_inline WHERE id_user =".session()->get('id_user')); // Select untuk list draft sesuai session user login
                $shift = strtoupper($draft[0]->shift);
                $tgl_inspeksi = $draft[0]->tgl_inspeksi;
                $id_departemen = $draft[0]->id_departemen;
                $id_sub_departemen = $draft[0]->id_sub_departemen;
                $mesin = DB::select("SELECT id_mesin, nama_mesin FROM vg_list_mesin WHERE id_sub_departemen =".$id_sub_departemen);
                return view('inspeksi.inline-input',[
                    'id_header'         => $id_header,
                    'tgl_inspeksi'      => $tgl_inspeksi,
                    'shift'             => $shift,
                    'mesin'             => $mesin,
                    'departemen'        => $departemen,
                    'subdepartemen'     => $subdepartemen,
                    'defect'            => $defect,
                    'draft'             => $draft,
                    'id_departemen'     => $id_departemen,
                    'id_sub_departemen' => $id_sub_departemen,
                    'menu'              => 'inspeksi',
                    'sub'               => '/inline'
                ]);
            }
        }

        // Fungsi hapus data list
        public function DeleteInlineDataList($id){
            $id_detail = Crypt::decryptString($id);
            $id_header = DB::select("SELECT id_inspeksi_header FROM tb_inspeksi_detail WHERE id_inspeksi_detail='".$id_detail."'");
            $id_header = $id_header[0]->id_inspeksi_header;
            $count_detail = DB::select("SELECT COUNT ($id_detail) FROM vg_list_inline WHERE id_inspeksi_header='".$id_header."' GROUP BY id_inspeksi_header");
            $count = $count_detail[0]->count;
            if ($count == 1){
                $inline_detail  = DB::table('tb_inspeksi_detail')->where('id_inspeksi_detail',$id_detail)->delete();
                $inline_detail  = DB::table('tb_inspeksi_header')->where('id_inspeksi_header',$id_header)->delete();
                return redirect('/inline');
            } else if ($count > 1) {
                $inline_detail  = DB::table('tb_inspeksi_detail')->where('id_inspeksi_detail',$id_detail)->delete();
                return redirect('/inline');
            }
        }

        //Fungsi post inline into list
        public function PostInline(){
            // Get ID Header
            $data = DB::select("SELECT COUNT(id_inspeksi_detail) as total_data, id_inspeksi_header  FROM vg_draft_inline  WHERE id_user='".session()->get('id_user')."' GROUP BY id_inspeksi_header ");
            $id_header = $data[0]->id_inspeksi_header; // ID Header
            $count_detail = $data[0]->total_data; // Total Baris Detail

            $draft_header = DB::table('draft_header')->SELECT('id_inspeksi_header','tgl_inspeksi','shift','id_departemen','id_sub_departemen','created_at','updated_at')->WHERE('id_inspeksi_header',$id_header)->first();

            $type_form = "Inline"; // Inline
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
            $get_id_detail = DB::select("SELECT id_inspeksi_detail FROM vg_draft_inline WHERE id_inspeksi_header ='".$id_header."'");
            $id_detail = $get_id_detail[$i]->id_inspeksi_detail;

            $draft_detail  = DB::table('draft_detail')->SELECT(
                'id_inspeksi_detail',
                'id_mesin',
                'qty_1',
                'qty_5',
                'pic',
                'jam_mulai',
                'jam_selesai',
                'lama_inspeksi',
                'jop',
                'item',
                'id_defect',
                'kriteria',
                'qty_defect',
                'qty_ready_pcs',
                'qty_sampling',
                'penyebab',
                'status',
                'keterangan',
                'pict_defect'
            )->where('id_inspeksi_detail', $id_detail)->first();

            $id_mesin = $draft_detail->id_mesin;
            $qty_1 = $draft_detail->qty_1;
            $qty_5 = $draft_detail->qty_1*5;
            $pic = $draft_detail->pic;
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
            $qty_sampling = $draft_detail->qty_sampling;
            $penyebab = $draft_detail->penyebab;
            $status = $draft_detail->status;
            $keterangan = $draft_detail->keterangan;
            $pict_defect = $draft_detail->pict_defect;
            $created_at = date('Y-m-d H:i:s', strtotime('+0 hours'));
            $updated_at = date('Y-m-d H:i:s', strtotime('+0 hours'));
            $creator = session()->get('id_user');
            $updater = session()->get('id_user');
            $capt_pict = $draft_detail->capt_pict;

            $file = $pict_defect;

            // create filename with merging the timestamp and unique ID
            $f_name = Carbon::now()->timestamp . '_' . uniqid() . '.'. $file->getClientOriginalExtension();

            // $f_name = $capt_pict .'.'. $file->getClientOriginalExtension();

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


            // insert into database
            DB::table('tb_inspeksi_detail')->insert([
                'id_inspeksi_detail'    => $id_detail,
                'id_inspeksi_header'    => $id_header,
                'id_mesin'              => $id_mesin,
                'qty_1'                 => $qty_1,
                'qty_5'                 => $qty_5,
                'pic'                   => $pic,
                'jam_mulai'             => $jam_mulai,
                'jam_selesai'           => $jam_selesai,
                'lama_inspeksi'         => $lama_inspeksi,
                'jop'                   => $jop,
                'item'                  => $item,
                'id_defect'             => $id_defect,
                'kriteria'              => $kriteria,
                'qty_defect'            => $qty_defect,
                'qty_ready_pcs'         => $qty_ready_pcs,
                'qty_sampling'          => $qty_sampling,
                'penyebab'              => $penyebab,
                'status'                => $status,
                'keterangan'            => $keterangan,
                'created_at'            => $created_at,
                'updated_at'            => $updated_at,
                'creator'               => $creator,
                'updater'               => $updater,
                'capt_pict'             => $f_name
            ]);
        }
            // Delete header
            $delete_header = DB::table('draft_header')->where('id_inspeksi_header', $id_header)->delete();

            // Delete detail
            $delete_detail = DB::table('draft_detail')->where('id_inspeksi_header', $id_header)->delete();
            return redirect('/inline');
        }

    //Fungsi Filter List
    public function FilterInlineList(Request $request){
        if (request()->start_date || request()->end_date) {
            $start_date     = $request->start_date;
            $end_date       = $request->end_date;
            $type_search    = $request->type_search;
            $text_search    = strtoupper($request->text_search);

                if ($type_search =="JOP") {
                    $list_inline = DB::table('vg_list_inline')
                        ->where('tgl_inspeksi', '>=', $start_date)
                        ->where('tgl_inspeksi', '<=', $end_date)
                        ->where('jop', 'like', "%".$text_search."%")
                        ->get();
                } else if ($type_search =="ITEM"){
                    $list_inline = DB::table('vg_list_inline')
                        ->where('tgl_inspeksi', '>=', $start_date)
                        ->where('tgl_inspeksi', '<=', $end_date)
                        ->where('item', 'like', "%".$text_search."%")
                        ->get();
                } else if ($type_search =="INSPEKTOR"){
                    $list_inline = DB::table('vg_list_inline')
                        ->where('tgl_inspeksi', '>=', $start_date)
                        ->where('tgl_inspeksi', '<=', $end_date)
                        ->where('nama_user', 'like', "%".$text_search."%")
                        ->get();
                } else {
                    $list_inline = DB::table('vg_list_inline')
                    ->where('tgl_inspeksi', '>=', $start_date)
                    ->where('tgl_inspeksi', '<=', $end_date)
                    ->get();
                }

            return view('inspeksi.inline-list',
            [
                'list_inline'   => $list_inline,
                'menu'          => 'inspeksi',
                'sub'           => '/inline'
            ]);
        } else {
            $list_inline = DB::select("SELECT * FROM vg_list_inline");
            return view('inspeksi.inline-list',
            [
                'list_inline'   => $list_inline,
                'menu'          => 'inspeksi',
                'sub'           => '/inline'
            ]);
        }

    }
}
