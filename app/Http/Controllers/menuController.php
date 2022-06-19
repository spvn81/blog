<?php

namespace App\Http\Controllers;

use App\Models\categories;
use Illuminate\Http\Request;
use App\Models\menu;
use App\Models\categoryType;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use  Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Redirect;
use App\Models\menuitem;
use App\Models\webPage;
use App\Models\staticMenu;

class menuController extends Controller
{
    function menu()
    {

        $data['menu'] = staticMenu::all();
        return view('user.menu', $data);
    }



    function manage_menu($id = '')
    {
        $data['menu'] = staticMenu::all();
        $data['menu_type_data'] = categoryType::all();

        if (!empty($id)) {
            $data['menu_data'] = staticMenu::find($id);
            $data['menu_name'] = $data['menu_data']->menu_name;
            $data['menu_slug'] = $data['menu_data']->menu_slug;
            $data['id'] = $data['menu_data']->id;
            $data['menu_parent_id'] = $data['menu_data']->menu_parent_id;
            $data['link'] = $data['menu_data']->link;
            $data['menu_type'] = $data['menu_data']->menu_type;
            $data['is_data'] = $data['menu_data']->is_data;


        } else {

            $data['menu_name'] = '';
            $data['menu_slug'] = '';
            $data['id'] = '';
            $data['menu_parent_id'] = '';
            $data['link'] = '';
            $data['menu_type'] = '';
            $data['is_data'] = '';
        }
        return view('user.manage_menu', $data);
    }





    function manage_menu_process(Request $request)
    {
        $menu_name = $request->post('menu_name');
         $menu_slug = $request->post('menu_slug');
        $menu_parent_id = $request->post('menu_parent_id');

        $menu_type = $request->post('menu_type');
        $id = $request->post('id');
        $validator = validator::make($request->all(), [
            'menu_name' => 'required',
            'menu_slug' => "required|regex:/(^[A-Za-z0-9 ]+$)+/|unique:static_menus,menu_slug,$id",
            'menu_type' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()]);
        } else {


            if (!empty($id)) {
                $data_save = staticMenu::find($id);
            } else {
                $data_save = new staticMenu();
            }
            if($menu_type=='gallery'){
                $url_enc = urlencode($menu_slug);
                $str_replace = str_replace('+','-',$url_enc);
                $link = $str_replace;
            }else{
                $link = $request->post('link');
            }

            $data_save->menu_name = $menu_name;
            $data_save->menu_slug = $menu_slug;
            $data_save->menu_parent_id = $menu_parent_id;
            $data_save->link = $link;
            $data_save->user_id  = Auth::user()->id;
            $data_save->menu_type = $menu_type;
            if (!empty($link)){
                $data_save->is_data = 1;
              }
            $data_save->save();
            return response()->json(['success' => 'saved']);
        }
    }




    function menu_delete(Request $request)
    {
        $id = $request->post('id');
        $delete_data = staticMenu::find($id);
        $delete_data->delete();
        return response()->json(['success' => 'deleted', 'msg' => 'Menu data deleted']);
    }



