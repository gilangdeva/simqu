<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function Index(){
        return view('admin.blank',[
            'menu'  => 'dashboard',
            'sub'   => '/dashboard',
        ]);
    }
}
