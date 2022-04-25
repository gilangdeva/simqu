<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Str;
use App\Mail\SendResetPassword;
use App\Models\UsersModel; //Tambahkan folder models
use Redirect;
use Mail;
use DB;
use Crypt;

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
        return redirect('/users');
    }

    public function edit_user($id)
    {
        $users = DB::table('tb_master_users')->where('id_user',$id)->get();

        return view('admin.edit_user',['users' => $users]);
    }

    public function update(Request $request)
    {
        DB::table('tb_master_users')->where('id_user',$request->id)->update([
            'nama_user' => $request->nama,
            'password' => $request->password,
            'kode_user' => $request->kode_user,
            'jenis_user' => $request->jabatan,
            'id_departemen' => $request->id_departemen,
            'id_sub_departemen' => $request->id_sub_departemen    
        ]);
        return redirect('/users');
    }
    
    public function delete_user($id)
    {
        DB::table('tb_master_users')->where('id_user',$id)->delete();

        return redirect('/users');
    }
}
