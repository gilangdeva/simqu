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


        // $early_month       = date('Y-m-01', strtotime('+0 hours'));
        // $end_month = Carbon::createFromFormat('Y-m-d', $early_month)
        //                 ->endOfMonth()
        //                 ->format('Y-m-d');

        // $report_inline = DB::table('report_rekap_defect_inline')
        // ->where('tgl_inspeksi', '>=', $early_month)
        // ->where('tgl_inspeksi', '<=', $end_month)
        // ->get();

        $report_inl = DB::select("SELECT * FROM sp_report_defect_inline('Juni', '2022', '3', '".session()->get('id_user')."')");
        $report_inl = $report_inl[0]->sp_report_defect_inline;

        $total_inl = DB::select("SELECT sum(total) FROM report_rekap_defect_inline WHERE id_user =".session()->get('id_user'));
        $total_inl = $total_inl[0]->sum;

        $report_inline = DB::select("SELECT * FROM report_rekap_defect_inline WHERE id_user =".session()->get('id_user'));

        return view('report.report-list',[
            'menu'   => 'report',
            'sub'    => '/report',
            'report_inline' => $report_inline,
            'report_inl'    => $report_inl,
            'total_inl'     => $total_inl
        ]);
    }
}
