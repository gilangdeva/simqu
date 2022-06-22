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
        $report_fnl = DB::select("SELECT * FROM sp_report_defect_final('Juni', '2022', '3', '".session()->get('id_user')."')");
        $report_krt = DB::select("SELECT * FROM sp_report_kriteria('Juni', '2022', '3', '".session()->get('id_user')."')");

        $total_inl = DB::select("SELECT sum(total) FROM report_rekap_defect_inline WHERE id_user =".session()->get('id_user'));
        $total_fnl = DB::select("SELECT sum(total) FROM report_rekap_defect_final WHERE id_user =".session()->get('id_user'));
        $total_krt = DB::select("SELECT sum(total) FROM report_rekap_kriteria WHERE id_user =".session()->get('id_user'));

        $report_inline = DB::select("SELECT * FROM report_rekap_defect_inline WHERE id_user =".session()->get('id_user'));
        $report_final = DB::select("SELECT * FROM report_rekap_defect_final WHERE id_user =".session()->get('id_user'));
        $report_kriteria = DB::select("SELECT * FROM report_rekap_kriteria WHERE id_user =".session()->get('id_user'));

        $departemen = DB::select('SELECT id_departemen, nama_departemen FROM vg_list_departemen');
        return view('report.report-list',[
            'menu'              => 'report',
            'sub'               => '/report',
            'departemen'        => $departemen,
            'report_inline'     => $report_inline,
            'report_final'      => $report_final,
            'report_kriteria'   => $report_kriteria,
            'total_inl'         => $total_inl,
            'total_fnl'         => $total_fnl,
            'total_krt'         => $total_krt
        ]);
    }


    //Fungsi Filter List
    public function FilterReportList(Request $request){

        // Get value variable
        $id_dept = $request->id_departemen;
        $bulan = $request->bulan;

        // Call Function / Stored Procedure
        $report_inl = DB::select("SELECT * FROM sp_report_defect_inline('".$bulan."', '".date('Y', strtotime('+0 hours'))."', '".$id_dept."', '".session()->get('id_user')."')");
        $report_fin = DB::select("SELECT * FROM sp_report_defect_final('".$bulan."', '".date('Y', strtotime('+0 hours'))."', '".$id_dept."', '".session()->get('id_user')."')");
        $report_krt = DB::select("SELECT * FROM sp_report_kriteria('".$bulan."', '".date('Y', strtotime('+0 hours'))."', '".$id_dept."', '".session()->get('id_user')."')");

        //Get value total
        $total_inl = DB::select("SELECT sum(total) as total_inline FROM report_rekap_defect_inline WHERE id_user =".session()->get('id_user'));
        $total_fnl = DB::select("SELECT sum(total)as total_final FROM report_rekap_defect_final WHERE id_user =".session()->get('id_user'));
        $total_krt = DB::select("SELECT sum(total)as total_temuan FROM report_rekap_kriteria WHERE id_user =".session()->get('id_user'));

        $total_inl = $total_inl[0]->total_inline;
        $total_fnl = $total_fnl[0]->total_final;
        $total_krt = $total_krt[0]->total_temuan;


        // select data from table report
        $report_inline = DB::select("SELECT * FROM report_rekap_defect_inline WHERE id_user =".session()->get('id_user'));
        $report_final = DB::select("SELECT * FROM report_rekap_defect_final WHERE id_user =".session()->get('id_user'));
        $report_kriteria = DB::select("SELECT * FROM report_rekap_kriteria WHERE id_user =".session()->get('id_user'));

        // Check total
        // if(isset($total_inl)){
        //     $total_inl = $total_inl;
        // } else {
        //     $total_inl = 0;
        // }

        // if(isset($total_fnl)){
        //     $total_fnl = $total_fnl;
        // } else {
        //     $total_fnl = 0;
        // }

        // return back again list departemen
        $departemen = DB::select('SELECT id_departemen, nama_departemen FROM vg_list_departemen');
        return view('report.report-list',[
            'menu'              => 'report',
            'sub'               => '/report',
            'departemen'        => $departemen,
            'report_inline'     => $report_inline,
            'report_final'      => $report_final,
            'report_kriteria'   => $report_kriteria,
            'total_inl'         => $total_inl,
            'total_fnl'         => $total_fnl,
            'total_krt'         => $total_krt
        ]);

        // if ( || request()->bulan) {
        //     $id_departemen    = $request->id_departemen;
        //     $bulan              = $request->bulan;
        //     $departemen = DB::select('SELECT id_departemen, nama_departemen FROM vg_list_departemen');

        //         if ("id_departemen" == $request->id_departemen) {
        //             $report_inl = DB::select("SELECT * FROM sp_report_defect_inline('".$bulan."', '".date('Y', strtotime('+0 hours'))."', '".$id_departemen."', '".session()->get('id_user')."')");
        //             $report_inline = DB::table('report_rekap_defect_inline')
        //                 ->where('id_departemen', '=', $id_departemen)
        //                 ->get();
        //         } else if ("bulan" == $bulan){
        //             $report_inline = DB::table('report_rekap_defect_inline')
        //                 ->where('bulan', '=', $bulan)
        //                 ->get();
        //         } else if ("id_departemen" == $id_departemen && "bulan" == $bulan){
        //             $report_inline = DB::table('report_rekap_defect_inline')
        //                 ->where('id_departemen', '=', $id_departemen)
        //                 ->where('bulan', '=', $bulan)
        //                 ->get();
        //         } else {
        //             $report_inline = DB::table('report_rekap_defect_inline')
        //             ->get();
        //         }

        //     return view('report.report-list',
        //     [
        //         'report_inline' => $report_inline,
        //         'departemen'    => $departemen,
        //         'menu'          => 'report',
        //         'sub'           => '/report'
        //     ]);
        // } else {
        //     $departemen = DB::select('SELECT id_departemen, nama_departemen FROM vg_list_departemen');
        //     $report_inline = DB::select("SELECT * FROM report_rekap_defect_inline");
        //     return view('report.report-list',
        //     [
        //         'report_inline' => $report_inline,
        //         'departemen'    => $departemen,
        //         'menu'          => 'report',
        //         'sub'           => '/report'
        //     ]);
        // }

    }
}
