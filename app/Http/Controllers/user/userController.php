<?php

namespace App\Http\Controllers\user;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use  Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;
use App\Mail\mailSupport;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;
use App\Models\otp;
use App\Rules\PhoneNumber;
use App\Models\appInfo;
use App\Helpers\getApp;
use App\Models\userCreateData;
use App\Helpers\uploadFiles;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Storage;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Spatie\MediaLibrary\MediaCollections\Models\Media;
use Illuminate\Support\Facades\URL;
use App\Models\webPage;
use App\Models\comment;



use  Illuminate\Support\Facades\DB;



class userController extends Controller
{




    public function logout(Request $request)
    {
        if (Auth::check()) {
            Auth::logout();
            $request->session()->invalidate();
            $request->session()->regenerateToken();
            return redirect('/');
        }
    }

    function login()
    {
        if (Auth::check()) {
            return   redirect('/dashboard');
        } else {
            return view('user.login');
        }


    }


    function dashboard()
    {

        if (Auth::check()) {


            $data['users'] = count(User::all());
            $data['post'] = count(webPage::all());
            $data['comment'] = count(comment::where(['read_status'=>null])->get());



            return view('user.dashboard',$data);
        }
    }


    function uerLogin(Request $request)
    {
        $validator = validator::make($request->all(), [
            'email' => 'required',
            'password' => 'required',

        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()]);
        } else {

            $credentials = [
                'email' => $request->input('email'),
                'password' => $request->input('password'),
                'is_email_verified'=>1

            ];

            $remember_me = $request->has('remember_me') ? true : false;
            if (Auth::attempt($credentials , $remember_me)) {
                    return response()->json(['success' => 'Login success!.']);

            } else {
                return response()->json(['errors' => [
                    'invalid' => 'your username or password are wrong.'
                ]]);
            }
        }
    }

    function forgot_password()
    {

        return view('user.forgot_password');
    }


    function send_otp(Request $request)
    {
        $email =  strtolower($request->post('email'));

        $validator = validator::make($request->all(), [
            'email' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()]);
        } else {
            $app = getApp::getAppName();
            $data = User::where(['email' => $email])->get();
                
            if (!empty($data[0]->email) && $data[0]->email == $email) {
                $otp = Str::random(8);
                $link_path = Str::random(100);
                $link_data = $_SERVER['HTTP_HOST'] . '/' . 'reset-password' . '/' . $link_path;
                $user_id = $data[0]->id;
                $arrayEmails = [$email];
                $emailSubject = 'Otp';
                $emailBody = [
                    'title' => 'Reset password link',
                    'link' => $link_data

                ];

                $sent = Mail::send(
                    'mail.validateOtp',
                    ['msg' => $emailBody],
                    function ($message) use ($arrayEmails, $emailSubject) {
                        $message->to($arrayEmails)
                            ->subject($emailSubject);
                    }


                );
                $data_otp = new otp();
                $data_otp->user_id = $user_id;
                $data_otp->otp = $otp;
                $data_otp->otp_type = 'for_got_password';
                $data_otp->otp_device = '2';
                $data_otp->otp_expired = 30;
                $data_otp->otp_status = 'pending';
                $data_otp->link = $link_path;
                $data_otp->save();
                return response()->json(['success' => 'Link has sent to your registered email Id.']);
            } else {

                return response()->json(['errors' => [
                    'invalid' => 'Unregistered Email Address.'
                ]]);
            }
        }
    }

    function reset_password($str)
    {
        if (empty($str)) {
            return redirect('/');
        } else {
            $data['otp'] = otp::where(['link' => $str])->get();
            if (!empty($data['otp'][0])) {
                $user_id = $data['otp'][0]->user_id;
                $data['user_data'] = user::find($user_id);
                if (!empty($data['user_data'])) {
                    if ($data['user_data']->user_status == 1) {
                        $data['email'] = $data['user_data']->email;
                        $data['str'] = $str;
                        return view('user.reset_password', $data);
                    } else {
                        $data['email'] = '';
                        $data['str'] = '';
                        Session::flash('message', 'Your account is Inactive please to contact to admin');
                        return view('user.reset_password', $data);
                    }
                }
            } else {
                return redirect('/');
            }
        }
    }



    public function register(Request $request)
    {

        $name = $request->post('name');
        $email  = $request->post('email');
        $user_type = $request->post('user_type');
        if (!empty($request->post('password'))) {
            $password = Hash::make($request->post('password'));
        }
        $user_id_created_by = $request->post('user_id_created_by');
        $mobile_number = $request->post('mobile_number');
        $email_request = $request->post('email_request');
        $id = $request->post('id');

        if (empty($id)) {
            $password_validate = 'required|min:8|same:confirm_password';
        } else {
            $password_validate = 'same:confirm_password';
        }

        $validator = validator::make($request->all(), [
            'name' => 'required',
            'email' => 'required|email|unique:users,email,' . $id,
            'password' => $password_validate,
            'mobile_number' => ['required', new PhoneNumber],
            'user_type' => 'required',
            'terms' => 'required',
           'avatar' => uploadFiles::image(512),

        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()]);
        } else {



            if (!empty($id)) {
                $save_data = user::find($id);
                $msg = 'User Updated successfully';
            } else {
                $save_data = new user();
                $msg = 'user created successfully';
            }

            $save_data->name = $name;
            $save_data->email = $email;
            $save_data->user_type = $user_type;
            if (!empty($password)) {
                $save_data->password = $password;
            }
            $save_data->mobile_number = $mobile_number;

            if ($request->hasFile('avatar')) {
                $file_name =   uploadFiles::uploadFileData($request->file('avatar'), 'users');
                $save_data->avatar = uploadFiles::$file_name;
            }

            if ($save_data->save()) {

                $user_id =  $save_data->id;
                $user = user::find($user_id);
                $user->assignRole($user_type);


                $created_user_id = $save_data->id;
                $save_user_create_data =  new userCreateData();
                $save_user_create_data->user_id_created_by = $user_id_created_by;
                $save_user_create_data->role = $user_type;
                $save_user_create_data->created_user_id = $created_user_id;
                $save_user_create_data->email_request = $email_request;
                $save_user_create_data->save();

                if ($email_request == 'no' &&  (auth::user()->user_type == 'super_admin' || auth::user()->user_type == 'admin')) {
                    $verified_at = now()->timestamp;
                    $update_user = user::find($user_id);
                    $update_user->email_verified_at = $verified_at;
                    $update_user->is_email_verified = 1;
                    $update_user->user_status = 1;
                    $update_user->save();
                    DB::table('model_has_roles')->where(['model_id'=>$update_user->id])->delete();


                    $update_user->assignRole($user_type);
                    return response()->json(['success' => $msg]);
                } else {


                    $app = getApp::getAppName();
                    $data =   $save_data->id;
                    $otp = Str::random(8);
                    $link_path = Str::random(100);
                    $user_id = $data;
                    $arrayEmails = [$email];
                    $link_data = $_SERVER['HTTP_HOST'] . '/' . 'verify' . '/' . $link_path;
                    $emailSubject = 'Otp';
                    $emailBody = [
                        'title' => 'verify email click',
                        'otp'  => $otp,
                        'link' => $link_data
                    ];

                    $sent = Mail::send(
                        'mail.validateOtp',
                        ['msg' => $emailBody],
                        function ($message) use ($arrayEmails, $emailSubject) {
                            $message->to($arrayEmails)
                                ->subject($emailSubject);
                        }
                    );
                    if (count(Mail::failures()) > 0) {
                        return response()->json(['errors' => 'email issue']);
                    } else {
                        $data_otp = new otp();
                        $data_otp->user_id = $user_id;
                        $data_otp->otp = $otp;
                        $data_otp->otp_type = 'new_register';
                        $data_otp->otp_device = '2';
                        $data_otp->otp_expired = 30;
                        $data_otp->otp_status = 'pending';
                        $data_otp->link = $link_path;
                        $data_otp->save();
                        return response()->json(['success' => 'user created successfully verify email and login']);
                    }



                }
            }
        }
    }


    function verify($str)
    {
        $get_data = otp::where(['link' => $str])->get();
        if (!empty($get_data[0])) {
            $user_id = $get_data[0]->user_id;
            $otp_type = $get_data[0]->otp_type;
            $otp = $get_data[0]->otp;
            $link = $get_data[0]->link;
            if ($link == $str) {
                $data['str'] =  $str;
                $data['user_id'] =  $user_id;
                $data['otp_type'] =  $otp_type;
            }
            return view('user.verify', $data);
        } else {
            return  redirect('/');
        }
    }



    function verified(Request $request, $str)
    {
        $str_post = $request->post('str');
        $user_id = $request->post('user_id');
        $otp_type = $request->post('otp_type');

        $otp = $request->post('otp');
        if ($str_post == $str) {
            $check_otp = otp::where(['user_id' => $user_id])
                ->where(['otp' => $otp])
                ->where(['link' => $str_post])->get();
        }
        if (!empty($check_otp[0])) {
            $update_user = user::find($user_id);
                if($otp_type=='update_user_profile'){
                    $update_email_req =  $update_user->update_email_req;
                    $update_user->email   = $update_email_req;
                    $update_user->update_email_req   = '';
                }
            $otp_id = $check_otp[0]->id;
            $verified_at = now()->timestamp;
            $update_user->email_verified_at = $verified_at;
            $update_user->user_status = 1;
            $update_user->is_email_verified = 1;
            $update_user->save();
            $delete_otp = otp::find($otp_id);
            $delete_otp->delete();



            return response()->json(['success' => 'email verified successfully']);
        } else {
            return response()->json(['errors' => 'Invalid Otp']);
        }
    }

    function reset_password_submit(Request $request)
    {
        $password = $request->post('password');
        $confirm_Password = $request->post('confirm_password');
        $email = $request->post('email');
        $str = $request->post('str');

        $validator = validator::make($request->all(), [
            'password' => 'min:8|required_with:confirm_password|same:confirm_password',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()]);
        } else {

            if ($email == '' ||  $str == '') {
                return response()->json(['errors' => [
                    'invalid' => 'User inactive please contact to admin.'
                ]]);
            } else {
                $password_hash = Hash::make($password);
                user::whereEmail($email)->update(['password' => $password_hash]);

                return response()->json(['success' => 'password change successful; login']);
            }
        }
    }



    function users()
    {
        $data['user_data'] = user::all();


        return view('user.users', $data);
    }



    function manage_user($id = '')
    {


        $data['user_role_data'] = role::all();

        if (!empty($id)) {
            $data['user'] = user::find($id);
            $data['id'] = $data['user']->id;
            $data['name'] = $data['user']->name;
            $data['avatar'] =  $data['user']->avatar;
            $data['email'] = $data['user']->email;
            $data['mobile_number'] = $data['user']->mobile_number;
            $data['email_verified_at'] = $data['user']->email_verified_at;
            $data['mobile_verified_at'] = $data['user']->mobile_verified_at;
            $data['user_type'] = $data['user']->user_type;
            $data['user_status'] = $data['user']->user_status;
            $data['user_image'] = $data['user']->avatar;
        } else {


            $data['id'] = '';
            $data['name'] = '';
            $data['avatar'] = '';
            $data['email'] = '';
            $data['mobile_number'] = '';
            $data['email_verified_at'] = '';
            $data['mobile_verified_at'] = '';
            $data['user_type'] = '';
            $data['user_status'] = '';
            $data['user_image'] = '';
        }
        return view('user.manage_user', $data);
    }


    function user_status($id, $changed_status)
    {
        $status_data = user::find($id);
        $status_data->user_status = $changed_status;
        $status_data->save();
        Session::flash('message', "User Status updated");
        return Redirect::back();
    }


    function user_status_profile_pic($id, $uid, $changed_status)
    {
        $save_data = user::find($uid);
        if ($changed_status == 0) {
            $save_data->avatar = '';
        } else {
            $status_data = json_decode(Media::find($id));
            $file_name = $id . '/' . $status_data->file_name;
            $save_data->avatar = $file_name;
        }


        $save_data->save();
        Session::flash('message', "User Profile picture updated");
        return Redirect::back();
    }





    function attached_file_delete(Request $request)
    {
        $id = $request->post('id');
        $delete_data = user::find($id);
        $path = 'public/media/' . $delete_data->avatar;
        Storage::delete($path);
        $delete_data->delete();
        return response()->json(['success' => 'deleted', 'msg' => 'User data deleted']);
    }



    function user_delete(Request $request)
    {
        $id = $request->post('id');
        $delete_data = user::find($id);
        $path = 'public/media/' . $delete_data->avatar;
        Storage::delete($path);
        $delete_data->delete();
        return response()->json(['success' => 'deleted', 'msg' => 'User data deleted']);
    }



    function settings()
    {

        return view('user.video.settings');
    }



