<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Str;
use App\Mail\SendResetPassword;
use App\Models\UsersModel; //Tambahkan folder models
use Redirect;
use Mail;
use Crypt;
use DB;

class UsersController extends Controller
{
    public function users()
    {
        $users = DB::table('tb_master_users')->get();

        return view('admin.users', ['users' => $users]);
    }

    public function adduser()
    {
        return view('admin.adduser');
    }

    public function store(Request $request)
    {
        DB::table('tb_master_users')->insert([
            'nama_user' => $request->nama,
            'password' => $request->password,
            'kode_user' => $request->kode_user,
            'jenis_user' => $request->jabatan,
            'id_departemen' => $request->id_departemen,
            'id_sub_departemen' => $request->id_sub_departemen
        ]);
        return redirect('/admin.users');
    }
}
