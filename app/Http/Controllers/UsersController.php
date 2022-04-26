<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

// Tambahkan source dibawah ini
use Illuminate\Support\Facades\DB;
use App\Models\UsersModel;
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
        $users = UsersModel::all();

        return view('admin.master.users-list',[
            'menu'  => 'master',
            'sub'   => '/users',
            'users' => $users
        ]);
    }

    // Redirect ke window input users
    public function UsersInput(){
        return view('admin.master.users-input',[
            'menu'  => 'master', // selalu ada di tiap function dan disesuaikan
            'sub'   => '/users'
        ]);
    }

    //Simpan data user
    public function SaveUserData(Request $request){
        $users = new UsersModel();

        // Parameters
        $users->kode_user = strtolower($request->kode_user);
        $users->nama_user = strtoupper($request->nama_user);
        $encrypt_password = md5(strtolower($request->username));
        $users->password = hash('ripemd160', $encrypt_password);
        $users->email = $request->email;
        $users->jenis_user = 0; //nanti diubah
        $users->id_departemen = 0; //nanti diubah
        $users->id_sub_departemen = 0; //nanti diubah
        $users->creator = session()->get('user_id');
        $users->pic = session()->get('user_id'); 

        // Check duplicate email
        $email_check = DB::select("SELECT email FROM vw_list_users WHERE email = '".$request->email."'");
        if (isset($email_check['0'])) {  
            alert()->error('Gagal Menyimpan!', 'Maaf, Email ini sudah didaftarkan dalam sistem!');
            return Redirect::back();
        }

        // Check duplicate username
        $usersname_check = DB::select("SELECT kode_user FROM vw_list_users WHERE kode_user = '".strtolower($request->kode_user)."'");
        if (isset($usersname_check['0'])) {
            // If username already registered
            alert()->error('Gagal Menyimpan!', 'Maaf, NIK sudah digunakan!');
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
            
            alert()->success('Berhasil!', 'Data sukses disimpan!');
            return redirect('/users');
        }
    }

    // fungsi untuk redirect ke halaman edit
    public function EditUserData($id){
        $id = Crypt::decrypt($id);

        // Select data based on ID
        $user = UsersModel::find($id);
        
        return view('admin.master.users-edit', [
            'menu'  => 'master',
            'sub'   => '/users',
            'users' => $user,
        ]);
    }

    // simpan perubahan dari data yang sudah di edit
    public function SaveEditUserData(Request $request){
        $id_user = $request->id_user;
        $kode_user = strtolower($request->kode_user);
        $nama_user = strtoupper($request->nama_user);
        $email = $request->email;
        $updated_at = date('Y-m-d H:i:s', strtotime('+0 hours'));
        $pic = session()->get('id_user');
        $file_picture = $request->file('picture'); 
        $file_original_picture = $request->original_picture; 

        // return $request;

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
                alert()->error('Gagal!', 'Maaf, Email ini sudah terdaftar dalam sistem!');
                return Redirect::back();
            } else {
                // Update data into database
                UsersModel::where('id_user', $id_user)->update([
                    'kode_user'         => $kode_user,
                    'nama_user'         => $nama_user,
                    'email'             => $email,
                    'updated_at'        => $updated_at,
                    'pic'               => $pic,
                    'id_departemen'     => 0,
                    'id_sub_departemen' => 0,
                    'jenis_user'        => '0',
                    'picture'           => $f_name,
                ]);
                
                alert()->success('Sukses!', 'Data berhasil diperbarui!');
                return redirect('/users');
            }
        } else {
            // Update data into database
            UsersModel::where('id_user', $id_user)->update([
                'kode_user'         => $kode_user,
                'nama_user'         => $nama_user,
                'updated_at'        => $updated_at,
                'pic'               => $pic,
                'id_departemen'     => 0,
                'id_sub_departemen' => 0,
                'jenis_user'        => '0',
                'picture'           => $f_name,
            ]);

            // If user_id is active user_id, set session image
            if (session()->get('id_user') == $id_user) {
                session([
                    'img'           => $f_name,
                    'nama_user'     => $nama_user
                ]);
            }
            
            alert()->success('Sukses!', 'Data berhasil diperbarui!');
            return redirect('/users');
        }
    }

    // untuk beralih ke window ubah password
    public function ChangeUserPassword($id){
        $id = Crypt::decrypt($id);
        
        // Select data based on ID
        $user = UsersModel::find($id);

        return view('admin.master.users-password',[
            'menu'  => 'master',
            'sub'   => '/users',
            'users' => $user,
        ]);
    }

    // Fungsi hapus data
    public function DeleteUserData($id){
        $id = Crypt::decryptString($id);
        
        // Select table user to get user default value
        $user = UsersModel::find($id, ['kode_user']);
        
        $creator_check = DB::select('SELECT * FROM tb_inspeksi_detail WHERE creator = '.$id);
        // Check user already used in other table or not yet
        if (isset($creator_check[0])) {
            Alert::error("Gagal!", 'Data ini tidak dapat dihapus karena sudah dipakai tabel lain!');
            return Redirect::back(); 
        }

        // If user default is 1, so the data can't be deleted
        if ($user['kode_user'] == '1') {
            Alert::error("Gagal!", 'Data ini tidak dapat di hapus!');
            return Redirect::back();
        } else {
            // Check active user or not
            if($id == session()->get('user_id')) {
                // If user still active, so return back 
                Alert::error("Gagal!", 'Anda tidak dapat menghapus data ini karena data masih aktif!');
                return Redirect::back();
            } else {
                // If user inactive, so can be delete this data
                // Delete process
                $user = UsersModel::find($id);
                $user->delete();

                // Move to users list page
                alert()->success('Berhasil!', 'Berhasil menghapus data!');
                return redirect('/users');
            }
        }        
    }
}
