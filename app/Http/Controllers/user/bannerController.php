<?php

namespace App\Http\Controllers\user;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\homeBanner;
use Illuminate\Support\Facades\Validator;
use App\Helpers\uploadFiles;


class bannerController extends Controller
{


    function banner()

    {
        $data['banner'] = homeBanner::all();
        return view('user.banner',$data);
    }


    public function manage_banner($id = '')
    {

        if (!empty($id)) {
            $banner = homeBanner::find($id);
            $data['description'] = $banner->description;

            $data['link'] = $banner->link;
            $data['status'] = $banner->status;
            $data['id'] = $banner->id;
            $data['banner'] = $banner->banner;
            $data['alt_name'] = $banner->alt_name;
            $data['target_store'] = $banner->target;


        } else {
            $data['description'] = '';
            $data['link'] = '';
            $data['status'] = '';
            $data['id'] = '';
            $data['banner'] = '';
            $data['alt_name'] = '';
            $data['target'] = '';
            $data['target_store'] ='';
        }

        return view('user.manage_banner', $data);
    }











    function manage_banner_process(Request $request)
    {

        $id = $request->id;

        if (!empty($id)) {
            $image_validator = uploadFiles::image(512);
        } else {
            $image_validator = uploadFiles::image(512, 'required');
        }

        $validator = validator::make($request->all(), [
            'banner' => $image_validator,

        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()]);
        } else {




            if (!empty($request->id)) {
                $save_data = homeBanner::find($request->id);
            } else {
                $save_data = new homeBanner();
            }



            $save_data->description = $request->description;
            $save_data->link = $request->link;
            $save_data->alt_name = $request->alt_name;
            $save_data->target = $request->target;
            $save_data->status = 1;
            if ($request->hasFile('banner')) {
                $file_name =   uploadFiles::uploadFileData($request->file('banner'), 'banners');
                $save_data->banner = uploadFiles::$file_name;
            }




            $save_data->save();
            return response()->json(['success' => 'Banner data saved']);
        }
    }





    function banner_delete(Request $request)
    {
        $id = $request->post('id');
        $delete_data = homeBanner::find($id);
        $delete_data->delete();
        return response()->json(['success' => 'deleted', 'msg' => 'banner data deleted']);
    }




}
