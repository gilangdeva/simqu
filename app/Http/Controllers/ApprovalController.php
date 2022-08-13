<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

// Tambahkan source dibawah ini
use Illuminate\Support\Facades\DB;
use App\Models\DepartmentModel;
use App\Models\SatuanModel;
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

class ApprovalController extends Controller
{
    // Menampilkan list inspeksi inline
    public function ApprovalList(){
        $jenis_user = session()->get('jenis_user');

        if($jenis_user <> "Manager"){
            alert()->warning('GAGAL!', 'Anda Tidak Memiliki Akses!');
            return Redirect('/');
        }

        $list_approval_inline   = DB::table('vw_list_approval_inline')
        ->get();

        $list_approval_final    = DB::table('vw_list_approval_final')
        ->get();



        return view('inspeksi.approval-list',
        [
            'list_approval_inline'  => $list_approval_inline,
            'list_approval_final'   => $list_approval_final,
            'menu'                  => 'inspeksi',
            'sub'                   => '/approval',
            'jenis_user'            => $jenis_user
        ]);
    }

    //Fungsi Filter Historical JOP
    public function FilterApproval(Request $request){
        $text_search    = strtoupper($request->text_search);
        $jenis_user     = session()->get('jenis_user');

        if (isset($text_search)) {
            $list_approval_inline = DB::table('vw_list_approval_inline')
                ->where('jop', 'like', "%".$text_search."%")
                ->orWhere('item', 'like', "%".$text_search."%")
                ->orWhere('submitted_by', 'like', "%".$text_search."%")
                ->get();

            $list_approval_final = DB::table('vw_list_approval_final')
                ->where('jop', 'like', "%".$text_search."%")
                ->orWhere('item', 'like', "%".$text_search."%")
                ->orWhere('submitted_by', 'like', "%".$text_search."%")
                ->get();
        } else {
            $list_approval_inline   = DB::table('vw_list_approval_inline')
            ->get();

            $list_approval_final    = DB::table('vw_list_approval_final')
            ->get();
        }

        return view('inspeksi.approval-list',
        [
            'list_approval_inline'  => $list_approval_inline,
            'list_approval_final'  => $list_approval_final,
            'menu'                  => 'inspeksi',
            'text_search'           => $text_search,
            'sub'                   => '/approval',
            'jenis_user'            => $jenis_user
        ]);
    }
}
