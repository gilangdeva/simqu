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
}
