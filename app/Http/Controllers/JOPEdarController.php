<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Imports\JOPEdarImport;
use Excel;
use Redirect;
use DB;
use Validator;

class JOPEdarController extends Controller
{
    public $path;

    public function __construct(){
        //specify path directory for saving excel files
        $this->path = public_path('/files/jop');
    }

    public function index(){
        $jop = DB::select("SELECT * FROM vw_list_jop_edar");
        $jenis_user = session()->get('jenis_user');

        if($jenis_user <> "Administrator"){
            alert()->warning('GAGAL!', 'Anda Tidak Memiliki Akses!');
            return Redirect('/');
        }

        return view('admin.master.jop-list',[
            'jop'           => $jop,
            'menu'          => 'upload',
            'sub'           => '/upload-jop',
            'jenis_user'    => $jenis_user
        ]);
    }

    public function UploadDataJOPEdar(Request $request){
        // Get file etension excel/csv
        set_time_limit(600);
        $validator = Validator::make([
                'upload_file'   => $request->upload_file,
                'extension'     => strtolower($request->upload_file->getClientOriginalExtension()),
            ],[
                'upload_file'   => 'required',
                'extension'     => 'required|in:csv,xlsx,xls',
            ]
        );

        // if file extention not valid
        if($validator->fails()) {
            return Redirect::back()->withErrors($validator);
        }

        $current_path = $request->file('upload_file')->store('temp');
        $new_path = storage_path('app').'/'.$current_path;

        // import all data in excel file into database tbl_stock
        Excel::import(new JOPEdarImport, $new_path);

        return redirect('/jop');
    }

    public function JOPSearch($text){
        $text = strtoupper($text);
        $jop = DB::select("SELECT jop, nama_barang FROM vw_list_jop_edar WHERE jop LIKE '%".$text."%' OR nama_barang LIKE '%".$text."%'");

        // Fetch all records
        $productsData['data'] = $jop;
        echo json_encode($productsData);
        exit;
    }
}
