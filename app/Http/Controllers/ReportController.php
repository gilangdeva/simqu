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
use PDF;

use RealRashid\SweetAlert\Facades\Alert;

class ReportController extends Controller
{
    // Menampilkan list report
    public function ReportDefect(){
        $bulan = date('m', strtotime('+0 hours'));
        $tahun = date('Y', strtotime('+0 hours'));
        $departemen = DB::select('SELECT id_departemen, nama_departemen FROM vg_list_departemen');
        $dept = DB::select("SELECT id_departemen from tb_inspeksi_header group by id_departemen order by count(id_departemen) desc");

        if(isset($dept[0])){
            $dept = $dept[0]->id_departemen;
        } else {
            $dept = 0;
        }

        if ($bulan == '01') {
            $bulan = 'Januari';
        } else if ($bulan == '02'){
            $bulan = 'Februari';
        } else if ($bulan == '03'){
            $bulan = 'Maret';
        } else if ($bulan == '04'){
            $bulan = 'April';
        } else if ($bulan == '05'){
            $bulan = 'Mei';
        } else if ($bulan == '06'){
            $bulan = 'Juni';
        } else if ($bulan == '07'){
            $bulan = 'Juli';
        } else if ($bulan == '08'){
            $bulan = 'Agustus';
        } else if ($bulan == '09'){
            $bulan = 'September';
        } else if ($bulan == '10'){
            $bulan = 'Oktober';
        } else if ($bulan == '11'){
            $bulan = 'November';
        } else if ($bulan == '12'){
            $bulan = 'Desember';
        }

        $report_inl = DB::select("SELECT * FROM sp_report_defect_inline('".$bulan."', '".$tahun."', '".$dept."', '".session()->get('id_user')."')");
        $report_fnl = DB::select("SELECT * FROM sp_report_defect_final('".$bulan."', '".$tahun."', '".$dept."', '".session()->get('id_user')."')");
        $report_krt = DB::select("SELECT * FROM sp_report_kriteria('".$bulan."', '".$tahun."', '".$dept."', '".session()->get('id_user')."')");

        $total_inl = DB::select("SELECT sum(total) as total_inl FROM report_rekap_defect_inline WHERE id_user =".session()->get('id_user'));
        $total_fnl = DB::select("SELECT sum(total) as total_fnl FROM report_rekap_defect_final WHERE id_user =".session()->get('id_user'));
        $total_krt = DB::select("SELECT sum(total) as total_krt FROM report_rekap_kriteria WHERE id_user =".session()->get('id_user'));

        $report_inline = DB::select("SELECT * FROM report_rekap_defect_inline WHERE id_user =".session()->get('id_user'));
        $report_final = DB::select("SELECT * FROM report_rekap_defect_final WHERE id_user =".session()->get('id_user'));
        $report_kriteria = DB::select("SELECT * FROM report_rekap_kriteria WHERE id_user =".session()->get('id_user'));

        if(isset($total_inl)){
            $total_inl = $total_inl[0]->total_inl;
        }

        if(isset($total_fnl)){
            $total_fnl = $total_fnl[0]->total_fnl;
        }

        if(isset($total_krt)){
            $total_krt = $total_krt[0]->total_krt;
        }

        $jenis_user = session()->get('jenis_user');

        return view('report.report-list',[
            'menu'              => 'laporan',
            'sub'               => '/report-defect',
            'departemen'        => $departemen,
            'report_inline'     => $report_inline,
            'report_final'      => $report_final,
            'report_kriteria'   => $report_kriteria,
            'total_inl'         => $total_inl,
            'total_fnl'         => $total_fnl,
            'total_krt'         => $total_krt,
            'bulan'             => $bulan,
            'jenis_user'        => $jenis_user
        ]);
    }

