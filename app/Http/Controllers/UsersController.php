<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

// Tambahkan source dibawah ini
use Illuminate\Support\Facades\DB;
use App\Models\UsersModel;
use App\Models\DepartmentController;
use App\Models\SubDepartmentController;
use Carbon\Carbon;
use Image;
use File;
use Crypt;
use Redirect;
use RealRashid\SweetAlert\Facades\Alert;

class UsersController extends Controller
{
    public $path;
    public $dimensions;

    public function __construct(){
        //specify path destination
        $this->path = public_path('/images/users');
        //define dimention of photo
        $this->dimensions = ['500'];
        // $this->dimensions = ['245', '300', '500'];
    }

    // Menampilkan list user
    public function UsersList(){
        // Get all data from database
        $users = DB::select('SELECT * FROM vw_list_users');
        $jenis_user = session()->get('jenis_user');

        return view('admin.master.users-list',[
            'menu'          => 'master',
            'sub'           => '/users',
            'users'         => $users,
            'jenis_user'    => $jenis_user
        ]);
    }

    public function getSubDepartemen($id){
        $sub_departemen = DB::select("SELECT id_sub_departemen, nama_sub_departemen FROM tb_master_sub_departemen WHERE id_departemen = ".$id);
        return json_encode($sub_departemen);
    }

    // Redirect ke window input users
    public function UsersInput(){
        $departemen = DB::select('SELECT id_departemen, nama_departemen FROM vg_list_departemen');
        $subdepartemen = DB::select('SELECT id_sub_departemen, nama_sub_departemen FROM vg_list_sub_departemen');
        $jenis_user = session()->get('jenis_user');

        return view('admin.master.users-input',[
            'departemen'        => $departemen,
            'subdepartemen'     => $subdepartemen,
            'menu'              => 'master', // selalu ada di tiap function dan disesuaikan
            'sub'               => '/users', // selalu ada di tiap function dan disesuaikan
            'jenis_user'        => $jenis_user
        ]);
    }

    //Simpan data user
    public function SaveUserData(Request $request){
        $users = new UsersModel();

        // Parameters
        $users->kode_user = strtoupper($request->kode_user);
        $users->nama_user = strtoupper($request->nama_user);
        $encrypt_password = md5(strtoupper($request->kode_user));
        $users->password = hash('ripemd160', $encrypt_password);
        $users->email = $request->email;
        $users->jenis_user = $request->jenis_user; //nanti diubah
        $users->id_departemen = $request->id_departemen; //nanti diubah
        $users->id_sub_departemen = $request->id_sub_departemen; //nanti diubah
        $users->creator = session()->get('user_id');
        $users->pic = session()->get('user_id');

        // Check duplicate email
        $email_check = DB::select("SELECT email FROM vw_list_users WHERE email = '".$request->email."'");
        if (isset($email_check['0'])) {
            alert()->error('Gagal Menyimpan!', 'Maaf, Email Ini Sudah Didaftarkan Dalam Sistem!');
            return Redirect::back();
        }

        // Check duplicate username
        $usersname_check = DB::select("SELECT kode_user FROM vw_list_users WHERE kode_user = '".strtolower($request->kode_user)."'");
        if (isset($usersname_check['0'])) {
            // If username already registered
            alert()->error('Gagal Menyimpan!', 'Maaf, NIK Dudah Digunakan!');
            return Redirect::back();
        } else {
            // If username not registered
            // Save profile picture
            $file_picture = $request->file('picture');
            if ($file_picture <> '') {

                $this->validate($request, [
                    'picture' => 'required|image|mimes:jpg,png,jpeg'
                ]);

                $file = $file_picture;

                // create filename with merging the timestamp and unique ID
                $f_name = Carbon::now()->timestamp . '_' . uniqid() . '.'. $file->getClientOriginalExtension();

                // upload original file (dimension hasn't been comppressed)
                // Image::make($file)->save($this->path . '/' . $f_name);

                //Looping array of image dimension that has been specify on contruct
                foreach ($this->dimensions as $row) {
                    //create image canvas according to dimension on array
                    $canvas = Image::canvas($row, $row);

                    //rezise according the dimension on array (still keep ratio)
                    $resizeImage  = Image::make($file)->resize($row, $row, function($constraint) {
                        $constraint->aspectRatio();
                    });

                    // insert image that compressed into canvas
                    $canvas->insert($resizeImage, 'center');

                    // move image in folder
                    $canvas->save($this->path . '/' . $f_name);
                }
            } else {
                $f_name = 'blank.jpg';
            }

            $users->picture = $f_name;

            // Insert data into database
            $users->save();

            alert()->success('Berhasil!', 'Data Sukses Disimpan!');
            return redirect('/users');
        }
    }

