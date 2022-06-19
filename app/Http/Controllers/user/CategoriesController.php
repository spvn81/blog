<?php

namespace App\Http\Controllers\user;
use App\Http\Controllers\Controller;
use App\Models\categories;
use Facade\FlareClient\Http\Response;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use  Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Redirect;
use App\Models\categoryType;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\Auth;
use App\Helpers\uploadFiles;



class CategoriesController extends Controller
{

function categories(){

    $data['category'] = categories::all();
    return view('user.categories',$data);
}

function manage_category($id=''){
        $data['category'] = categories::where(['status'=>1])->get();
        $data['category_type_data'] = categoryType::all();

    if(!empty($id)){
        $data['cat'] = categories::find($id);
        $data['categories'] = $data['cat']->categories;
        $data['categories_slug'] = $data['cat']->categories_slug;
        $data['id'] = $data['cat']->id;
        $data['category_image'] = $data['cat']->category_image;
        $data['is_home'] = $data['cat']->is_home;
        $data['description'] = $data['cat']->description;
        $data['keywords'] = $data['cat']->keywords;
        $data['type'] = $data['cat']->type;




    }else{

        $data['categories'] = '';
        $data['categories_slug'] = '';
        $data['id'] = '';
        $data['category_image'] = '';
        $data['is_home'] = '';
        $data['description'] = '';
        $data['keywords'] = '';
        $data['type'] = '';
    }
    return view('user.manage_category',$data);
}


function manage_category_process(Request $request){
    $categories_data = strtolower($request->post('categories'));
    $categories_slug = strtolower( $request->post('categories_slug'));
    $category_type = $request->post('type');

    $description = $request->post('description');
    $keywords = $request->post('keywords');


    $id = $request->post('id');
    $parent_cat_id = $request->post('parent_cat_id');
    $validator = validator::make($request->all(),[
        'categories' => 'required',
        'categories_slug' => "required|regex:/(^[A-Za-z0-9 ]+$)+/|unique:categories,categories_slug,$id",
         'type'=>'required'
    ]);

    if($validator->fails()){
        return response()->json(['errors'=>$validator->errors()]);

    }else{

        if(!empty($id)){
            $data_save = categories::find($id);
        }else{
            $data_save = new categories();
        }

        $url = strtolower(urlencode(trim($categories_slug)));
        $link = str_replace('+','-',$url);
        $data_save->categories = $categories_data;
        $data_save->categories_slug = $categories_slug;
        $data_save->link = $link;
        $data_save->description = $description;
        $data_save->keywords = $keywords;
        $data_save->status = 1;
        $data_save->user_id  = Auth::user()->id;
        $data_save->is_home = $request->is_home;
        $data_save->type = $category_type;


        if ($request->hasFile('category_image')) {
            $file_name =   uploadFiles::uploadFileData($request->file('category_image'), 'plan categories');
            $data_save->category_image = uploadFiles::$file_name;
        }


        $data_save->save();
        return response()->json(['success'=>'saved']);

    }
}




function manage_category_delete($id){
    $delete_data = categories::find($id);
    $delete_data->delete();
    Session::flash('message', "Category data deleted");
    return Redirect::back();
    }

function categories_status($id,$changed_status){
    $status_data = categories::find($id);
    $status_data->status = $changed_status;
    $status_data->save();
    Session::flash('message', "Category Status updated");
    return Redirect::back();
}




function categories_delete(Request $request){
    $id = $request->post('id');
    $delete_data = categories::find($id);
    $delete_data->delete();
   return response()->json(['success'=>'deleted','msg'=>'category data deleted']);


}


}