    //Menampilkan report inspeksi
    public function ReportInspeksi(){
        $bulan = date('m', strtotime('+0 hours'));
        $tahun = date('Y', strtotime('+0 hours'));
        $departemen = DB::select('SELECT id_departemen, nama_departemen FROM vg_list_departemen');
        $dept = DB::select("SELECT id_departemen from tb_inspeksi_header group by id_departemen order by count(id_departemen) desc");

        if(isset($dept[0])){
            $dept = $dept[0]->id_departemen;
        } else {
            $dept = 0;
        }

        if ($bulan == '01') {
            $bulan = 'Januari';
        } else if ($bulan == '02'){
            $bulan = 'Februari';
        } else if ($bulan == '03'){
            $bulan = 'Maret';
        } else if ($bulan == '04'){
            $bulan = 'April';
        } else if ($bulan == '05'){
            $bulan = 'Mei';
        } else if ($bulan == '06'){
            $bulan = 'Juni';
        } else if ($bulan == '07'){
            $bulan = 'Juli';
        } else if ($bulan == '08'){
            $bulan = 'Agustus';
        } else if ($bulan == '09'){
            $bulan = 'September';
        } else if ($bulan == '10'){
            $bulan = 'Oktober';
        } else if ($bulan == '11'){
            $bulan = 'November';
        } else if ($bulan == '12'){
            $bulan = 'Desember';
        }

        $call_sp = DB::select("SELECT * FROM sp_report_inspeksi('".$bulan."', '".$tahun."', '".$dept."', '".session()->get('id_user')."')");
        $report_inspeksi = DB::table('report_total_inspeksi')
                            ->where('id_user', '=', session()->get('id_user'))
                            ->get();

        $report_summary = DB::table('report_total_inspeksi')
                            ->select('id_departemen',
                                     'nama_departemen',
                                     DB::raw('sum(inline) as inline'),
                                     DB::raw('sum(inline)/sum(inline+final)*100 as persen_inline'),
                                     DB::raw('sum(final) as final'),
                                     DB::raw('sum(final)/sum(inline+final)*100 as persen_final'))
                            ->where('id_user', '=', session()->get('id_user'))->where('id_departemen', '=', $dept)
                            ->groupBy('id_departemen','nama_departemen')
                            ->get();

        $jenis_user = session()->get('jenis_user');

        return view('report.report-inspeksi',[
            'menu'              => 'laporan',
            'sub'               => '/report-inspeksi',
            'departemen'        => $departemen,
            'report_inspeksi'   => $report_inspeksi,
            'report_summary'    => $report_summary,
            'bulan'             => $bulan,
            'jenis_user'        => $jenis_user
        ]);
    }

    // menampilkan report temuan critical
    public function ReportCritical(){
        $bulan = date('m', strtotime('+0 hours'));
        $tahun = date('Y', strtotime('+0 hours'));
        $departemen = DB::select('SELECT id_departemen, nama_departemen FROM vg_list_departemen');
        $dept = DB::select("SELECT id_departemen from tb_inspeksi_header group by id_departemen order by count(id_departemen) desc");

        if(isset($dept[0])){
            $dept = $dept[0]->id_departemen;
        } else {
            $dept = 0;
        }

        if ($bulan == '01') {
            $bulan = 'Januari';
        } else if ($bulan == '02'){
            $bulan = 'Februari';
        } else if ($bulan == '03'){
            $bulan = 'Maret';
        } else if ($bulan == '04'){
            $bulan = 'April';
        } else if ($bulan == '05'){
            $bulan = 'Mei';
        } else if ($bulan == '06'){
            $bulan = 'Juni';
        } else if ($bulan == '07'){
            $bulan = 'Juli';
        } else if ($bulan == '08'){
            $bulan = 'Agustus';
        } else if ($bulan == '09'){
            $bulan = 'September';
        } else if ($bulan == '10'){
            $bulan = 'Oktober';
        } else if ($bulan == '11'){
            $bulan = 'November';
        } else if ($bulan == '12'){
            $bulan = 'Desember';
        }

        $call_sp = DB::select("SELECT * FROM sp_report_critical('".$bulan."', '".$tahun."', '".$dept."', '".session()->get('id_user')."')");
        $report_critical = DB::table('report_rekap_critical')
                            ->where('id_user', '=', session()->get('id_user'))
                            ->get();

        $report_summary = DB::table('report_rekap_critical')
                            ->select('id_departemen',
                                     'nama_departemen',
                                     DB::raw('sum(qty_inspek) as qty_inspek'),
                                     DB::raw('sum(qty_reject) as qty_reject'),
                                     DB::raw('sum(qty_critical) as qty_critical'),
                                     DB::raw('sum(qty_defect) as qty_defect'))
                            ->where('id_user', '=', session()->get('id_user'))->where('id_departemen', '=', $dept)
                            ->groupBy('id_departemen','nama_departemen')
                            ->get();

        $jenis_user = session()->get('jenis_user');

        return view('report.report-critical',[
            'menu'              => 'laporan',
            'sub'               => '/report-critical',
            'departemen'        => $departemen,
            'report_critical'   => $report_critical,
            'report_summary'    => $report_summary,
            'bulan'             => $bulan,
            'jenis_user'        => $jenis_user
        ]);
    }


