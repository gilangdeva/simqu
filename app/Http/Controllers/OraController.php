<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use Image;
use File;
use Crypt;
use Redirect;
use RealRashid\SweetAlert\Facades\Alert;
use Illuminate\Support\Facades\Http;

class OraController extends Controller
{
    public function index() {
        $host = DB::table("tb_master_host")->orderBy('id_host', 'desc')->first();

        $request = Http::get('http://192.168.204.5:9000/api/dept');// Url of your choosing
        return $request;
        // $x = count(json_decode($request, true));

    }
}
