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
use App\Http\Controllers\DepartmentController;
use App\Http\Controllers\SubDepartmentController;
use App\Http\Controllers\MesinController;
use App\Http\Controllers\SatuanController;
use Illuminate\Support\Facades\Http;

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

        $jenis_user = session()->get('jenis_user');

        // Menampilkan list lengkap untuk manager & admin
        if ($jenis_user == "Manager" || $jenis_user == "Administrator") {
            $list_inline = DB::table('vw_list_inline')
            ->where('tgl_inspeksi', '>=', $start_date)
            ->where('tgl_inspeksi', '<=', $end_date)
            ->get();
        } else {
            $list_inline = DB::table('vw_list_inline')
            ->where('tgl_inspeksi', '>=', $start_date)
            ->where('tgl_inspeksi', '<=', $end_date)
            ->where('id_user', '=', session()->get('id_user'))
            ->get();
        }

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
        $id_satuan  = DB::select("SELECT kode_satuan FROM vg_list_satuan");
        $jenis_user = session()->get('jenis_user');

        if($jenis_user == "Manager"){
            alert()->warning('GAGAL!', 'Anda Tidak Memiliki Akses!');
            return Redirect('/inline');
        }

        return view('inspeksi.inline-input',[
            'departemen'    => $departemen,
            'defect'        => $defect,
            'draft'         => $draft,
            'satuan'        => $satuan,
            'menu'          => 'inspeksi', // selalu ada di tiap function dan disesuaikan
            'sub'           => '/inline',
            'jenis_user'    => $jenis_user,
            'kode_satuan'   => $id_satuan
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
        $jam_mulai_ora = date('H:i:s', strtotime($request->jam_mulai));
        $jam_selesai_ora = date('H:i:s', strtotime($request->jam_selesai));
        $h1 = date('H', strtotime($request->jam_mulai));
        $h2 = date('H', strtotime($request->jam_selesai));

        $interval = round(($jam_selesai->format('U') - $jam_mulai->format('U')) / 60);
        // $lama_inspeksi = $interval;
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
        $video_1    = $request->file('video_1');
        $video_2    = $request->file('video_2');
        $file_original_video    = $request->original_video;

        if ($h1 == '23' && $h2 == '00'){
            $lama_inspeksi = $interval + 1440;
        } else {
            $lama_inspeksi = $interval;
        }

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

            if ($video_1 <> '') {

                $request->validate([
                    'video_1' => 'file|mimes:mp4,jpg'
                ]);

                $file = $video_1;

                $uploadedVideo = $request->file('video_1');
                // create filename with merging the timestamp and unique ID
                $name_v1 = Carbon::now()->timestamp . '_' . uniqid() . '.'. $file->getClientOriginalExtension();
                $destinationPath = public_path('/videos/defect/');
                $uploadedVideo->move($destinationPath, $name_v1);
                $video_1->video_1 = $destinationPath . $name_v1;

            } else {
                $name_v1 = $file_original_video;
            }

            if ($video_2 <> '') {

                $request->validate([
                    'video_2' => 'file|mimes:mp4,jpg'
                ]);

                $file = $video_2;

                $uploadedVideo = $request->file('video_2');
                // create filename with merging the timestamp and unique ID
                $name_v2 = Carbon::now()->timestamp . '_' . uniqid() . '.'. $file->getClientOriginalExtension();
                $destinationPath = public_path('/videos/defect/');
                $uploadedVideo->move($destinationPath, $name_v2);
                $video_2->video_2 = $destinationPath . $name_v2;

            } else {
                $name_v2 = $file_original_video;
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
                'satuan_qty_sampling'   => $satuan_qty_sampling,
                'video_1'               => $name_v1,
                'video_2'               => $name_v2
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
        $videos     = DB::select("SELECT video_1, video_2 FROM vw_draft_inline WHERE id_inspeksi_detail='".$id_detail."'");
        $video_1    = $videos[0]->video_1;
        $video_2    = $videos[0]->video_2;

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
        if (isset($video_1)) {
            if ($video_1 <> "blank.jpg") {
                File::delete(public_path("/videos/defect/".$video_1));
            }
        }
        if (isset($video_2)) {
            if ($video_2 <> "blank.jpg") {
                File::delete(public_path("/videos/defect/".$video_2));
            }
        }

            if ($count == 1){
                $inline_detail  = DB::table('draft_detail')->where('id_inspeksi_detail',$id_detail)->delete();
                $inline_detail  = DB::table('draft_header')->where('id_inspeksi_header',$id_header)->delete();

            $draft = DB::select("SELECT * FROM vw_draft_inline WHERE id_user =".session()->get('id_user')); // Select untuk list draft sesuai session user login

            return redirect('/inline-input');

        } else if ($count > 1) {
            $inline_detail  = DB::table('draft_detail')->where('id_inspeksi_detail',$id_detail)->delete();

                $draft = DB::select("SELECT * FROM vw_draft_inline WHERE id_user =".session()->get('id_user')); // Select untuk list draft sesuai session user login
                $shift = strtoupper($draft[0]->shift);
                $tgl_inspeksi = $draft[0]->tgl_inspeksi;
                $id_departemen = $draft[0]->id_departemen;
                $id_sub_departemen = $draft[0]->id_sub_departemen;
                $mesin = DB::select("SELECT id_mesin, nama_mesin FROM vg_list_mesin WHERE id_sub_departemen =".$id_sub_departemen);
                $defect = DB::select("SELECT id_defect, defect FROM vg_list_defect WHERE id_departemen =".$id_departemen);
                $jenis_user = session()->get('jenis_user');

                return redirect('/inline-input');
            }
        }

    // Fungsi hapus data list
    public function DeleteInlineDataList($id){
        $id_detail = Crypt::decryptString($id);
        $id_header = DB::select("SELECT id_inspeksi_header FROM tb_inspeksi_detail WHERE id_inspeksi_detail='".$id_detail."'");
        $id_header = $id_header[0]->id_inspeksi_header;

        $draft = DB::table('vw_list_inline')->WHERE('id_inspeksi_header',$id_header)->first();

        $type_form = "Inline"; // Inline
        $tgl_inspeksi = $draft->tgl_inspeksi;
        $shift = strtoupper($draft->shift);
        $id_user = session()->get('id_user');
        $id_departemen = $draft->id_departemen;
        $id_sub_departemen = $draft->id_sub_departemen;
        $jenis_user = session()->get('jenis_user');
        $status_approval = $draft->status_approval;
        $id_mesin = $draft->id_mesin;
        $qty_1 = $draft->qty_1;
        $qty_5 = $draft->qty_1*5;
        $pic = $draft->pic;
        $jam_mulai = new DateTime($draft->jam_mulai);
        $jam_selesai = new DateTime($draft->jam_selesai);
        $interval = round(($jam_selesai->format('U') - $jam_mulai->format('U')) / 60);
        $lama_inspeksi = $interval;
        $jop = $draft->jop;
        $item = $draft->item;
        $id_defect = $draft->id_defect;
        $kriteria = $draft->kriteria;
        $qty_defect = $draft->qty_defect;
        $qty_ready_pcs = $draft->qty_ready_pcs;
        $qty_sampling = $draft->qty_sampling;
        $penyebab = $draft->penyebab;
        $status = $draft->status;
        $keterangan = $draft->keterangan;
        $created_at = date('Y-m-d H:i:s', strtotime('+0 hours'));
        $updated_at = date('Y-m-d H:i:s', strtotime('+0 hours'));
        $creator = session()->get('id_user');
        $updater = session()->get('id_user');
        $picture_1 = $draft->picture_1;
        $picture_2 = $draft->picture_2;
        $picture_3 = $draft->picture_3;
        $picture_4 = $draft->picture_4;
        $picture_5 = $draft->picture_5;
        $satuan_qty_temuan = $draft->satuan_qty_temuan;
        $satuan_qty_ready_pcs = $draft->satuan_qty_ready_pcs;
        $satuan_qty_sampling = $draft->satuan_qty_sampling;
        $jenis_user = session()->get('jenis_user');
        $video_1    = $draft->video_1;
        $video_2    = $draft->video_2;

        $submitted_by = session()->get('id_user');
        $submitted_by = DB::select("SELECT nama_user FROM tb_master_users WHERE id_user='".$submitted_by."'");
        $submitted_by = $submitted_by[0]->nama_user;

        $id_approval = DB::select("SELECT id_approval FROM vg_list_id_approval");
        $id_approval = $id_approval[0]->id_approval;
        $cek_id_approval = DB::select("SELECT id_approval FROM vw_list_inline WHERE id_inspeksi_detail='".$id_detail."'");
        $cek_id_approval = $cek_id_approval[0]->id_approval;

        if ($status_approval == '') {
            // insert into database
            DB::table('tb_history_inspeksi')->insert([
                'id_inspeksi_header'    => $id_header,
                'type_form'             => $type_form,
                'tgl_inspeksi'          => $tgl_inspeksi,
                'shift'                 => $shift,
                'id_user'               => $id_user,
                'id_departemen'         => $id_departemen,
                'id_sub_departemen'     => $id_sub_departemen,
                'created_at'            => $created_at,
                'updated_at'            => $updated_at,
                'id_inspeksi_detail'    => $id_detail,
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
                'picture_1'             => $picture_1,
                'picture_2'             => $picture_2,
                'picture_3'             => $picture_3,
                'picture_4'             => $picture_4,
                'picture_5'             => $picture_5,
                'satuan_qty_temuan'     => $satuan_qty_temuan,
                'satuan_qty_ready_pcs'  => $satuan_qty_ready_pcs,
                'satuan_qty_sampling'   => $satuan_qty_sampling,
                'video_1'               => $video_1,
                'video_2'               => $video_2,
                'status_approval'       => 'Submitted',
                'id_approval'           => $id_approval,
                'submitted_by'          => $submitted_by
            ]);

            alert()->success('Pengajuan Berhasil!', 'Tunggu Approve Dari Manager!');
            return Redirect::back();
        } else {
            DB::table('tb_history_inspeksi')->where('id_inspeksi_detail',$id_detail)->update([
                'status_approval'     => 'Submitted',
            ]);

            alert()->success('Pengajuan Berhasil!', 'Tunggu Approve Dari Manager!');
            return Redirect::back();
        }
    }

    // Fungsi hapus data list approval
    public function ApprovalDeleteInlineDataList($id){
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
        if (isset($video_1)) {
            if ($video_1 <> "blank.jpg") {
                File::delete(public_path("/videos/defect/".$video_1));
            }
        }
        if (isset($video_2)) {
            if ($video_2 <> "blank.jpg") {
                File::delete(public_path("/videos/defect/".$video_2));
            }
        }

        if ($count == 1){
            $inline_detail  = DB::table('tb_inspeksi_detail')->where('id_inspeksi_detail',$id_detail)->delete();
            $inline_detail  = DB::table('tb_inspeksi_header')->where('id_inspeksi_header',$id_header)->delete();
            // $tb_history     = DB::table('tb_history_inspeksi')->where('id_inspeksi_detail', $id_detail)->delete();
        } else if ($count > 1) {
            $inline_detail  = DB::table('tb_inspeksi_detail')->where('id_inspeksi_detail',$id_detail)->delete();
            // $tb_history     = DB::table('tb_history_inspeksi')->where('id_inspeksi_detail', $id_detail)->delete();
        }

        $approved_by = session()->get('id_user');
        $approved_by = DB::select("SELECT nama_user FROM tb_master_users WHERE id_user='".$approved_by."'");
        $approved_by = $approved_by[0]->nama_user;

        $status_approval = "Deleted";

        // update status approval
        DB::table('tb_history_inspeksi')->where('id_inspeksi_detail',$id_detail)->update([
            'status_approval'     => $status_approval,
            'approved_by'           => $approved_by
        ]);

        // delete data inspeksi di table oracle
        $host = DB::table("tb_master_host")->orderBy('id_host','asc')->first();
        $request = Http::delete($host->host.'/api/cdet/'.$id_detail);// Url of your choosing

        alert()->success('Berhasil!', 'Data Berhasil Dihapus Dari List Inspeksi!');
        return Redirect::back();
    }

    // Fungsi keep data list approval
    public function ApprovalKeepInlineDataList($id){
        $id_detail = Crypt::decryptString($id);
        $id_header = DB::select("SELECT id_inspeksi_header FROM tb_inspeksi_detail WHERE id_inspeksi_detail='".$id_detail."'");
        $id_header = $id_header[0]->id_inspeksi_header;

        $jenis_user = session()->get('jenis_user');

        $approved_by = session()->get('id_user');
        $approved_by = DB::select("SELECT nama_user FROM tb_master_users WHERE id_user='".$approved_by."'");
        $approved_by = $approved_by[0]->nama_user;

        $status_approval = "Keeped";

        // update status approval
        DB::table('tb_history_inspeksi')->where('id_inspeksi_detail',$id_detail)->update([
            'status_approval'       => $status_approval,
            'approved_by'           => $approved_by
        ]);

        alert()->success('Berhasil!', 'Data Telah Diapprove!');
        return Redirect::back();
    }

    //Fungsi post inline into list
    public function PostInline(){
		$host = DB::table("tb_master_host")->orderBy('id_host','asc')->first();
        // Get ID Header
        $data = DB::select("SELECT COUNT(id_inspeksi_detail) as total_data, id_inspeksi_header  FROM vw_draft_inline  WHERE id_user='".session()->get('id_user')."' GROUP BY id_inspeksi_header ");
        $id_header = $data[0]->id_inspeksi_header; // ID Header
        $count_detail = $data[0]->total_data; // Total Baris Detail

        $id_header_ora = $id_header;
        $draft_header = DB::table('draft_header')->SELECT('id_inspeksi_header','tgl_inspeksi','shift','id_departemen','id_sub_departemen','created_at','updated_at')->WHERE('id_inspeksi_header',$id_header)->first();

        $type_form = "Inline"; // Inline
        $tgl_inspeksi = $draft_header->tgl_inspeksi;
        $shift = strtoupper($draft_header->shift);
        $id_user = session()->get('id_user');
        $id_departemen = $draft_header->id_departemen;
        $id_sub_departemen = $draft_header->id_sub_departemen;
        $jenis_user = session()->get('jenis_user');

		// Insert into ora DB
		$response = Http::asForm()->post($host->host.'/api/hd', [
			'ID_INSPEKSI_HEADER'    => $id_header_ora,
			'TYPE_FORM'             => $type_form,
			'TGL_INSPEKSI'          => $tgl_inspeksi,
			'SHIFT'                 => $shift,
			'ID_USER'               => $id_user,
			'ID_DEPARTEMEN'         => $id_departemen,
			'ID_SUB_DEPARTEMEN'     => $id_sub_departemen,
			'CREATED_AT'            => date('Y-m-d H:i:s', strtotime('+0 hours')),
			'UPDATED_AT'            => date('Y-m-d H:i:s', strtotime('+0 hours'))
		]);

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
				// 'satuan_qty_ready_pcs',
				// 'satuan_qty_sampling',
				'video_1',
				'video_2'
			)->where('id_inspeksi_detail', $id_detail)->first();

			$id_mesin = $draft_detail->id_mesin;
			$qty_1 = $draft_detail->qty_1;
			$qty_5 = $draft_detail->qty_1*5;
			$pic = $draft_detail->pic;
			$jam_mulai = new DateTime($draft_detail->jam_mulai);
			$jam_selesai = new DateTime($draft_detail->jam_selesai);
            $jam_mulai_ora = date('H:i:s', strtotime($draft_detail->jam_mulai));
            $jam_selesai_ora = date('H:i:s', strtotime($draft_detail->jam_selesai));
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
			// $satuan_qty_ready_pcs = $draft_detail->satuan_qty_ready_pcs;
			// $satuan_qty_sampling = $draft_detail->satuan_qty_sampling;
			$jenis_user = session()->get('jenis_user');
			$video_1    = $draft_detail->video_1;
			$video_2    = $draft_detail->video_2;

            // Insert into ora DB
            $response = Http::asForm()->post($host->host.'/api/dt', [
                'ID_INSPEKSI_DETAIL'        => $id_detail,
                'ID_INSPEKSI_HEADER'        => $id_header,
                'ID_MESIN'                  => $id_mesin,
                'QTY_1'                     => $qty_1,
                'QTY_5'                     => $qty_5,
                'PIC'                       => $pic,
                'JAM_MULAI'                 => $jam_mulai_ora,
                'JAM_SELESAI'               => $jam_selesai_ora,
                'LAMA_INSPEKSI'             => $lama_inspeksi,
                'JOP'                       => $jop,
                'ITEM'                      => $item,
                'ID_DEFECT'                 => $id_defect,
                'KRITERIA'                  => $kriteria,
                'QTY_DEFECT'                => $qty_defect,
                'QTY_READY_PCS'             => $qty_ready_pcs,
                'QTY_SAMPLING'              => $qty_sampling,
                'PENYEBAB'                  => $penyebab,
                'STATUS'                    => $status,
                'KETERANGAN'                => $keterangan,
                'CREATED_AT'                => date('Y-m-d H:i:s', strtotime('+0 hours')),
                'UPDATED_AT'                => date('Y-m-d H:i:s', strtotime('+0 hours')),
                'CREATOR'                   => $creator,
                'UPDATER'                   => $updater,
                'SATUAN_QTY_TEMUAN'         => $satuan_qty_temuan,
                // 'SATUAN_QTY_READY_PCS'      => $satuan_qty_ready_pcs,
                // 'SATUAN_QTY SAMPLING'       => $satuan_qty_sampling
             ]);

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
				'video_1'               => $video_1,
				'video_2'               => $video_2
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
                        ->where('jenis_user', '=', session()->get('jenis_user'))
                        ->where('id_user', '=', session()->get('id_user'))
                        ->get();
                } else if ($type_search =="ITEM"){
                    $list_inline = DB::table('vw_list_inline')
                        ->where('tgl_inspeksi', '>=', $start_date)
                        ->where('tgl_inspeksi', '<=', $end_date)
                        ->where('item', 'like', "%".$text_search."%")
                        ->where('jenis_user', '=', session()->get('jenis_user'))
                        ->where('id_user', '=', session()->get('id_user'))
                        ->get();
                } else {
                    $list_inline = DB::table('vw_list_inline')
                    ->where('tgl_inspeksi', '>=', $start_date)
                    ->where('tgl_inspeksi', '<=', $end_date)
                    ->where('jenis_user', '=', session()->get('jenis_user'))
                    ->where('id_user', '=', session()->get('id_user'))
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