function dynamic_menu(){




    $menuitems = '';
    $desiredMenu = '';
    if(isset($_GET['id']) && $_GET['id'] != 'new'){
      $id = $_GET['id'];
      $desiredMenu = menu::where('id',$id)->first();
      if($desiredMenu->content != ''){
        $menuitems = json_decode($desiredMenu->content);
        $menuitems = $menuitems[0];
        foreach($menuitems as $menu){
          $menu->title = menuitem::where('id',$menu->id)->value('title');
          $menu->name = menuitem::where('id',$menu->id)->value('name');
          $menu->slug = menuitem::where('id',$menu->id)->value('slug');
          $menu->target = menuitem::where('id',$menu->id)->value('target');
          $menu->type = menuitem::where('id',$menu->id)->value('type');
          if(!empty($menu->children[0])){
            foreach ($menu->children[0] as $child) {
              $child->title = menuitem::where('id',$child->id)->value('title');
              $child->name = menuitem::where('id',$child->id)->value('name');
              $child->slug = menuitem::where('id',$child->id)->value('slug');
              $child->target = menuitem::where('id',$child->id)->value('target');
              $child->type = menuitem::where('id',$child->id)->value('type');
            }
          }
        }
      }else{
        $menuitems = menuitem::where('menu_id',$desiredMenu->id)->get();
      }
    }else{
      $desiredMenu = menu::orderby('id','DESC')->first();
      if($desiredMenu){
        if($desiredMenu->content != ''){
          $menuitems = json_decode($desiredMenu->content);
          $menuitems = $menuitems[0];
          foreach($menuitems as $menu){
            $menu->title = menuitem::where('id',$menu->id)->value('title');
            $menu->name = menuitem::where('id',$menu->id)->value('name');
            $menu->slug = menuitem::where('id',$menu->id)->value('slug');
            $menu->target = menuitem::where('id',$menu->id)->value('target');
            $menu->type = menuitem::where('id',$menu->id)->value('type');
            if(!empty($menu->children[0])){
              foreach ($menu->children[0] as $child) {
                $child->title = menuitem::where('id',$child->id)->value('title');
                $child->name = menuitem::where('id',$child->id)->value('name');
                $child->slug = menuitem::where('id',$child->id)->value('slug');
                $child->target = menuitem::where('id',$child->id)->value('target');
                $child->type = menuitem::where('id',$child->id)->value('type');
              }
            }
          }
        }else{
          $menuitems = menuitem::where('menu_id',$desiredMenu->id)->get();
        }
      }
    }



$data['categories']   = categories::all();
$data['posts']   = webPage::all();
$data['menus'] = menu::all();
$data['desiredMenu'] =$desiredMenu;
$data['menuitems'] =$menuitems;





return view('user.dynamic_menu',$data);
}




