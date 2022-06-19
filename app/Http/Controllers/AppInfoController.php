<?php

namespace App\Http\Controllers;

use App\Models\appInfo;
use Illuminate\Http\Request;
use App\Models\User;
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
use App\Rules\PhoneNumber;




class AppInfoController extends Controller
{

    function app_settings(){
        $data['app'] = appInfo::all();
        return view('user.app_settings',$data);
    }











public function app_settings_process(Request $request)
{


    $logo = uploadFiles::image(10);
    $favicon = uploadFiles::image(10);


    $validator = validator::make($request->all(), [
        'app_name' => 'required',
        'favicon'=>$favicon,
        'logo'=>$logo,
        'phone' => ['required', new PhoneNumber],


    ]);

    if ($validator->fails()) {
        return response()->json(['errors' => $validator->errors()]);
    } else {

        if(!empty($request->id)){

            $save_data = appInfo::find($request->id);

        }else{

            $save_data = new appInfo();
        }
        $save_data->app_name =  $request->app_name;
        $save_data->title =  $request->title;
        $save_data->sub_title =  $request->sub_title;
        $save_data->app_url =  $request->app_url;
        $save_data->description =  $request->description;
        $save_data->address =  $request->address;
        $save_data->email =  $request->email;
        $save_data->phone =  $request->phone;
        $save_data->about_page_ink =  $request->about_page_ink;
        $save_data->keywords =  $request->keywords;
        $save_data->show_title =  $request->show_title;
        $save_data->show_logo =  $request->show_logo;



        if($request->hasFile('logo')){
        uploadFiles::uploadFileData($request->file('logo'), 'appInfo');
        $logo = uploadFiles::$file_name;



        $save_data->logo =  $logo;
           }
     if($request->hasFile('favicon')){
        uploadFiles::uploadFileData($request->file('favicon'), 'appInfo');
        $favicon = uploadFiles::$file_name;
        $save_data->favicon =  $favicon;
            }



        $save_data->save();
        return response()->json(['success' => 'Saved']);


    }


}










}
