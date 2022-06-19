<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\album;
use App\Models\mediaFile;
use Illuminate\Support\Facades\Validator;
use App\Models\staticMenu;
use Illuminate\Support\Facades\Storage;
use App\Models\categories;
use App\Helpers\uploadFiles;

class fileManager extends Controller
{
    function index(){

        $data['albums'] = album::join('categories','categories.id','=','albums.menu_id')
        ->select(['albums.*','categories.categories'])
        ->get();

        return view('user.album',$data);
    }



    function manage_album($id=''){
        $data['category'] = categories::where(['type'=>'gallery'])->where(['status'=>1])->get();

        if(!empty($id)){
            $album_data = album::find($id);
            $data['category_id'] = $album_data->menu_id;
            $data['name'] = $album_data->name;
            $data['slug'] = $album_data->slug;
            $data['description'] = $album_data->description;
            $data['id'] = $album_data->id;
            $data['album_thumbnail'] = $album_data->album_thumbnail;


        }else{
            $data['category_id'] ='';
            $data['name'] = '';
            $data['slug'] = '';
            $data['description'] = '';
            $data['id'] = '';
            $data['album_thumbnail'] ='';

        }


        return view('user.manage_album',$data);
    }



    function myadm_manage_album_save(Request $request){

        $category_id = $request->menu_id;
        $name = $request->name;
        $slug = $request->slug;
        $description = $request->description;
        $id = $request->id;
        $album_thumbnail = $request->album_thumbnail;

        $validator = Validator::make($request->all(),[
            'menu_id'=>'required',
            'name'=>'required',
            'slug' => 'required|regex:/^[a-zA-Z0-9\s]+$/|unique:albums,slug,'.$id,
            ]);
        if($validator->fails()){
            return response()->json(array('errors' => $validator->errors()));

        }else{

            if(!empty($id)){
                $save_data = album::find($id);
            }else{
                $save_data = new album();
            }
            $link = urlencode($slug);
            $link = str_replace('+','-',$link);
            $save_data->menu_id = $category_id;
            $save_data->name = $name;
            $save_data->slug = $slug;
            $save_data->link = $link;

            $save_data->album_thumbnail = $album_thumbnail;
            $save_data->description = $description;
            $save_data->save();



        }


    }



    function manage_album_upload($album_id='',$file_id=''){
        $data['file_id'] = '';
        $data['file_name'] = '';
        $get_album_data = album::find($album_id);
        $data['album_name'] = $get_album_data->name;
        $data['file_type'] = '';
        $data['image_link'] = '';

        if(!empty($album_id) && !empty($file_id)){
                $data['album_id'] = $album_id;
                $data['file_id'] = $file_id;
                $data['get_file'] = mediaFile::where(['album_id'=>$album_id])->where(['id'=>$file_id])->get();
                if(!empty($data['get_file'][0])){
                    $data['file_name'] = $data['get_file'][0]->file_name;
                    $data['file_type'] = $data['get_file'][0]->file_type;
                    $data['image_link'] = $data['get_file'][0]->file_name;

                }

        }else{
               $data['album_id'] = $album_id;
        }

        return view('user.manage_album_upload',$data);


    }


