<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

// Tambahkan source dibawah ini
use Illuminate\Support\Facades\DB;
use App\Models\DepartmentModel;
use App\Models\SatuanModel;
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
        $this->dimensions = ['1500'];
        // $this->dimensions = ['245', '300', '500'];
    }

    // Menampilkan list inspeksi inline
    public function InlineList(){
        $start_date     = date('Y-m-01', strtotime('+0 hours'));
        $end_date       = date('Y-m-d', strtotime('+0 hours'));

        $list_inline = DB::table('vw_list_inline')
        ->where('tgl_inspeksi', '>=', $start_date)
        ->where('tgl_inspeksi', '<=', $end_date)
        ->get();

        $jenis_user = session()->get('jenis_user');

        return view('inspeksi.inline-list',
        [
            'list_inline'   => $list_inline,
            'menu'          => 'inspeksi',
            'sub'           => '/inline',
            'jenis_user'    => $jenis_user
        ]);
    }

    // Redirect ke window input inspeksi inline
    public function InlineInput(){
        $departemen = DB::select("SELECT id_departemen, nama_departemen FROM vg_list_departemen");
        $defect = DB::select("SELECT id_defect, defect, critical, major, minor FROM vg_list_defect");
        $draft = DB::select("SELECT * FROM vw_draft_inline WHERE id_user =".session()->get('id_user')); // Select untuk list draft sesuai session user login
        $satuan = DB::select("SELECT id_satuan, nama_satuan, kode_satuan FROM vg_list_satuan");
        $jenis_user = session()->get('jenis_user');

        return view('inspeksi.inline-input',[
            'departemen'    => $departemen,
            'defect'        => $defect,
            'draft'         => $draft,
            'satuan'        => $satuan,
            'menu'          => 'inspeksi', // selalu ada di tiap function dan disesuaikan
            'sub'           => '/inline',
            'jenis_user'    => $jenis_user
        ]);
    }

    //Simpan data inspeksi inline
    public function SaveInlineData(Request $request){
        // Controller Wawan
        $row = 0;
        $cek_id_header = $request->id_inspeksi_header;
        $departemen = DB::select("SELECT id_departemen, nama_departemen FROM vg_list_departemen");
        $defect = DB::select("SELECT id_defect, defect FROM vg_list_defect");
        $draft = DB::select("SELECT * FROM vw_draft_inline WHERE id_user =".session()->get('id_user')); // Select untuk list draft sesuai session user login
        $jenis_user = session()->get('jenis_user');

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
        $defect = DB::select("SELECT id_defect, defect FROM vg_list_defect WHERE id_departemen =".$id_departemen);
        $mesin = DB::select("SELECT id_mesin, nama_mesin FROM vg_list_mesin WHERE id_sub_departemen =".$id_sub_departemen);

        if(($cek_id_header == '') || ($cek_id_header == '0')){
            $id_header = DB::select("SELECT id_inspeksi_header FROM vg_list_id_header");
            $id_header = $id_header[0]->id_inspeksi_header;
            $row = 1;

            // CHECK ADA DRAFT ATAU TIDAK (WAWAN)
            $draft_data = DB::select("SELECT id_inspeksi_header FROM vw_draft_inline WHERE id_user =".session()->get('id_user'));

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

        $satuan = DB::select("SELECT id_satuan, nama_satuan, kode_satuan FROM vg_list_satuan");

        // Parameters Detail
        $id_detail = DB::select("SELECT id_inspeksi_detail FROM vg_list_id_detail");
        $id_detail = $id_detail[0]->id_inspeksi_detail;
        $id_header = $id_header;
        $id_mesin = $request->id_mesin;
        $satuan_qty_temuan = $request->satuan_qty_temuan;
        $satuan_qty_ready_pcs = $request->satuan_qty_ready_pcs;
        $satuan_qty_sampling = $request->satuan_qty_sampling;

        $qty_1 = $request->qty_1;
        $qty_5 = $request->qty_1*5;
        $pic = strtoupper($request->pic);
        $jam_mulai = new DateTime($request->jam_mulai);
        $jam_selesai = new DateTime($request->jam_selesai);
        // $interval = $jam_mulai->diff($jam_selesai);
        // $lama_inspeksi = $interval->format('%i');
        $interval = round(($jam_selesai->format('U') - $jam_mulai->format('U')) / 60);
        $lama_inspeksi = $interval;

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
        $picture_1 = $request->file('picture_1');
        $picture_2 = $request->file('picture_2');
        $picture_3 = $request->file('picture_3');
        $picture_4 = $request->file('picture_4');
        $picture_5 = $request->file('picture_5');
        $file_original_picture = $request->original_picture;

            if ($picture_1 <> '') {
                $this->validate($request, [
                    'picture_1' => 'image|mimes:jpg,png,jpeg'
                ]);

                $file = $picture_1;

                // create filename with merging the timestamp and unique ID
                $name_p1 = Carbon::now()->timestamp . '_' . uniqid() . '.'. $file->getClientOriginalExtension();

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
                    $canvas->save($this->path . '/' . $name_p1);
                }

            } else {
                $name_p1 = $file_original_picture;
            }

            if ($picture_2 <> '') {
                $this->validate($request, [
                    'picture_2' => 'image|mimes:jpg,png,jpeg'
                ]);

                $file = $picture_2;

                // create filename with merging the timestamp and unique ID
                $name_p2 = Carbon::now()->timestamp . '_' . uniqid() . '.'. $file->getClientOriginalExtension();

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
                    $canvas->save($this->path . '/' . $name_p2);
                }
            } else {
                $name_p2 = $file_original_picture;
            }

            if ($picture_3 <> '') {
                $this->validate($request, [
                    'picture_3' => 'image|mimes:jpg,png,jpeg'
                ]);

                $file = $picture_3;

                // create filename with merging the timestamp and unique ID
                $name_p3 = Carbon::now()->timestamp . '_' . uniqid() . '.'. $file->getClientOriginalExtension();

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
                    $canvas->save($this->path . '/' . $name_p3);
                }
            } else {
                $name_p3 = $file_original_picture;
            }

            if ($picture_4 <> '') {
                $this->validate($request, [
                    'picture_4' => 'image|mimes:jpg,png,jpeg'
                ]);

                $file = $picture_4;

                // create filename with merging the timestamp and unique ID
                $name_p4 = Carbon::now()->timestamp . '_' . uniqid() . '.'. $file->getClientOriginalExtension();

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
                    $canvas->save($this->path . '/' . $name_p4);
                }
            } else {
                $name_p4 = $file_original_picture;
            }

            if ($picture_5 <> '') {
                $this->validate($request, [
                    'picture_5' => 'image|mimes:jpg,png,jpeg'
                ]);

                $file = $picture_5;

                // create filename with merging the timestamp and unique ID
                $name_p5 = Carbon::now()->timestamp . '_' . uniqid() . '.'. $file->getClientOriginalExtension();

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
                    $canvas->save($this->path . '/' . $name_p5);
                }
            } else {
                $name_p5 = $file_original_picture;
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
                'picture_1'             => $name_p1,
                'picture_2'             => $name_p2,
                'picture_3'             => $name_p3,
                'picture_4'             => $name_p4,
                'picture_5'             => $name_p5,
                'satuan_qty_temuan'     => $satuan_qty_temuan,
                'satuan_qty_ready_pcs'  => $satuan_qty_ready_pcs,
                'satuan_qty_sampling'   => $satuan_qty_sampling
                // 'video_1'            => $name_v1,
                // 'video_2'            => $name_v2
            ]);

        if(($row == 0) || ($row == '')){
            alert()->success('Berhasil!', 'Data Sukses Disimpan!');
            return view('inspeksi.inline-input',[
                'departemen'        => $departemen,
                'subdepartemen'     => $subdepartemen,
                'mesin'             => $mesin,
                'defect'            => $defect,
                'satuan'            => $satuan,
                'menu'              => 'inspeksi',
                'sub'               => '/inline',
                'jenis_user'        => $jenis_user
            ]);
        } else {
            // REFRESH DRAFT
            $draft = DB::select("SELECT * FROM vw_draft_inline WHERE id_user =".session()->get('id_user')); // Select untuk list draft sesuai session user login
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
                'satuan'            => $satuan,
                'menu'              => 'inspeksi',
                'sub'               => '/inline',
                'jenis_user'        => $jenis_user
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
            $pictures = DB::select("SELECT picture_1, picture_2, picture_3, picture_4, picture_5 FROM vw_draft_inline WHERE id_inspeksi_detail='".$id_detail."'");
            $satuan = DB::select("SELECT id_satuan, nama_satuan, kode_satuan FROM vg_list_satuan");
            $picture_1 = $pictures[0]->picture_1;
            $picture_2 = $pictures[0]->picture_2;
            $picture_3 = $pictures[0]->picture_3;
            $picture_4 = $pictures[0]->picture_4;
            $picture_5 = $pictures[0]->picture_5;

            $count_detail = DB::select("SELECT COUNT (id_inspeksi_detail) FROM vw_draft_inline WHERE id_user=".session()->get('id_user')." GROUP BY id_inspeksi_header");
            $count = $count_detail[0]->count;

            $jenis_user = session()->get('jenis_user');

            // Delete Pictures
            if (isset($picture_1)) {
                if ($picture_1 <> "blank.jpg") {
                    File::delete(public_path("/images/defect/".$picture_1));
                }
            }
            if (isset($picture_2)) {
                if ($picture_2 <> "blank.jpg") {
                    File::delete(public_path("/images/defect/".$picture_2));
                }
            }
            if (isset($picture_3)) {
                if ($picture_3 <> "blank.jpg") {
                    File::delete(public_path("/images/defect/".$picture_3));
                }
            }
            if (isset($picture_4)) {
                if ($picture_4 <> "blank.jpg") {
                    File::delete(public_path("/images/defect/".$picture_4));
                }
            }
            if (isset($picture_5)) {
                if ($picture_5 <> "blank.jpg") {
                    File::delete(public_path("/images/defect/".$picture_5));
                }
            }

            if ($count == 1){
                $inline_detail  = DB::table('draft_detail')->where('id_inspeksi_detail',$id_detail)->delete();
                $inline_detail  = DB::table('draft_header')->where('id_inspeksi_header',$id_header)->delete();

                $draft = DB::select("SELECT * FROM vw_draft_inline WHERE id_user =".session()->get('id_user')); // Select untuk list draft sesuai session user login

                return view('inspeksi.inline-input',[
                    'id_header'         => 0, //di set 0, nanti ketika save maka akan dapat id header baru
                    'departemen'        => $departemen,
                    'subdepartemen'     => $subdepartemen,
                    'defect'            => $defect,
                    'draft'             => $draft,
                    'satuan'            => $satuan,
                    'menu'              => 'inspeksi',
                    'sub'               => '/inline',
                    'jenis_user'        => $jenis_user
                ]);
            } else if ($count > 1) {
                $inline_detail  = DB::table('draft_detail')->where('id_inspeksi_detail',$id_detail)->delete();

                $draft = DB::select("SELECT * FROM vw_draft_inline WHERE id_user =".session()->get('id_user')); // Select untuk list draft sesuai session user login
                $shift = strtoupper($draft[0]->shift);
                $tgl_inspeksi = $draft[0]->tgl_inspeksi;
                $id_departemen = $draft[0]->id_departemen;
                $id_sub_departemen = $draft[0]->id_sub_departemen;
                $mesin = DB::select("SELECT id_mesin, nama_mesin FROM vg_list_mesin WHERE id_sub_departemen =".$id_sub_departemen);
                $defect = DB::select("SELECT id_defect, defect FROM vg_list_defect where id_departemen =".$id_departemen);
                $jenis_user = session()->get('jenis_user');

                return view('inspeksi.inline-input',[
                    'id_header'         => $id_header,
                    'tgl_inspeksi'      => $tgl_inspeksi,
                    'shift'             => $shift,
                    'mesin'             => $mesin,
                    'departemen'        => $departemen,
                    'subdepartemen'     => $subdepartemen,
                    'defect'            => $defect,
                    'draft'             => $draft,
                    'satuan'            => $satuan,
                    'id_departemen'     => $id_departemen,
                    'id_sub_departemen' => $id_sub_departemen,
                    'menu'              => 'inspeksi',
                    'sub'               => '/inline',
                    'jenis_user'        => $jenis_user
                ]);
            }
        }

        // Fungsi hapus data list
        public function DeleteInlineDataList($id){
            $id_detail = Crypt::decryptString($id);
            $id_header = DB::select("SELECT id_inspeksi_header FROM tb_inspeksi_detail WHERE id_inspeksi_detail='".$id_detail."'");
            $id_header = $id_header[0]->id_inspeksi_header;
            $count_detail = DB::select("SELECT COUNT ($id_detail) FROM vw_list_inline WHERE id_inspeksi_header='".$id_header."' GROUP BY id_inspeksi_header");
            $count = $count_detail[0]->count;
            $pictures = DB::select("SELECT picture_1, picture_2, picture_3, picture_4, picture_5 FROM vw_list_inline WHERE id_inspeksi_detail='".$id_detail."'");
            $picture_1 = $pictures[0]->picture_1;
            $picture_2 = $pictures[0]->picture_2;
            $picture_3 = $pictures[0]->picture_3;
            $picture_4 = $pictures[0]->picture_4;
            $picture_5 = $pictures[0]->picture_5;
            $satuan = DB::select("SELECT satuan_qty_temuan, satuan_qty_ready_pcs, satuan_qty_sampling FROM tb_inspeksi_detail WHERE id_inspeksi_detail='".$id_detail."'");
            $satuan_qty_temuan = $satuan[0]->satuan_qty_temuan;
            $satuan_qty_ready_pcs = $satuan[0]->satuan_qty_ready_pcs;
            $satuan_qty_sampling = $satuan[0]->satuan_qty_sampling;
            $jenis_user = session()->get('jenis_user');

            // Delete Pictures
            if (isset($picture_1)) {
                if ($picture_1 <> "blank.jpg") {
                    File::delete(public_path("/images/defect/".$picture_1));
                }
            }
            if (isset($picture_2)) {
                if ($picture_2 <> "blank.jpg") {
                    File::delete(public_path("/images/defect/".$picture_2));
                }
            }
            if (isset($picture_3)) {
                if ($picture_3 <> "blank.jpg") {
                    File::delete(public_path("/images/defect/".$picture_3));
                }
            }
            if (isset($picture_4)) {
                if ($picture_4 <> "blank.jpg") {
                    File::delete(public_path("/images/defect/".$picture_4));
                }
            }
            if (isset($picture_5)) {
                if ($picture_5 <> "blank.jpg") {
                    File::delete(public_path("/images/defect/".$picture_5));
                }
            }

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
            $data = DB::select("SELECT COUNT(id_inspeksi_detail) as total_data, id_inspeksi_header  FROM vw_draft_inline  WHERE id_user='".session()->get('id_user')."' GROUP BY id_inspeksi_header ");
            $id_header = $data[0]->id_inspeksi_header; // ID Header
            $count_detail = $data[0]->total_data; // Total Baris Detail

            $draft_header = DB::table('draft_header')->SELECT('id_inspeksi_header','tgl_inspeksi','shift','id_departemen','id_sub_departemen','created_at','updated_at')->WHERE('id_inspeksi_header',$id_header)->first();

            $type_form = "Inline"; // Inline
            $tgl_inspeksi = $draft_header->tgl_inspeksi;
            $shift = strtoupper($draft_header->shift);
            $id_user = session()->get('id_user');
            $id_departemen = $draft_header->id_departemen;
            $id_sub_departemen = $draft_header->id_sub_departemen;
            $jenis_user = session()->get('jenis_user');

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
            $get_id_detail = DB::select("SELECT id_inspeksi_detail FROM vw_draft_inline WHERE id_inspeksi_header ='".$id_header."'");
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
                'picture_1',
                'picture_2',
                'picture_3',
                'picture_4',
                'picture_5',
                'satuan_qty_temuan',
                'satuan_qty_ready_pcs',
                'satuan_qty_sampling'
            )->where('id_inspeksi_detail', $id_detail)->first();

            $id_mesin = $draft_detail->id_mesin;
            $qty_1 = $draft_detail->qty_1;
            $qty_5 = $draft_detail->qty_1*5;
            $pic = $draft_detail->pic;
            $jam_mulai = new DateTime($draft_detail->jam_mulai);
            $jam_selesai = new DateTime($draft_detail->jam_selesai);
            $interval = round(($jam_selesai->format('U') - $jam_mulai->format('U')) / 60);
            $lama_inspeksi = $interval;
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
            $created_at = date('Y-m-d H:i:s', strtotime('+0 hours'));
            $updated_at = date('Y-m-d H:i:s', strtotime('+0 hours'));
            $creator = session()->get('id_user');
            $updater = session()->get('id_user');
            $picture_1 = $draft_detail->picture_1;
            $picture_2 = $draft_detail->picture_2;
            $picture_3 = $draft_detail->picture_3;
            $picture_4 = $draft_detail->picture_4;
            $picture_5 = $draft_detail->picture_5;
            $satuan_qty_temuan = $draft_detail->satuan_qty_temuan;
            $satuan_qty_ready_pcs = $draft_detail->satuan_qty_ready_pcs;
            $satuan_qty_sampling = $draft_detail->satuan_qty_sampling;
            $jenis_user = session()->get('jenis_user');


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
                'picture_1'             => $picture_1,
                'picture_2'             => $picture_2,
                'picture_3'             => $picture_3,
                'picture_4'             => $picture_4,
                'picture_5'             => $picture_5,
                'satuan_qty_temuan'     => $satuan_qty_temuan,
                'satuan_qty_ready_pcs'  => $satuan_qty_ready_pcs,
                'satuan_qty_sampling'   => $satuan_qty_sampling
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
            $jenis_user = session()->get('jenis_user');

                if ($type_search =="JOP") {
                    $list_inline = DB::table('vw_list_inline')
                        ->where('tgl_inspeksi', '>=', $start_date)
                        ->where('tgl_inspeksi', '<=', $end_date)
                        ->where('jop', 'like', "%".$text_search."%")
                        ->get();
                } else if ($type_search =="ITEM"){
                    $list_inline = DB::table('vw_list_inline')
                        ->where('tgl_inspeksi', '>=', $start_date)
                        ->where('tgl_inspeksi', '<=', $end_date)
                        ->where('item', 'like', "%".$text_search."%")
                        ->get();
                } else if ($type_search =="INSPEKTOR"){
                    $list_inline = DB::table('vw_list_inline')
                        ->where('tgl_inspeksi', '>=', $start_date)
                        ->where('tgl_inspeksi', '<=', $end_date)
                        ->where('nama_user', 'like', "%".$text_search."%")
                        ->get();
                } else {
                    $list_inline = DB::table('vw_list_inline')
                    ->where('tgl_inspeksi', '>=', $start_date)
                    ->where('tgl_inspeksi', '<=', $end_date)
                    ->get();
                }

            return view('inspeksi.inline-list',
            [
                'list_inline'   => $list_inline,
                'menu'          => 'inspeksi',
                'start_date'    => $start_date,
                'end_date'      => $end_date,
                'sub'           => '/inline',
                'jenis_user'    => $jenis_user
            ]);
        } else {
            $list_inline = DB::select("SELECT * FROM vw_list_inline");
            return view('inspeksi.inline-list',
            [
                'list_inline'   => $list_inline,
                'menu'          => 'inspeksi',
                'start_date'    => $start_date,
                'end_date'      => $end_date,
                'sub'           => '/inline',
                'jenis_user'    => $jenis_user
            ]);
        }

    }
}