    // menampilkan report temuan reject
    public function ReportReject(){
        $tahun = date('Y', strtotime('+0 hours'));
        $departemen = DB::select('SELECT id_departemen, nama_departemen FROM vg_list_departemen');
        $dept = DB::select("SELECT id_departemen from tb_inspeksi_header group by id_departemen order by count(id_departemen) desc");

        if(isset($dept[0])){
            $dept = $dept[0]->id_departemen;
        } else {
            $dept = 0;
        }

        $call_sp = DB::select("SELECT * FROM sp_report_reject('".$tahun."', '".$dept."', '".session()->get('id_user')."')");
        $report_reject = DB::table('report_rekap_reject')
                            ->where('id_user', '=', session()->get('id_user'))
                            ->get();

        $report_summary = DB::table('report_rekap_reject')
                            ->select('id_departemen',
                                     'nama_departemen',
                                     DB::raw('sum(qty_inspek) as qty_inspek'),
                                     DB::raw('sum(qty_reject) as qty_reject'),
                                     DB::raw('sum(qty_critical) as qty_critical'),
                                     DB::raw('sum(qty_defect) as qty_defect'))
                            ->where('id_user', '=', session()->get('id_user'))->where('id_departemen', '=', $dept)
                            ->groupBy('id_departemen','nama_departemen')
                            ->get();

        $jenis_user = session()->get('jenis_user');

        return view('report.report-reject',[
            'menu'              => 'laporan',
            'sub'               => '/report-reject',
            'departemen'        => $departemen,
            'report_reject'     => $report_reject,
            'report_summary'    => $report_summary,
            'tahun'             => $tahun,
            'jenis_user'        => $jenis_user
        ]);
    }