public function store(Request $request)
{
  $data = $request->all();
  if(menu::create($data)){
    $newdata = menu::orderby('id','DESC')->first();
    session::flash('success','Menu saved successfully !');
      return redirect("manage-menus?id=$newdata->id");
  }else{
    return redirect()->back()->with('error','Failed to save menu !');
  }
}
















  public function addCatToMenu(Request $request){
    $data = $request->all();
    $menuid = $request->menuid;
    $ids = $request->ids;
    $menu = menu::findOrFail($menuid);
    if($menu->content == ''){
      foreach($ids as $id){
        $data['title'] = categories::where('id',$id)->value('categories');
        $data['slug'] = categories::where('id',$id)->value('categories_slug');
        $data['type'] = 'category';
        $data['menu_id'] = $menuid;
        $data['updated_at'] = NULL;
        menuitem::create($data);
      }
    }else{
      $olddata = json_decode($menu->content,true);
      foreach($ids as $id){
        $data['title'] = categories::where('id',$id)->value('categories');
        $data['slug'] = categories::where('id',$id)->value('categories_slug');
        $data['type'] = 'category';
        $data['menu_id'] = $menuid;
        $data['updated_at'] = NULL;
        menuitem::create($data);
      }
      foreach($ids as $id){
        $array['title'] = categories::where('id',$id)->value('categories');
        $array['slug'] = categories::where('id',$id)->value('categories_slug');
        $array['name'] = NULL;
        $array['type'] = 'category';
        $array['target'] = NULL;
        $array['id'] = menuitem::where('slug',$array['slug'])->where('name',$array['name'])->where('type',$array['type'])->value('id');
        $array['children'] = [[]];
        array_push($olddata[0],$array);
        $oldata = json_encode($olddata);
        $menu->update(['content'=>$olddata]);
      }
    }
  }

  public function addPostToMenu(Request $request){
    $data = $request->all();
    $menuid = $request->menuid;
    $ids = $request->ids;
    $menu = menu::findOrFail($menuid);
    if($menu->content == ''){
      foreach($ids as $id){
        $data['title'] = webPage::where('id',$id)->value('page_title');
        $data['slug'] = webPage::where('id',$id)->value('slug');
        $data['type'] = 'post';
        $data['menu_id'] = $menuid;
        $data['updated_at'] = NULL;
        menuitem::create($data);
      }
    }else{
      $olddata = json_decode($menu->content,true);
      foreach($ids as $id){
        $data['title'] = webPage::where('id',$id)->value('page_title');
        $data['slug'] = webPage::where('id',$id)->value('slug');
        $data['type'] = 'post';
        $data['menu_id'] = $menuid;
        $data['updated_at'] = NULL;
        menuitem::create($data);
      }
      foreach($ids as $id){
        $array['title'] = webPage::where('id',$id)->value('page_title');
        $array['slug'] = webPage::where('id',$id)->value('slug');
        $array['name'] = NULL;
        $array['type'] = 'post';
        $array['target'] = NULL;
        $array['id'] = menuitem::where('slug',$array['slug'])->where('name',$array['name'])->where('type',$array['type'])->orderby('id','DESC')->value('id');
        $array['children'] = [[]];
        array_push($olddata[0],$array);
        $oldata = json_encode($olddata);
        $menu->update(['content'=>$olddata]);
      }
    }
  }

  public function addCustomLink(Request $request){
    $data = $request->all();
    $menuid = $request->menuid;
    $menu = menu::findOrFail($menuid);
    if($menu->content == ''){
      $data['title'] = $request->link;
      $data['slug'] = $request->url;
      $data['type'] = 'custom';
      $data['menu_id'] = $menuid;
      $data['updated_at'] = NULL;
      menuitem::create($data);
    }else{
      $olddata = json_decode($menu->content,true);
      $data['title'] = $request->link;
      $data['slug'] = $request->url;
      $data['type'] = 'custom';
      $data['menu_id'] = $menuid;
      $data['updated_at'] = NULL;
      menuitem::create($data);
      $array = [];
      $array['title'] = $request->link;
      $array['slug'] = $request->url;
      $array['name'] = NULL;
      $array['type'] = 'custom';
      $array['target'] = NULL;
      $array['id'] = menuitem::where('slug',$array['slug'])->where('name',$array['name'])->where('type',$array['type'])->orderby('id','DESC')->value('id');
      $array['children'] = [[]];
      array_push($olddata[0],$array);
      $oldata = json_encode($olddata);
      $menu->update(['content'=>$olddata]);
    }
  }






































  public function updateMenu(Request $request){
    $newdata = $request->all();
    $menu=menu::findOrFail($request->menuid);
    $content = $request->data;
    $newdata = [];
    $newdata['location'] = $request->location;
    $newdata['content'] = json_encode($content);
    $menu->update($newdata);
  }







  public function updateMenuItem(Request $request){
    $data = $request->all();
    $item = menuitem::findOrFail($request->id);
    $item->update($data);
    return redirect()->back();
  }

  public function deleteMenuItem($id,$key,$in=''){
    $menuitem = menuitem::findOrFail($id);
    $menu = menu::where('id',$menuitem->menu_id)->first();
    if($menu->content != ''){
      $data = json_decode($menu->content,true);
      $maindata = $data[0];
      if($in == ''){
        unset($data[0][$key]);
        $newdata = json_encode($data);
        $menu->update(['content'=>$newdata]);
      }else{
          unset($data[0][$key]['children'][0][$in]);
          $newdata = json_encode($data);
        $menu->update(['content'=>$newdata]);
      }
    }
    $menuitem->delete();
    return redirect()->back();
  }




  public function destroy(Request $request)
{
  menuitem::where('menu_id',$request->id)->delete();
  menu::findOrFail($request->id)->delete();
  return redirect('manage-menus')->with('success','Menu deleted successfully');
}








}
