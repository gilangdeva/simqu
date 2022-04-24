<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class UsersController extends Controller
{
    public function users()
    {
        $users = DB::tb_master_users('user')->get();

        return view('users', ['user' => $users]);
    }
}
