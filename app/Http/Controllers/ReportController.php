<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

// Tambahkan source dibawah ini
use Illuminate\Support\Facades\DB;
use App\Models\DepartmentModel;
use App\Models\SubDepartmentModel;
use App\Models\MesinModel;
use App\Models\DefectModel;
use App\Models\DraftHeaderModel;
use App\Models\DraftDetailModel;

use Carbon\Carbon;
use Image;
use File;
use Crypt;
use Redirect;
use DateTime;
use RealRashid\SweetAlert\Facades\Alert;

class ReportController extends Controller
{
    // Menampilkan list report
    public function ReportList(){
        // Get all data from database
        $report = DB::select("SELECT * FROM vg_list_report");

        return view('report.report-list',[
            'menu'   => 'report',
            'sub'    => '/report',
            'report' => $report
        ]);
    }
}