    // fungsi untuk redirect ke halaman edit
    public function EditUserData($id){
        $id = Crypt::decrypt($id);
        $jenis_user = session()->get('jenis_user');

        // Select User ID Sub Departemen
        $id_departemen_selected = DB::select("SELECT id_departemen from tb_master_users WHERE id_user =".$id);
        $id_departemen_selected = $id_departemen_selected[0]->id_departemen;
        $departemen = DB::select('SELECT id_departemen, nama_departemen FROM vg_list_departemen');

        $subdepartemen = DB::select("SELECT id_sub_departemen, nama_sub_departemen FROM vs_list_sub_departemen WHERE id_departemen =".$id_departemen_selected);

        // Select data based on ID
        $user = UsersModel::find($id);

        return view('admin.master.users-edit', [
            'menu'          => 'master',
            'sub'           => '/users',
            'users'         => $user,
            'departemen'    => $departemen,
            'subdepartemen' => $subdepartemen,
            'jenis_user'    => $jenis_user
        ]);
    }

    // simpan perubahan dari data yang sudah di edit
    public function SaveEditUserData(Request $request){
        $id_user = $request->id_user;
        $kode_user = strtolower($request->kode_user);
        $nama_user = strtoupper($request->nama_user);
        $email = $request->email;
        $jenis_user = $request->jenis_user;
        $id_departemen = $request->id_departemen;
        $id_sub_departemen = $request->id_sub_departemen;
        $updated_at = date('Y-m-d H:i:s', strtotime('+0 hours'));
        $pic = session()->get('id_user');
        $file_picture = $request->file('picture');
        $file_original_picture = $request->original_picture;



        // Is there a change in picture file?
        if ($file_picture <> '') {
            $this->validate($request, [
                'picture' => 'required|image|mimes:jpg,png,jpeg'
            ]);

            $file = $file_picture;

            // Create filename with merging the timestamp and unique ID
            $f_name = Carbon::now()->timestamp . '_' . uniqid() . '.'. $file->getClientOriginalExtension();

            // Upload original file (dimension hasn't been comppressed)
            // Image::make($file)->save($this->path . '/' . $f_name);

            //Looping array of image dimension that has been specify on contruct
            foreach ($this->dimensions as $row) {
                // Create image canvas according to dimension on array
                $canvas = Image::canvas($row, $row);

                // Rezise according the dimension on array (still keep ratio)
                $resizeImage  = Image::make($file)->resize($row, $row, function($constraint) {
                    $constraint->aspectRatio();
                });

                // Insert image that compressed into canvas
                $canvas->insert($resizeImage, 'center');

                // Move image in folder
                $canvas->save($this->path . '/' . $f_name);
            }
        } else {
            $f_name = $file_original_picture;
        }

        // Is there a change in email data?
        if ($request->email <> $request->original_email){
            // Check duplicate email
            $email_check = DB::select("SELECT email FROM vw_list_users WHERE email = '".$request->email."'");
            if (isset($email_check['0'])) {
                alert()->error('Gagal!', 'Maaf, Email Ini Sudah Terdaftar Dalam Sistem!');
                return Redirect::back();
            } else {
                // Update data into database
                UsersModel::where('id_user', $id_user)->update([
                    'kode_user'         => $kode_user,
                    'nama_user'         => $nama_user,
                    'email'             => $email,
                    'jenis_user'        => $jenis_user,
                    'id_departemen'     => $id_departemen,
                    'id_sub_departemen' => $id_sub_departemen,
                    'updated_at'        => $updated_at,
                    'pic'               => $pic,
                    'picture'           => $f_name,
                ]);

                alert()->success('Sukses!', 'Data Berhasil Diperbarui!');
                return redirect('/users');
            }
        } else {
            // Update data into database
            UsersModel::where('id_user', $id_user)->update([
                'kode_user'         => $kode_user,
                'nama_user'         => $nama_user,
                'updated_at'        => $updated_at,
                'jenis_user'        => $jenis_user,
                'id_departemen'     => $id_departemen,
                'id_sub_departemen' => $id_sub_departemen,
                'pic'               => $pic,
                'picture'           => $f_name,
            ]);

            // If user_id is active user_id, set session image
            if (session()->get('id_user') == $id_user) {
                session([
                    'img'           => $f_name,
                    'nama_user'     => $nama_user
                ]);
            }

            alert()->success('Sukses!', 'Data Berhasil Diperbarui!');
            return redirect('/users');
        }
    }

