<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades;
use Illuminate\Support\Str;
use App\Mail\SendResetPassword;
use App\Models\UsersModel; //Tambahkan folder models
use Redirect;
use Mail;
use Crypt;
use DB;

class AuthController extends Controller
{
    public function LoginView(){
        if (session()->get('username') <> '') {
            return Redirect('/dashboard');
        } else {
            return view('admin.login');
        }
    }

    public function AuthLogin(Request $request){
        $this->validate($request, [
            'kode_user' => 'required',
            'password'  => 'required',
        ]);
        
        $username = $request->username;
        $encrypt_password = md5($request->password);
        $password = hash('ripemd160', $encrypt_password);

        // check access on database
        // $usersValidation = DB::select("SELECT * FROM vw_master_users WHERE identity_number = '". $identity_number."' AND password ='".$password."'");
        $usersValidation = UsersModel::where('kode_user', $kode_user)->where('password', $password)->get();
        // show all menus according with identity number

        // if all data already exist on array or have not null value
        // so create session according with 'identity number'
        if ($usersValidation[0] ?? null) {
            if (($usersValidation[0]->username <> '') && ($usersValidation[0]->password <> '')) {
                session([
                    'user_id'       => $usersValidation[0]->user_id,
                    'kode_user'     => $usersValidation[0]->kode_user,
                    'nama_user'     => $usersValidation[0]->nama_user,
                    'jenis_user'    => $usersValidation[0]->jenis_user,
                    'picture'       => $usersValidation[0]->picture,
                ]);
                
                return redirect('/dashboard');
            }
        } else {
            // username doesn't exist on database
            alert()->error('Wrong username or password, please try again!', 'Access Denied!');
            return view('admin.login');
        }
    }

    public function AuthLogout(){
        // $user_id = Crypt::decrypt($id);

        // Clear session
        session()->forget([
            'user_id',
            'kode_user',
            'nama_user',
            'jenis_user',
            'picture',
        ]);
        session()->flush();

        alert()->success("Anda logout dari sistem", 'Sukses');
        return redirect('/login');
    }

    public function SendTokenReset(Request $request) {
        $email = $request->email;

        //Check availability member by email
        $isExist = DB::select("SELECT email, complete_name FROM vw_list_users WHERE email = '".$email."'");
        
        if (isset($isExist[0])) { // If data already exist
            // Create Random token and update into database where email = $email
            $token = Str::random(25);

            // Update token in database
            DB::table('tbl_master_users')->where('email', $email)->update([
                'token' => $token
            ]);

            // Send url into Email
            $url = 'http://localhost:8000/reset/'.Crypt::encrypt($token);
            $name = $isExist[0]->complete_name;

            $data = array(
                'name'  => $name,
                'url' => $url
            );

            Mail::send('admin.mail-password', $data, function($message) use($email, $name) {
                $message->to($email, $name)->subject('Reset Password');
                $message->from('system@bckguns.com','Automail PT Bintang Cakra Kencana');
            });

            alert()->success('Reset code have been send to your email!', 'Delivered!');

            return Redirect('/panel');
        } else { // If data hasn't been exist
            alert()->error("Your email isn't registered in the system!", 'Invalid!');
            return Redirect::back();
        }
    }

    public function GetDataFromToken($token){
        $token = Crypt::decrypt($token);
        $selected_user = DB::select("SELECT user_id FROM tbl_master_users WHERE token = '".$token."'");
        
        if(isset($selected_user[0])) {
            return view('admin.reset-password',[
                'users' => $selected_user
            ]);
        } else {
            alert()->error("Your token can't be use or invalid!", 'Invalid!');
            return Redirect('/panel');
        }
    }

    public function ResetPassword(Request $request){
        $token = Str::random(25);
        $user_id = $request->user_id;
        $enc_password = md5($request->password);
        $password = hash('ripemd160', $enc_password);

        // Update token in database
        DB::table('tbl_master_users')->where('user_id', $user_id)->update([
            'token'     => $token,
            'password'  => $password,
        ]);

        alert()->success('New password successfully saved!', 'Success!');
        return redirect('/panel');
    }
}