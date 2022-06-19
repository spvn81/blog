<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\emailConfiguration;
use App\Models\notificationsSentUsers;
use App\Models\notificationStatus;
use App\Models\plan;
use App\Models\planSubscription;
use App\Models\User;
use App\Models\userGroup;
use App\Models\userGroupData;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\DB;
use App\Helpers\regularModules;
use Carbon\Carbon;
use App\Models\appNotificationFile;
use App\Helpers\uploadFiles;
use App\Providers\MailConfigProvider;
use App\Mail\DynamicEmail;
use Illuminate\Support\Facades\Mail;





class EmailConfigurationController extends Controller
{
    function email_configs(){
        $data['email_config']  = emailConfiguration::all();
        return view('user.email_configs',$data);
    }







function email_configs_process(Request $request){

if(!empty($request->id)){
$save_data =  emailConfiguration::find($request->id);
}else{
    $save_data = new emailConfiguration();

}

$save_data->user_id  = Auth::user()->id;
$save_data->driver  =$request->driver;
$save_data->host  =$request->host;
$save_data->port  =$request->port;
$save_data->encryption  =$request->encryption;
$save_data->user_name  =$request->user_name;
$save_data->password  =$request->password;
$save_data->sender_name  =$request->sender_name;
$save_data->sender_email  =$request->sender_email;
$save_data->save();


}



public function sendEmail(Request $request) {
    $toEmail    =   $request->emailAddress;
    $data       =   array(
        "message"    =>   $request->message
    );

    // pass dynamic message to mail class
    Mail::to($toEmail)->send(new DynamicEmail($data));

    if(Mail::failures() != 0) {
        return response()->json(['success' => 'email sent']);
    }

    else {
            return response()->json(['success' => 'not sent']);
    }
}




function test_mail(){

    return view('user.test_mail');
}



}