    // untuk beralih ke window ubah password
    public function ChangeUserPassword($id){
        $id = Crypt::decrypt($id);
        $jenis_user = session()->get('jenis_user');

        // Select data based on ID
        $user = UsersModel::find($id);

        return view('admin.master.users-password',[
            'menu'          => 'master',
            'sub'           => '/users',
            'users'         => $user,
            'jenis_user'    => $jenis_user
        ]);
    }

    public function SaveUserPassword(Request $request){
        $user_id = $request->id_user;
        //Ecrypt Password
        $encrypt_password = md5($request->password);
        $password = hash('ripemd160', $encrypt_password);

        //Encrypt New Password
        $encrypt_new_password = md5($request->new_password);
        $new_password = hash('ripemd160', $encrypt_new_password);

        //Encrypt Confirm Password
        $encrypt_confirm_password = md5($request->confirm_password);
        $confirm_password = hash('ripemd160', $encrypt_confirm_password);

        //Check password original
        // DB::select("SELECT password FROM tbl_master_users WHERE user_id = '".$user_id."'")
        $get_original_password = UsersModel::find($user_id, ['password']);
        $original_password = $get_original_password->password;

        if($password <> $original_password){
            // Wrong password
            alert()->error('Gagal!', 'Password yang Anda masukkan salah!');
            return Redirect::back();
        } else if($new_password <> $confirm_password) {
            // Password not match with confirm
            alert()->error("Gagal!", 'Password baru Anda tidak sama!');
            return Redirect::back();
        } else if($new_password == $password) {
            // No changes on password! Re input password until not match
            alert()->error('Gagal!', 'Tidak ada perubahan pada Password Anda!');
            return Redirect::back();
        } else {
            // Update new password into database
            UsersModel::where('id_user', '=', $user_id)->update([
                'password' => $new_password,
            ]);

            alert()->success('Data berhasil disimpan!', 'Sukses!');
            return redirect("/auth-logout/".Crypt::encrypt(session()->get('user_id')));
        }
    }

    // Fungsi hapus data
    public function DeleteUserData($id){
        $id = Crypt::decryptString($id);
        $picture = DB::select("SELECT picture FROM vw_list_users WHERE id_user='".$id."'");
        $picture = $picture[0]->picture;

        // Select table user to get user default value
        $user = UsersModel::find($id, ['kode_user']);

        $creator_check = DB::select('SELECT * FROM tb_inspeksi_detail WHERE creator = '.$id);
        // Check user already used in other table or not yet
        if (isset($creator_check[0])) {
            Alert::error("Gagal!", 'Data Ini Tidak Dapat Dihapus Karena Sudah Dipakai Tabel Lain!');
            return Redirect::back();
        }

        // If user default is 1, so the data can't be deleted
        if ($user['kode_user'] == '19104886') {
            Alert::error("Gagal!", 'Data Ini Tidak Dapat Di Hapus!');
            return Redirect::back();
        } else {

            if (isset($picture)) {
                if ($picture <> "blank.jpg") {
                    File::delete(public_path("/images/users/".$picture));
                }
            }

            // Check active user or not
            if($id == session()->get('user_id')) {
                // If user still active, so return back
                Alert::error("Gagal!", 'Anda Tidak Dapat Menghapus Data Ini Karena Data Masih Aktif!');
                return Redirect::back();
            } else {
                // If user inactive, so can be delete this data
                // Delete process
                $user = UsersModel::find($id);
                $user->delete();

                // Move to users list page
                alert()->success('Berhasil!', 'Berhasil Menghapus Data!');
                return redirect('/users');
            }
        }
    }
}
