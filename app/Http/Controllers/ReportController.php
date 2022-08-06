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
        $list_tahun = DB::select("SELECT * from vw_filter_tahun");

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

        $n_dept = DB::select("SELECT nama_departemen FROM tb_master_departemen WHERE id_departemen =".$dept);
        // Get nama departemen terbanyak
        if(isset($n_dept)){
            $n_dept = $n_dept[0]->nama_departemen;
        }

        if(isset($list_tahun[0])){
            $f_tahun = $list_tahun[0]->tahun;
        } else {
            $f_tahun = 0;
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

        $graf_inl = DB::select("SELECT 'Minggu - ' || minggu_ke as week, minor, major, critical FROM report_rekap_defect_inline WHERE id_user =".session()->get('id_user'));
        $graf_fnl = DB::select("SELECT 'Minggu - ' || minggu_ke as week, pass, reject FROM report_rekap_defect_final WHERE id_user =".session()->get('id_user'));
        $graf_krt = DB::select("SELECT 'Minggu - ' || minggu_ke as week, minor, major, critical FROM report_rekap_kriteria WHERE id_user =".session()->get('id_user'));

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
            'jenis_user'        => $jenis_user,
            'graf_inl'          => $graf_inl,
            'graf_fnl'          => $graf_fnl,
            'graf_krt'          => $graf_krt,
            'select_dept'       => $dept,
            'tahun'             => $tahun,
            'f_tahun'           => $f_tahun,
            'list_tahun'        => $list_tahun,
            'select_tahun'      => $f_tahun
        ]);
    }

    //Menampilkan report inspeksi
    public function ReportInspeksi(){
        $bulan = date('m', strtotime('+0 hours'));
        $tahun = date('Y', strtotime('+0 hours'));
        $departemen = DB::select('SELECT id_departemen, nama_departemen FROM vg_list_departemen');
        $dept = DB::select("SELECT id_departemen from tb_inspeksi_header group by id_departemen order by count(id_departemen) desc");
        $list_tahun = DB::select("SELECT * from vw_filter_tahun");

        if(isset($dept[0])){
            $dept = $dept[0]->id_departemen;
        } else {
            $dept = 0;
        }

        if(isset($list_tahun[0])){
            $f_tahun = $list_tahun[0]->tahun;
        } else {
            $f_tahun = 0;
        }

        $n_dept = DB::select("SELECT nama_departemen FROM tb_master_departemen WHERE id_departemen =".$dept);
        // Get nama departemen terbanyak
        if(isset($n_dept)){
            $n_dept = $n_dept[0]->nama_departemen;
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

        //Grafik
        $graf_ins = DB::select("SELECT 'Minggu - ' || minggu_ke as week, inline, final FROM report_total_inspeksi WHERE id_user =".session()->get('id_user'));

        return view('report.report-inspeksi',[
            'menu'              => 'laporan',
            'sub'               => '/report-inspeksi',
            'departemen'        => $departemen,
            'report_inspeksi'   => $report_inspeksi,
            'report_summary'    => $report_summary,
            'bulan'             => $bulan,
            'n_dept'            => $n_dept,
            'jenis_user'        => $jenis_user,
            'graf_ins'          => $graf_ins,
            'select_dept'       => $dept,
            'tahun'             => $tahun,
            'f_tahun'           => $f_tahun,
            'list_tahun'        => $list_tahun,
            'select_tahun'      => $f_tahun
        ]);
    }

    // menampilkan report temuan critical
    public function ReportCritical(){
        $bulan = date('m', strtotime('+0 hours'));
        $tahun = date('Y', strtotime('+0 hours'));
        $departemen = DB::select('SELECT id_departemen, nama_departemen FROM vg_list_departemen');
        $dept = DB::select("SELECT id_departemen from tb_inspeksi_header group by id_departemen order by count(id_departemen) desc");
        $list_tahun = DB::select("SELECT * from vw_filter_tahun");

        if(isset($dept[0])){
            $dept = $dept[0]->id_departemen;
        } else {
            $dept = 0;
        }

        if(isset($list_tahun[0])){
            $f_tahun = $list_tahun[0]->tahun;
        } else {
            $f_tahun = 0;
        }

        $n_dept = DB::select("SELECT nama_departemen FROM tb_master_departemen WHERE id_departemen =".$dept);
        // Get nama departemen terbanyak
        if(isset($n_dept)){
            $n_dept = $n_dept[0]->nama_departemen;
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

        //Grafik
        $graf_crt = DB::select("SELECT 'Minggu - ' || minggu_ke as week, qty_inspek, qty_reject, qty_defect FROM report_rekap_critical WHERE id_user =".session()->get('id_user'));

        return view('report.report-critical',[
            'menu'              => 'laporan',
            'sub'               => '/report-critical',
            'departemen'        => $departemen,
            'select_dept'       => $dept,
            'n_dept'            => $n_dept,
            'report_critical'   => $report_critical,
            'report_summary'    => $report_summary,
            'bulan'             => $bulan,
            'jenis_user'        => $jenis_user,
            'graf_crt'          => $graf_crt,
            'tahun'             => $tahun,
            'f_tahun'           => $f_tahun,
            'list_tahun'        => $list_tahun,
            'select_tahun'      => $f_tahun
        ]);
    }

    // menampilkan report temuan reject
    public function ReportReject(){
        $tahun = date('Y', strtotime('+0 hours'));
        $departemen = DB::select('SELECT id_departemen, nama_departemen FROM vg_list_departemen');
        $dept = DB::select("SELECT id_departemen from tb_inspeksi_header group by id_departemen order by count(id_departemen) desc");
        $list_tahun = DB::select("SELECT * from vw_filter_tahun");

        if(isset($dept[0])){
            $dept = $dept[0]->id_departemen;
        } else {
            $dept = 0;
        }

        $n_dept = DB::select("SELECT nama_departemen FROM tb_master_departemen WHERE id_departemen =".$dept);
        // Get nama departemen terbanyak
        if(isset($n_dept)){
            $n_dept = $n_dept[0]->nama_departemen;
        }

        if(isset($list_tahun[0])){
            $f_tahun = $list_tahun[0]->tahun;
        } else {
            $f_tahun = 0;
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

        //Grafik
        $graf_rej = DB::select("SELECT bulan, sum(qty_inspek) as qty_inspek , sum(qty_reject) as qty_reject, sum(qty_critical) as qty_critical, sum(qty_defect) as qty_defect FROM report_rekap_reject WHERE id_user =".session()->get('id_user')." GROUP BY bulan");

        return view('report.report-reject',[
            'menu'              => 'laporan',
            'sub'               => '/report-reject',
            'departemen'        => $departemen,
            'report_reject'     => $report_reject,
            'report_summary'    => $report_summary,
            'jenis_user'        => $jenis_user,
            'graf_rej'          => $graf_rej,
            'n_dept'            => $n_dept,
            'select_dept'       => $dept,
            'tahun'             => $tahun,
            'f_tahun'           => $f_tahun,
            'list_tahun'        => $list_tahun,
            'select_tahun'      => $f_tahun

        ]);
    }

    // menampilkan report qty defect
    public function ReportQtyDefect(){
        $bulan = date('m', strtotime('+0 hours'));
        $tahun = date('Y', strtotime('+0 hours'));
        $departemen = DB::select('SELECT id_departemen, nama_departemen FROM vg_list_departemen');
        $dept = DB::select("SELECT id_departemen from tb_inspeksi_header group by id_departemen order by count(id_departemen) desc");
        $list_tahun = DB::select("SELECT * from vw_filter_tahun");

        if(isset($dept[0])){
            $dept = $dept[0]->id_departemen;
        } else {
            $dept = 0;
        }

        if(isset($list_tahun[0])){
            $f_tahun = $list_tahun[0]->tahun;
        } else {
            $f_tahun = 0;
        }

        $n_dept = DB::select("SELECT nama_departemen FROM tb_master_departemen WHERE id_departemen =".$dept);
        // Get nama departemen terbanyak
        if(isset($n_dept)){
            $n_dept = $n_dept[0]->nama_departemen;
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

        $report_qty_defect_inline = DB::table('vw_rekap_defect')
                            ->where('id_user', '=', session()->get('id_user'))
                            ->where('id_departemen', '=', $dept)
                            ->where('bulan', '=', $bulan)
                            ->where('type_form', '=', 'Inline')
                            ->get();

        $report_qty_defect_final = DB::table('vw_rekap_defect')
                            ->where('id_user', '=', session()->get('id_user'))
                            ->where('id_departemen', '=', $dept)
                            ->where('bulan', '=', $bulan)
                            ->where('type_form', '=', 'Final')
                            ->get();

        $jenis_user = session()->get('jenis_user');

        return view('report.report-qty-defect',
        [
            'menu'                      => 'laporan',
            'sub'                       => '/report-qty-defect',
            'departemen'                => $departemen,
            'dept'                      => $dept,
            'report_qty_defect_inline'  => $report_qty_defect_inline,
            'report_qty_defect_final'   => $report_qty_defect_final,
            'bulan'                     => $bulan,
            'tahun'                     => $tahun,
            'jenis_user'                => $jenis_user,
            'n_dept'                    => $n_dept,
            'select_dept'               => $dept,
            'tahun'                     => $tahun,
            'f_tahun'                   => $f_tahun,
            'list_tahun'                => $list_tahun,
            'select_tahun'              => $f_tahun
        ]);
    }

    // menampilkan report historical by jop
    public function ReportJop(){
        $tahun = date('Y', strtotime('+0 hours'));

        $report_jop = DB::table('vw_rekap_defect_by_jop')
                            ->where('id_user', '=', session()->get('id_user'))
                            ->get();

        $jenis_user = session()->get('jenis_user');

        return view('report.report-historical-jop',
        [
            'menu'                      => 'laporan',
            'sub'                       => '/report-historical-jop',
            'report_jop'                => $report_jop,
            'tahun'                     => $tahun,
            'jenis_user'                => $jenis_user
        ]);
    }

    //Fungsi Filter List
    public function FilterReportDefect(Request $request){
        switch ($request->input('action')) {
            case 'submit':
                // Get value variable
                $dept = $request->id_departemen;
                // return back again list departemen
                $departemen = DB::select('SELECT id_departemen, nama_departemen FROM vg_list_departemen');
                $bulan = $request->bulan;
                $tahun = $request->tahun;
                $f_tahun = $request->tahun;
                $list_tahun = DB::select("select * from vw_filter_tahun");

                // Call Function / Stored Procedure
                $report_inl = DB::select("SELECT * FROM sp_report_defect_inline('".$bulan."', '".$f_tahun."', '".$dept."', '".session()->get('id_user')."')");
                $report_fin = DB::select("SELECT * FROM sp_report_defect_final('".$bulan."', '".$f_tahun."', '".$dept."', '".session()->get('id_user')."')");
                $report_krt = DB::select("SELECT * FROM sp_report_kriteria('".$bulan."', '".$f_tahun."', '".$dept."', '".session()->get('id_user')."')");

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

                //Grafik
                $graf_inl = DB::select("SELECT 'Minggu - ' || minggu_ke as week, minor, major, critical FROM report_rekap_defect_inline WHERE id_user =".session()->get('id_user'));
                $graf_fnl = DB::select("SELECT 'Minggu - ' || minggu_ke as week, pass, reject FROM report_rekap_defect_final WHERE id_user =".session()->get('id_user'));
                $graf_krt = DB::select("SELECT 'Minggu - ' || minggu_ke as week, minor, major, critical FROM report_rekap_kriteria WHERE id_user =".session()->get('id_user'));

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
                    'jenis_user'        => $jenis_user,
                    'graf_inl'          => $graf_inl,
                    'graf_fnl'          => $graf_fnl,
                    'graf_krt'          => $graf_krt,
                    'select_dept'       => $dept,
                    'f_tahun'           => $f_tahun,
                    'list_tahun'        => $list_tahun,
                    'select_tahun'      => $f_tahun,
                    'tahun'             => $tahun
                ]);

            break;

            case 'export_pdf':
                // Get value variable
                $id_dept = $request->id_departemen;
                // return back again list departemen
                $departemen = DB::select('SELECT id_departemen, nama_departemen FROM vg_list_departemen');
                $bulan = $request->bulan;
                $tahun = $request->tahun;

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
                    'tahun'             => $tahun,
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
            $tahun = $request->tahun;
            $f_tahun = $request->tahun;
            $list_tahun = DB::select("select * from vw_filter_tahun");

            $call_sp = DB::select("SELECT * FROM sp_report_inspeksi('".$bulan."', '".$f_tahun."', '".$dept."', '".session()->get('id_user')."')");
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

            //Grafik
            $graf_ins = DB::select("SELECT 'Minggu - ' || minggu_ke as week, inline, final FROM report_total_inspeksi WHERE id_user =".session()->get('id_user'));

            return view('report.report-inspeksi',[
                'menu'              => 'laporan',
                'sub'               => '/report-inspeksi',
                'departemen'        => $departemen,
                'report_inspeksi'   => $report_inspeksi,
                'report_summary'    => $report_summary,
                'bulan'             => $bulan,
                'jenis_user'        => $jenis_user,
                'graf_ins'          => $graf_ins,
                'select_dept'       => $dept,
                'f_tahun'           => $f_tahun,
                'list_tahun'        => $list_tahun,
                'select_tahun'      => $f_tahun,
                'tahun'             => $tahun
            ]);
            break;

            case 'export_pdf':
            // Get value variable
            $dept = $request->id_departemen;
            // return back again list departemen
            $departemen = DB::select('SELECT id_departemen, nama_departemen FROM vg_list_departemen');
            $bulan = $request->bulan;
            $tahun = $request->tahun;

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
                'jenis_user'        => $jenis_user,
                'select_dept'       => $dept
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
                $f_tahun = $request->tahun;
                $list_tahun = DB::select("select * from vw_filter_tahun");

                $call_sp = DB::select("SELECT * FROM sp_report_critical('".$bulan."', '".$f_tahun."', '".$dept."', '".session()->get('id_user')."')");
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

                //Grafik
                $graf_crt = DB::select("SELECT 'Minggu - ' || minggu_ke as week, qty_inspek, qty_reject, qty_defect FROM report_rekap_critical WHERE id_user =".session()->get('id_user'));

                return view('report.report-critical',[
                    'menu'              => 'laporan',
                    'sub'               => '/report-critical',
                    'departemen'        => $departemen,
                    'report_critical'   => $report_critical,
                    'report_summary'    => $report_summary,
                    'bulan'             => $bulan,
                    'jenis_user'        => $jenis_user,
                    'graf_crt'          => $graf_crt,
                    'select_dept'       => $dept,
                    'f_tahun'           => $f_tahun,
                    'list_tahun'        => $list_tahun,
                    'select_tahun'      => $f_tahun
                ]);
            break;

            case 'export_pdf':
            // Get value variable
            $dept = $request->id_departemen;
            // return back again list departemen
            $departemen = DB::select('SELECT id_departemen, nama_departemen FROM vg_list_departemen');
            $bulan = $request->bulan;
            $tahun = $request->tahun;

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
                'bulan'             => $bulan,
                'tahun'             => $tahun
            ]);
            return $pdf->download('laporan-critical.pdf');

            return view('report.ReportCriticalPDF',[
                'menu'              => 'laporan',
                'sub'               => '/report-critical',
                'departemen'        => $departemen,
                'report_critical'   => $report_critical,
                'report_summary'    => $report_summary,
                'bulan'             => $bulan,
                'tahun'             => $tahun,
                'jenis_user'        => $jenis_user,
                'select_dept'       => $dept,
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
            $f_tahun = $request->tahun;
            $list_tahun = DB::select("select * from vw_filter_tahun");

            $call_sp = DB::select("SELECT * FROM sp_report_reject('".$f_tahun."', '".$dept."', '".session()->get('id_user')."')");
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

            //Grafik
            $graf_rej = DB::select("SELECT bulan, sum(qty_inspek) as qty_inspek , sum(qty_reject) as qty_reject, sum(qty_critical) as qty_critical, sum(qty_defect) as qty_defect FROM report_rekap_reject WHERE id_user =".session()->get('id_user')." GROUP BY bulan");

            return view('report.report-reject',[
                'menu'              => 'laporan',
                'sub'               => '/report-reject',
                'departemen'        => $departemen,
                'report_reject'     => $report_reject,
                'report_summary'    => $report_summary,
                'jenis_user'        => $jenis_user,
                'graf_rej'          => $graf_rej,
                'select_dept'       => $dept,
                'f_tahun'           => $f_tahun,
                'list_tahun'        => $list_tahun,
                'select_tahun'      => $f_tahun
            ]);
            break;

            case 'export_pdf':
            // Get value variable
            $dept = $request->id_departemen;
            // return back again list departemen
            $departemen = DB::select('SELECT id_departemen, nama_departemen FROM vg_list_departemen');
            $tahun = $request->tahun;

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
                'bulan'             => $bulan,
                'tahun'             => $tahun,
                'jenis_user'        => $jenis_user,
                'select_dept'       => $dept,
            ]);
            break;
        }
    }

    // Fungsi filter Report qty defect
    public function FilterReportQtyDefect(Request $request){
        switch ($request->input('action')) {
            case 'submit':
                // Get value variable
                $dept = $request->id_departemen;
                // return back again list departemen
                $departemen = DB::select('SELECT id_departemen, nama_departemen FROM vg_list_departemen');
                $tahun = $request->tahun;
                $bulan  = $request->bulan;
                $departemen = DB::select('SELECT id_departemen, nama_departemen FROM vg_list_departemen');
                $f_tahun = $request->tahun;
                $list_tahun = DB::select("select * from vw_filter_tahun");

                $report_qty_defect_inline = DB::table('vw_rekap_defect')
                                        ->where('id_user', '=', session()->get('id_user'))
                                        ->where('id_departemen', '=', $dept)
                                        ->where('bulan', '=', $bulan)
                                        ->where('tahun', '=', $f_tahun)
                                        ->where('type_form', '=', 'Inline')
                                        ->get();

                $report_qty_defect_final = DB::table('vw_rekap_defect')
                                        ->where('id_user', '=', session()->get('id_user'))
                                        ->where('id_departemen', '=', $dept)
                                        ->where('bulan', '=', $bulan)
                                        ->where('tahun', '=', $f_tahun)
                                        ->where('type_form', '=', 'Final')
                                        ->get();

                $jenis_user = session()->get('jenis_user');

                return view('report.report-qty-defect',[
                    'menu'                      => 'laporan',
                    'sub'                       => '/report-qty-defect',
                    'dept'                      => $dept,
                    'departemen'                => $departemen,
                    'report_qty_defect_inline'  => $report_qty_defect_inline,
                    'report_qty_defect_final'   => $report_qty_defect_final,
                    'bulan'                     => $bulan,
                    'tahun'                     => $tahun,
                    'jenis_user'                => $jenis_user,
                    'select_dept'               => $dept,
                    'f_tahun'                   => $f_tahun,
                    'list_tahun'                => $list_tahun,
                    'select_tahun'              => $f_tahun
                ]);
            break;

            case 'export_pdf':
                // Get value variable
                $dept = $request->id_departemen;
                // return back again list departemen
                $bulan = $request->bulan;
                $departemen = DB::select('SELECT id_departemen, nama_departemen FROM vg_list_departemen');
                $tahun = $request->tahun;

                $report_qty_defect_inline = DB::table('vw_rekap_defect')
                                        ->where('id_user', '=', session()->get('id_user'))
                                        ->where('id_departemen', '=', $dept)
                                        ->where('bulan', '=', $bulan)
                                        ->where('type_form', '=', 'Inline')
                                        ->get();

                $report_qty_defect_final = DB::table('vw_rekap_defect')
                                        ->where('id_user', '=', session()->get('id_user'))
                                        ->where('id_departemen', '=', $dept)
                                        ->where('bulan', '=', $bulan)
                                        ->where('type_form', '=', 'Final')
                                        ->get();

                $jenis_user = session()->get('jenis_user');

                $pdf = PDF::loadview('report.ReportQtyDefectPDF',[
                    'report_qty_defect_inline'  => $report_qty_defect_inline,
                    'report_qty_defect_final'   => $report_qty_defect_final,
                    'tahun'                     => $tahun,
                    'bulan'                     => $bulan
                ]);
                return $pdf->download('laporan-qty-defect.pdf');

                return view('report.ReportQtyDefectPDF',[
                    'menu'                      => 'laporan',
                    'sub'                       => '/report-qty-defect',
                    'departemen'                => $departemen,
                    'report_qty_defect_inline'  => $report_qty_defect_inline,
                    'report_qty_defect_final'   => $report_qty_defect_final,
                    'bulan'                     => $bulan,
                    'tahun'                     => $tahun,
                    'jenis_user'                => $jenis_user,
                    'select_dept'               => $dept,
                ]);
            break;
        }
    }

    //Fungsi Filter Historical JOP
    public function FilterReportJop(Request $request){
            $text_search    = strtoupper($request->text_search);
            $jenis_user     = session()->get('jenis_user');

                if (isset($text_search)) {
                    $report_jop = DB::table('vw_rekap_defect_by_jop')
                        ->where('jop', 'like', "%".$text_search."%")
                        ->orWhere('item', 'like', "%".$text_search."%")
                        ->get();
                } else {
                    $report_jop = DB::table('vw_rekap_defect_by_jop')
                    ->where('id_user', '=', session()->get('id_user'))
                    ->get();
                }

            return view('report.report-historical-jop',
            [
                'report_jop'   => $report_jop,
                'menu'          => 'report',
                'text_search'    => $text_search,
                'sub'           => '/report-historical-jop',
                'jenis_user'    => $jenis_user
            ]);

    }
}