    //Fungsi Filter List
    public function FilterReportDefect(Request $request){
        switch ($request->input('action')) {
            case 'submit':
            // Get value variable
            $id_dept = $request->id_departemen;
            // return back again list departemen
            $departemen = DB::select('SELECT id_departemen, nama_departemen FROM vg_list_departemen');
            $bulan = $request->bulan;
            $tahun = date('Y', strtotime('+0 hours'));

            // Call Function / Stored Procedure
            $report_inl = DB::select("SELECT * FROM sp_report_defect_inline('".$bulan."', '".$tahun."', '".$id_dept."', '".session()->get('id_user')."')");
            $report_fin = DB::select("SELECT * FROM sp_report_defect_final('".$bulan."', '".$tahun."', '".$id_dept."', '".session()->get('id_user')."')");
            $report_krt = DB::select("SELECT * FROM sp_report_kriteria('".$bulan."', '".$tahun."', '".$id_dept."', '".session()->get('id_user')."')");

            //Get value total
            $total_inl = DB::select("SELECT sum(total) as total_inline FROM report_rekap_defect_inline WHERE id_user =".session()->get('id_user'));
            $total_fnl = DB::select("SELECT sum(total) as total_final FROM report_rekap_defect_final WHERE id_user =".session()->get('id_user'));
            $total_krt = DB::select("SELECT sum(total) as total_temuan FROM report_rekap_kriteria WHERE id_user =".session()->get('id_user'));

            $total_inl = $total_inl[0]->total_inline;
            $total_fnl = $total_fnl[0]->total_final;
            $total_krt = $total_krt[0]->total_temuan;


            // select data from table report
            $report_inline = DB::select("SELECT * FROM report_rekap_defect_inline WHERE id_user =".session()->get('id_user'));
            $report_final = DB::select("SELECT * FROM report_rekap_defect_final WHERE id_user =".session()->get('id_user'));
            $report_kriteria = DB::select("SELECT * FROM report_rekap_kriteria WHERE id_user =".session()->get('id_user'));

            $jenis_user = session()->get('jenis_user');

            return view('report.report-list',[
                'menu'              => 'laporan',
                'sub'               => '/report-defect',
                'departemen'        => $departemen,
                'report_inline'     => $report_inline,
                'report_final'      => $report_final,
                'report_kriteria'   => $report_kriteria,
                'total_inl'         => $total_inl,
                'total_fnl'         => $total_fnl,
                'total_krt'         => $total_krt,
                'bulan'             => $bulan,
                'jenis_user'        => $jenis_user
            ]);
            break;

            case 'export_pdf':
            // Get value variable
            $id_dept = $request->id_departemen;
            // return back again list departemen
            $departemen = DB::select('SELECT id_departemen, nama_departemen FROM vg_list_departemen');
            $bulan = $request->bulan;
            $tahun = date('Y', strtotime('+0 hours'));

            // Call Function / Stored Procedure
            $report_inl = DB::select("SELECT * FROM sp_report_defect_inline('".$bulan."', '".$tahun."', '".$id_dept."', '".session()->get('id_user')."')");
            $report_fin = DB::select("SELECT * FROM sp_report_defect_final('".$bulan."', '".$tahun."', '".$id_dept."', '".session()->get('id_user')."')");
            $report_krt = DB::select("SELECT * FROM sp_report_kriteria('".$bulan."', '".$tahun."', '".$id_dept."', '".session()->get('id_user')."')");

            //Get value total
            $total_inl = DB::select("SELECT sum(total) as total_inline FROM report_rekap_defect_inline WHERE id_user =".session()->get('id_user'));
            $total_fnl = DB::select("SELECT sum(total) as total_final FROM report_rekap_defect_final WHERE id_user =".session()->get('id_user'));
            $total_krt = DB::select("SELECT sum(total) as total_temuan FROM report_rekap_kriteria WHERE id_user =".session()->get('id_user'));

            $total_inl = $total_inl[0]->total_inline;
            $total_fnl = $total_fnl[0]->total_final;
            $total_krt = $total_krt[0]->total_temuan;


            // select data from table report
            $report_inline = DB::select("SELECT * FROM report_rekap_defect_inline WHERE id_user =".session()->get('id_user'));
            $report_final = DB::select("SELECT * FROM report_rekap_defect_final WHERE id_user =".session()->get('id_user'));
            $report_kriteria = DB::select("SELECT * FROM report_rekap_kriteria WHERE id_user =".session()->get('id_user'));

            $jenis_user = session()->get('jenis_user');

            $pdf = PDF::loadview('report.ReportDefectPDF',[
                'report_inl'        => $report_inl,
                'report_fin'        => $report_fin,
                'report_krt'        => $report_krt,
                'total_inl'         => $total_inl,
                'total_fnl'         => $total_fnl,
                'total_krt'         => $total_krt,
                'report_inline'     => $report_inline,
                'report_final'      => $report_final,
                'report_kriteria'   => $report_kriteria,
                'bulan'             => $bulan,
                'tahun'             => $tahun
            ]);
            return $pdf->download('laporan-defect.pdf');

            return view('report.report-list',[
                'menu'              => 'laporan',
                'sub'               => '/report-defect',
                'departemen'        => $departemen,
                'report_inline'     => $report_inline,
                'report_final'      => $report_final,
                'report_kriteria'   => $report_kriteria,
                'total_inl'         => $total_inl,
                'total_fnl'         => $total_fnl,
                'total_krt'         => $total_krt,
                'bulan'             => $bulan,
                'jenis_user'        => $jenis_user
            ]);
            break;
        }

    }

