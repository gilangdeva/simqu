<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;

class DashboardController extends Controller
{
    public function Index(){
        $inspeksi_total = DB::select("SELECT * FROM vw_dashboard_total_inspeksi");
        $inspeksi_tahun = DB::select("SELECT sum(total) as total FROM vw_dashboard_periode_inspeksi WHERE tahun ='".date('Y', strtotime('+0 hours'))."' GROUP BY tahun");
        $inspeksi_bulan = DB::select("SELECT sum(total) as total FROM vw_dashboard_periode_inspeksi WHERE bulan ='".date('m', strtotime('+0 hours'))."' AND tahun ='".date('Y', strtotime('+0 hours'))."'");
        $inspeksi_inline = DB::select("SELECT * from vw_dashboard_status_inline");
        $inspeksi_final = DB::select("SELECT * from vw_dashboard_status_final");
        $inspeksi_ratio = DB::select("SELECT month, final, inline from vw_dashboard_graph_inline_vs_final WHERE years ='".date('Y', strtotime('+0 hours'))."'");
        $defect = DB::select("SELECT month, minor, major, critical FROM vw_dashboard_defect WHERE tahun ='".date('Y', strtotime('+0 hours'))."'");
        $jenis_user = session()->get('jenis_user');

        if(isset($inspeksi_ratio[0]->month)){ $bln = '"'.$inspeksi_ratio[0]->month.'"'; $inl = $inspeksi_ratio[0]->inline; $fin = $inspeksi_ratio[0]->final; } else { $bln = '"Jan"'; $inl = 0; $fin = 0; }
        if(isset($inspeksi_ratio[1]->month)){ $bln = $bln.', "'.$inspeksi_ratio[1]->month.'"'; $inl = $inl.", ".$inspeksi_ratio[1]->inline; $fin = $fin.", ".$inspeksi_ratio[1]->final; } else { $bln = $bln.', "Feb"'; $inl = $inl.", 0"; $fin = $fin.", 0"; }
        if(isset($inspeksi_ratio[2]->month)){ $bln = $bln.', "'.$inspeksi_ratio[2]->month.'"'; $inl = $inl.", ".$inspeksi_ratio[2]->inline; $fin = $fin.", ".$inspeksi_ratio[2]->final; } else { $bln = $bln.', "Mar"'; $inl = $inl.", 0"; $fin = $fin.", 0"; }
        if(isset($inspeksi_ratio[3]->month)){ $bln = $bln.', "'.$inspeksi_ratio[3]->month.'"'; $inl = $inl.", ".$inspeksi_ratio[3]->inline; $fin = $fin.", ".$inspeksi_ratio[3]->final; } else { $bln = $bln.', "Apr"'; $inl = $inl.", 0"; $fin = $fin.", 0"; }
        if(isset($inspeksi_ratio[4]->month)){ $bln = $bln.', "'.$inspeksi_ratio[4]->month.'"'; $inl = $inl.", ".$inspeksi_ratio[4]->inline; $fin = $fin.", ".$inspeksi_ratio[4]->final; } else { $bln = $bln.', "May"'; $inl = $inl.", 0"; $fin = $fin.", 0"; }
        if(isset($inspeksi_ratio[5]->month)){ $bln = $bln.', "'.$inspeksi_ratio[5]->month.'"'; $inl = $inl.", ".$inspeksi_ratio[5]->inline; $fin = $fin.", ".$inspeksi_ratio[5]->final; } else { $bln = $bln.', "Jun"'; $inl = $inl.", 0"; $fin = $fin.", 0"; }
        if(isset($inspeksi_ratio[6]->month)){ $bln = $bln.', "'.$inspeksi_ratio[6]->month.'"'; $inl = $inl.", ".$inspeksi_ratio[6]->inline; $fin = $fin.", ".$inspeksi_ratio[6]->final; } else { $bln = $bln.', "Jul"'; $inl = $inl.", 0"; $fin = $fin.", 0"; }
        if(isset($inspeksi_ratio[7]->month)){ $bln = $bln.', "'.$inspeksi_ratio[7]->month.'"'; $inl = $inl.", ".$inspeksi_ratio[7]->inline; $fin = $fin.", ".$inspeksi_ratio[7]->final; } else { $bln = $bln.', "Aug"'; $inl = $inl.", 0"; $fin = $fin.", 0"; }
        if(isset($inspeksi_ratio[8]->month)){ $bln = $bln.', "'.$inspeksi_ratio[8]->month.'"'; $inl = $inl.", ".$inspeksi_ratio[8]->inline; $fin = $fin.", ".$inspeksi_ratio[8]->final; } else { $bln = $bln.', "Sep"'; $inl = $inl.", 0"; $fin = $fin.", 0"; }
        if(isset($inspeksi_ratio[9]->month)){ $bln = $bln.', "'.$inspeksi_ratio[9]->month.'"'; $inl = $inl.", ".$inspeksi_ratio[9]->inline; $fin = $fin.", ".$inspeksi_ratio[9]->final; } else { $bln = $bln.', "Oct"'; $inl = $inl.", 0"; $fin = $fin.", 0"; }
        if(isset($inspeksi_ratio[10]->month)){ $bln = $bln.', "'.$inspeksi_ratio[10]->month.'"'; $inl = $inl.", ".$inspeksi_ratio[10]->inline; $fin = $fin.", ".$inspeksi_ratio[10]->final; } else { $bln = $bln.', "Nov"'; $inl = $inl.", 0"; $fin = $fin.", 0"; }
        if(isset($inspeksi_ratio[11]->month)){ $bln = $bln.', "'.$inspeksi_ratio[11]->month.'"'; $inl = $inl.", ".$inspeksi_ratio[11]->inline; $fin = $fin.", ".$inspeksi_ratio[11]->final; } else { $bln = $bln.', "Dec"'; $inl = $inl.", 0"; $fin = $fin.", 0"; }

        return view('admin.dashboard',[
            'menu'              => 'dashboard',
            'sub'               => '/dashboard',
            'inspeksi_tot'      => $inspeksi_total,
            'inspeksi_thn'      => $inspeksi_tahun,
            'inspeksi_bln'      => $inspeksi_bulan,
            'inspeksi_inline'   => $inspeksi_inline,
            'inspeksi_final'    => $inspeksi_final,
            'defect'            => $defect,
            'bulan'             => "[".$bln."]",
            'inline'            => "[".$inl."]",
            'final'             => "[".$fin."]",
            'jenis_user'        => $jenis_user
        ]);
    }
}

