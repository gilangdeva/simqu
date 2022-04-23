<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class BelajarController extends Controller
{
    function index() {
        $judul = "UEFA CUP";
        $Tim1 = "Liverpool";
        $Tim2 = "Villareal";
        $Tim3 = "Madrid";
        $Tim4 = "ManCity";

        return view('uefa', compact('judul','Tim1','Tim2','Tim3','Tim4'));
    }
}