    // Filter Report Inspeksi
    public function FilterReportInspeksi(Request $request){
        switch ($request->input('action')) {
            case 'submit':
            // Get value variable
            $dept = $request->id_departemen;
            // return back again list departemen
            $departemen = DB::select('SELECT id_departemen, nama_departemen FROM vg_list_departemen');
            $bulan = $request->bulan;
            $tahun = date('Y', strtotime('+0 hours'));

            $call_sp = DB::select("SELECT * FROM sp_report_inspeksi('".$bulan."', '".$tahun."', '".$dept."', '".session()->get('id_user')."')");
            $report_inspeksi = DB::table('report_total_inspeksi')
                                ->where('id_user', '=', session()->get('id_user'))
                                ->get();

            $report_summary = DB::table('report_total_inspeksi')
                                ->select('id_departemen',
                                        'nama_departemen',
                                        DB::raw('sum(inline) as inline'),
                                        DB::raw('sum(inline)/sum(inline+final) as persen_inline'),
                                        DB::raw('sum(final) as final'),
                                        DB::raw('sum(final)/sum(inline+final) as persen_final'))
                                ->where('id_user', '=', session()->get('id_user'))->where('id_departemen', '=', $dept)
                                ->groupBy('id_departemen','nama_departemen')
                                ->get();

            $jenis_user = session()->get('jenis_user');

            return view('report.report-inspeksi',[
                'menu'              => 'laporan',
                'sub'               => '/report-inspeksi',
                'departemen'        => $departemen,
                'report_inspeksi'   => $report_inspeksi,
                'report_summary'    => $report_summary,
                'bulan'             => $bulan,
                'jenis_user'        => $jenis_user
            ]);
            break;

            case 'export_pdf':
            // Get value variable
            $dept = $request->id_departemen;
            // return back again list departemen
            $departemen = DB::select('SELECT id_departemen, nama_departemen FROM vg_list_departemen');
            $bulan = $request->bulan;
            $tahun = date('Y', strtotime('+0 hours'));

            $call_sp = DB::select("SELECT * FROM sp_report_inspeksi('".$bulan."', '".$tahun."', '".$dept."', '".session()->get('id_user')."')");
            $report_inspeksi = DB::table('report_total_inspeksi')
                                ->where('id_user', '=', session()->get('id_user'))
                                ->get();

            $report_summary = DB::table('report_total_inspeksi')
                                ->select('id_departemen',
                                        'nama_departemen',
                                        DB::raw('sum(inline) as inline'),
                                        DB::raw('sum(inline)/sum(inline+final) as persen_inline'),
                                        DB::raw('sum(final) as final'),
                                        DB::raw('sum(final)/sum(inline+final) as persen_final'))
                                ->where('id_user', '=', session()->get('id_user'))->where('id_departemen', '=', $dept)
                                ->groupBy('id_departemen','nama_departemen')
                                ->get();

            $jenis_user = session()->get('jenis_user');

            $pdf = PDF::loadview('report.ReportInspeksiPDF',[
                'report_summary'    => $report_summary,
                'report_inspeksi'   => $report_inspeksi,
                'bulan'             => $bulan
            ]);
            return $pdf->download('laporan-inspeksi.pdf');

            return view('report.ReportinspeksiPDF',[
                'menu'              => 'laporan',
                'sub'               => '/report-inspeksi',
                'departemen'        => $departemen,
                'report_inspeksi'   => $report_inspeksi,
                'report_summary'    => $report_summary,
                'bulan'             => $bulan,
                'jenis_user'        => $jenis_user
            ]);
            break;
        }
    }


    // Fungsi filter Report temuan critical
    public function FilterReportCritical(Request $request){
        switch ($request->input('action')) {
            case 'submit':
            // Get value variable
            $dept = $request->id_departemen;
            // return back again list departemen
            $departemen = DB::select('SELECT id_departemen, nama_departemen FROM vg_list_departemen');
            $bulan = $request->bulan;
            $tahun = date('Y', strtotime('+0 hours'));

            $call_sp = DB::select("SELECT * FROM sp_report_critical('".$bulan."', '".$tahun."', '".$dept."', '".session()->get('id_user')."')");
            $report_critical = DB::table('report_rekap_critical')
                                ->where('id_user', '=', session()->get('id_user'))
                                ->get();

            $report_summary = DB::table('report_rekap_critical')
                                ->select('id_departemen',
                                         'nama_departemen',
                                         DB::raw('sum(qty_inspek) as qty_inspek'),
                                         DB::raw('sum(qty_reject) as qty_reject'),
                                         DB::raw('sum(qty_critical) as qty_critical'),
                                         DB::raw('sum(qty_defect) as qty_defect'))
                                ->where('id_user', '=', session()->get('id_user'))->where('id_departemen', '=', $dept)
                                ->groupBy('id_departemen','nama_departemen')
                                ->get();

            $jenis_user = session()->get('jenis_user');

            return view('report.report-critical',[
                'menu'              => 'laporan',
                'sub'               => '/report-critical',
                'departemen'        => $departemen,
                'report_critical'   => $report_critical,
                'report_summary'    => $report_summary,
                'bulan'             => $bulan,
                'jenis_user'        => $jenis_user
            ]);
            break;

            case 'export_pdf':
            // Get value variable
            $dept = $request->id_departemen;
            // return back again list departemen
            $departemen = DB::select('SELECT id_departemen, nama_departemen FROM vg_list_departemen');
            $bulan = $request->bulan;
            $tahun = date('Y', strtotime('+0 hours'));

            $call_sp = DB::select("SELECT * FROM sp_report_critical('".$bulan."', '".$tahun."', '".$dept."', '".session()->get('id_user')."')");
            $report_critical = DB::table('report_rekap_critical')
                                ->where('id_user', '=', session()->get('id_user'))
                                ->get();

            $report_summary = DB::table('report_rekap_critical')
                                ->select('id_departemen',
                                            'nama_departemen',
                                            DB::raw('sum(qty_inspek) as qty_inspek'),
                                            DB::raw('sum(qty_reject) as qty_reject'),
                                            DB::raw('sum(qty_critical) as qty_critical'),
                                            DB::raw('sum(qty_defect) as qty_defect'))
                                ->where('id_user', '=', session()->get('id_user'))
                                ->groupBy('id_departemen','nama_departemen')
                                ->get();

            $jenis_user = session()->get('jenis_user');


            $pdf = PDF::loadview('report.ReportCriticalPDF',[
                'report_summary'    => $report_summary,
                'report_critical'   => $report_critical,
                'bulan'             => $bulan
            ]);
            return $pdf->download('laporan-critical.pdf');

            return view('report.ReportCriticalPDF',[
                'menu'              => 'laporan',
                'sub'               => '/report-critical',
                'departemen'        => $departemen,
                'report_critical'   => $report_critical,
                'report_summary'    => $report_summary,
                'bulan'             => $bulan,
                'jenis_user'        => $jenis_user
            ]);
            break;
        }
    }

