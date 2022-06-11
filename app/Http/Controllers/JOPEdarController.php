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
        return view('admin.master.jop-list',[
            'menu'   => 'upload',
            'sub'    => '/upload-jop',
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
}
