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
use DateTime;

// Tambahkan source dibawah ini
use App\Models\DepartmentModel;
use App\Models\SatuanModel;
use App\Models\SubDepartmentModel;
use App\Models\MesinModel;
use App\Models\DefectModel;
use App\Models\DraftHeaderModel;
use App\Models\DraftDetailModel;
use Carbon\Carbon;
use App\Http\Controllers\DepartmentController;
use App\Http\Controllers\SubDepartmentController;
use App\Http\Controllers\MesinController;
use App\Http\Controllers\SatuanController;
class OraController extends Controller
{
    public function index() {
        $mulai = '23:51:00';
        $selesai = '23:55:00';
        $jam_mulai = new DateTime($mulai);
        $jam_selesai = new DateTime($selesai);
        $interval = round(($jam_selesai->format('U') - $jam_mulai->format('U')) / 60);
        return $interval;
    }
}