    // Fungsi filter Report rekap reject
    public function FilterReportReject(Request $request){
        switch ($request->input('action')) {
            case 'submit':
            // Get value variable
            $dept = $request->id_departemen;
            // return back again list departemen
            $departemen = DB::select('SELECT id_departemen, nama_departemen FROM vg_list_departemen');
            $tahun = date('Y', strtotime('+0 hours'));

            $call_sp = DB::select("SELECT * FROM sp_report_reject('".$tahun."', '".$dept."', '".session()->get('id_user')."')");
            $report_reject = DB::table('report_rekap_reject')
                                ->where('id_user', '=', session()->get('id_user'))
                                ->get();

            $report_summary = DB::table('report_rekap_reject')
                                ->select('id_departemen',
                                        'nama_departemen',
                                        DB::raw('sum(qty_inspek) as qty_inspek'),
                                        DB::raw('sum(qty_reject) as qty_reject'),
                                        DB::raw('sum(qty_critical) as qty_critical'),
                                        DB::raw('sum(qty_defect) as qty_defect'))
                                ->where('id_user', '=', session()->get('id_user'))->where('id_departemen', '=', $dept)
                                ->groupBy('id_departemen','nama_departemen')
                                ->get();

            $jenis_user = session()->get('jenis_user');

            return view('report.report-reject',[
                'menu'              => 'laporan',
                'sub'               => '/report-reject',
                'departemen'        => $departemen,
                'report_reject'     => $report_reject,
                'report_summary'    => $report_summary,
                'tahun'             => $tahun,
                'jenis_user'        => $jenis_user
            ]);
            break;

            case 'export_pdf':
            // Get value variable
            $dept = $request->id_departemen;
            // return back again list departemen
            $departemen = DB::select('SELECT id_departemen, nama_departemen FROM vg_list_departemen');
            $tahun = date('Y', strtotime('+0 hours'));

            $call_sp = DB::select("SELECT * FROM sp_report_reject('".$tahun."', '".$dept."', '".session()->get('id_user')."')");
            $report_reject = DB::table('report_rekap_reject')
                                ->where('id_user', '=', session()->get('id_user'))
                                ->get();

            $report_summary = DB::table('report_rekap_reject')
                                ->select('id_departemen',
                                        'nama_departemen',
                                        DB::raw('sum(qty_inspek) as qty_inspek'),
                                        DB::raw('sum(qty_reject) as qty_reject'),
                                        DB::raw('sum(qty_critical) as qty_critical'),
                                        DB::raw('sum(qty_defect) as qty_defect'))
                                ->where('id_user', '=', session()->get('id_user'))->where('id_departemen', '=', $dept)
                                ->groupBy('id_departemen','nama_departemen')
                                ->get();

            $jenis_user = session()->get('jenis_user');

            $pdf = PDF::loadview('report.ReportRejectPDF',[
                'report_summary'    => $report_summary,
                'report_reject'     => $report_reject,
                'tahun'             => $tahun
            ]);
            return $pdf->download('laporan-reject.pdf');

            return view('report.report-reject',[
                'menu'              => 'laporan',
                'sub'               => '/report-reject',
                'departemen'        => $departemen,
                'report_reject'     => $report_reject,
                'report_summary'    => $report_summary,
                'tahun'             => $tahun,
                'jenis_user'        => $jenis_user
            ]);
            break;
        }
    }
}