function user_update(Request $request){



    $name = $request->post('name');
    $email  = $request->post('email');
    $user_type = $request->post('user_type');
    if (!empty($request->post('password'))) {
        $password = Hash::make($request->post('password'));
    }
    $mobile_number = $request->post('mobile_number');
    $email_request = $request->post('email_request');
    $id = $request->post('id');

    if (empty($id)) {
        $password_validate = 'required|min:8|same:confirm_password';
    } else {
        $password_validate = 'same:confirm_password';
    }

    $validator = validator::make($request->all(), [
        'name' => 'required',
        'email' => 'required|email|unique:users,email,' . $id,
        'password' => $password_validate,
        'mobile_number' => ['required', new PhoneNumber],
       'avatar' => uploadFiles::image(512),

    ]);

    if ($validator->fails()) {
        return response()->json(['errors' => $validator->errors()]);
    } else {

        $user = user::find(Auth::user()->id);
        if($user->email==$request->email){

        }else{


            $user->update_email_req = $request->email;

            $app = getApp::getAppName();
                    $data =   Auth::user()->id;
                    $otp = Str::random(8);
                    $link_path = Str::random(100);
                    $user_id = $data;
                    $arrayEmails = [$email];
                    $link_data = $_SERVER['HTTP_HOST'] . '/' . 'verify' . '/' . $link_path;
                    $emailSubject = 'Otp';
                    $emailBody = [
                        'title' => 'verify update email click',
                        'otp'  => $otp,
                        'link' => $link_data
                    ];

                    $sent = Mail::send(
                        'mail.validateOtp',
                        ['msg' => $emailBody],
                        function ($message) use ($arrayEmails, $emailSubject) {
                            $message->to($arrayEmails)
                                ->subject($emailSubject);
                        }
                    );
                    if (count(Mail::failures()) > 0) {
                        return response()->json(['errors' => 'email issue']);
                    } else {
                        $data_otp = new otp();
                        $data_otp->user_id = $user_id;
                        $data_otp->otp = $otp;
                        $data_otp->otp_type = 'update_user_profile';
                        $data_otp->otp_device = '2';
                        $data_otp->otp_expired = 30;
                        $data_otp->otp_status = 'pending';
                        $data_otp->link = $link_path;
                        $data_otp->save();
                        return response()->json(['success' => 'user data updated successfully verify email and login']);
                    }




        }
        $user->name = $request->name;
        $user->mobile_number = $request->mobile_number;
        if ($request->hasFile('avatar')) {
            $file_name =   uploadFiles::uploadFileData($request->file('avatar'), 'users');
            $user->avatar = uploadFiles::$file_name;
        }
        return response()->json(['success' => 'user data updated successfully']);

        $user->save();

    }


}



function submit_mobile_number_process(Request $request){
$mobile_number = $request->mobile_number;


$validator = validator::make($request->all(), [
    'mobile_number' => ['required', new PhoneNumber],

]);

if ($validator->fails()) {
    return response()->json(['errors' => $validator->errors()]);
} else {

$update_user_number = user::find(Auth::user()->id);
$update_user_number->mobile_number  = $mobile_number;
$update_user_number->save();
return response()->json(['success' => 'user data updated successfully']);
}

}


}