    function manage_album_upload_data(Request $request,$album_id,$file_id=''){



        $validator =   Validator::make($request->all(),[
            'file'=>'mimes:jpeg,png,gif,tiff,bmp,jpg,mp4,mov,wmv,avi,mkv,mpeg-2,webp'
        ]);
        if($validator->fails()){
            return response()->json(array('errors' => $validator->errors()));

        }else{
            if ($request->hasFile('file')) {
                $file_data = $request->file('file');
                $path = $file_data->store('/public/media/gallery');
                $file_name = pathinfo($path)['basename'];
                $file_extension = $file_data->extension();
                $file_name_with_path = 'gallery/'.$file_name;
                $alt_name = pathinfo($file_data->getClientOriginalName(), PATHINFO_FILENAME);
                $file_types = [
                'image'=> [
                    'jpeg','png','gif','tiff','bmp','jpg','webp'
                ],
                'video'=>[
                    'mp4','mov','wmv','avi','mkv','mpeg-2'
                ]
              ];

                $check_file_type_img = in_array($file_extension, $file_types['image']);
                $check_file_type_video = in_array($file_extension, $file_types['video']);
                if ($check_file_type_img == true) {
                    $file_type = 'image';
                } elseif ($check_file_type_video == true) {
                    $file_type = 'video';
                } else {
                    $file_type = 'undefined';
                }

                if(!empty($album_id)&&!empty($file_id)){
                    $store_data = mediaFile::find($file_id);
                    $old_file = 'public/media/'.$store_data->file_name;
                    Storage::delete($old_file);
                    $msg= 'update';
                }else{
                    $store_data = new mediaFile();
                    $msg= 'inserted';
                }

                $store_data->album_id = $album_id;
                $store_data->file_name = $file_name_with_path;
                $store_data->file_type = $file_type;
                $store_data->alt_name = $alt_name;
                $store_data->save();
                $check_thumbnail = album::find($album_id);
                if(empty($check_thumbnail->album_thumbnail)){

                    $last_id = $store_data->id;
                    $get_image_link = mediaFile::find($last_id);
                    if($get_image_link->file_type=='image'){
                    $file_name = $get_image_link->file_name;
                    $check_thumbnail->album_thumbnail = $file_name;
                    $check_thumbnail->save();
                    }

                }

                return response()->json(array('success' => $msg));

            }
        }




    }


    function manage_album_view($id){
        $data['images'] = album::join('categories','categories.id','=','albums.menu_id')
        ->join('media_files','albums.id','=','media_files.album_id')
        ->select(['media_files.*','albums.name','albums.id as album_id'])
        ->where(['media_files.album_id'=>$id])
        ->get();
        if (!empty($data['images'][0])) {
            return view('user.manage_album_view', $data);
        }else{
            return redirect('albums');
        }

    }

    function file_delete(Request $request){
        $id = $request->id;
        $delete_data = mediaFile::find($id);
        $delete_file = 'public/media/'.$delete_data->file_name;
        Storage::delete($delete_file);
        $delete_data->delete();
        return response()->json(['success'=>'deleted']);

    }

function albums_data_delete(Request $request){
    $id = $request->id;
    $album_delete = album::find($id);
    $album_files = mediaFile::where(['album_id'=>$id])->get();
    if(!empty($album_files[0])){
        foreach($album_files as $album_files_data){
            $file_arr_delete[] = 'public/media/'.$album_files_data->file_name;
        }

        Storage::delete($file_arr_delete);
    }
    $album_delete->delete();
    return response()->json(['success'=>'deleted']);

}


function upload_video_thumbnail($id){

if(!empty($id)){
    $file_data = mediaFile::find($id);
    $data['album_id'] = $file_data->album_id;
    $data['file_id'] = $id;

    if($file_data->video_thumbnail==null){

            $data['video_thumbnail'] = '';

    }else{
        $data['video_thumbnail'] =    $file_data->video_thumbnail;
    }
return view('user.upload_video_thumbnail',$data);

}else{
    back();
}
}


function upload_video_thumbnail_process(Request $request){

    $validator = validator::make($request->all(), [
    'video_thumbnail' => uploadFiles::image(512),
    ]);

    if ($validator->fails()) {
        return response()->json(['errors' => $validator->errors()]);
    } else {
        if ($request->hasFile('video_thumbnail')) {
            $file_id = $request->file_id;
            $save_data = mediaFile::find($file_id);
            if($save_data->video_thumbnail !=null){
                $delete_file = 'public/media/'.$save_data->video_thumbnail;
                Storage::delete($delete_file);
            }
            uploadFiles::uploadFileData($request->file('video_thumbnail'), 'video_thumbnails');
            $save_data->video_thumbnail = uploadFiles::$file_name;


            $save_data->save();


        }


    }



}


}
