<?php

namespace App\Helpers;

use App\Models\appInfo;
use App\Models\categories;
use Illuminate\Support\Facades\Session;
use App\Models\menu;

use Illuminate\Support\Facades\Auth;
use App\Models\footer;
use App\Models\footerLinksTitle;
use App\Models\footerLinks;
use Illuminate\Support\Arr;
use App\Models\socialLinks;
use ReturnInfo;

class getApp
{
    public static $appName;
    public static $title;
    public static $sub_title;
    public static $app_url;
    public static $logo;
    public static $favicon;
    public static $created_at;
    public static $description;
    public static $keywords;
    public static $about_page_ink;
    public static $show_logo;
    public static $show_title;


    public static function getAppName()
    {
      $app = appInfo::all();
      if (!empty($app[0])) {
        return  Self::$appName = $app[0]->app_name;
      }
    }





    public static function show_logo()
    {
      $app = appInfo::all();
      if (!empty($app[0])) {
        return  Self::$show_logo = $app[0]->show_logo;
      }
    }


    public static function show_title()
    {
      $app = appInfo::all();
      if (!empty($app[0])) {
        return  Self::$show_title = $app[0]->show_title;
      }
    }






    public static function about_page_ink()
    {
      $app = appInfo::all();
      if (!empty($app[0])) {
        return  Self::$appName = $app[0]->about_page_ink;
      }
    }




    public static function title()
    {
      $app = appInfo::all();
      if (!empty($app[0])) {
        return  Self::$appName = $app[0]->title;
      }
    }



    public static function sub_title()
    {
      $app = appInfo::all();
      if (!empty($app[0])) {
        return    Self::$appName = $app[0]->sub_title;
      }
    }


    public static function app_url()
    {
      $app = appInfo::all();
      if (!empty($app[0])) {
        return    Self::$appName = '/';
      }
    }



    public static function logo()
    {
      $app = appInfo::all();
      if (!empty($app[0])) {
        return  Self::$appName = $app[0]->logo;
      }
    }



    public static function favicon()
    {
      $app = appInfo::all();
      if (!empty($app[0])) {
        return   Self::$appName = $app[0]->favicon;
      }
    }


    public static function description()
    {
      $app = appInfo::all();
      if (!empty($app[0])) {
        return   Self::$appName = $app[0]->description;
      }
    }


    public static function keywords()
    {
      $app = appInfo::all();
      if (!empty($app[0])) {
        return   Self::$appName = $app[0]->keywords;
      }
    }

    public static function about(){
        $app = footer::all();
        if (!empty($app[0])) {
            return   Self::$appName = $app[0]->footer_description;
          }

    }

    public static function copyRight(){
        $app = footer::all();
        if (!empty($app[0])) {
            return   Self::$appName = $app[0]->copyright_message;
        }
    }
    public static function Address(){
        $app = appInfo::all();
        if (!empty($app[0])) {
            return   Self::$appName = $app[0]->address;
        }
    }


    public static function email(){
        $app = appInfo::all();
        if (!empty($app[0])) {
            return   Self::$appName = $app[0]->email;
        }
    }

    public static function phone(){
        $app = appInfo::all();
        if (!empty($app[0])) {
            return   Self::$appName = $app[0]->phone;
        }
    }

    public static function getSocialLinks(){
        return $app = socialLinks::all();

    }



    public static function noMobileNumber(){

    $html = '<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">Enter mobile number</h5>

        </div>
        <div class="modal-body">



            <form id="submit_mobile_number">
              <div class="form-group" >
                <label for="mobilenumber">mobile</label>
                <input type="text" name="mobile_number" max="10" class="form-control" placeholder="Enter 10 digit mobile number">
                  <div id="mobile_number_err" class="text-danger"></div>
              </div>
              <input type="hidden" name="_token" value="'.csrf_token().'" />

              <button type="submit" class="btn btn-primary">Submit</button>
              <a href="'.url('/logout').'"><button type="button" class="btn btn-danger">logout</button></a>

            </form>



        </div>

      </div>
    </div>
  </div>';

  return  $html;

    }




}


class CustomBackEnd
{
    public static function  get_delete($id,$type='')
    {
        return  $html = '<i  type="button" class="far fa-trash-alt text-danger" onclick="delete_data('.$id.','.$type.')"></i>';
    }

    public static function get_status($status, $url)
    {
        if ($status == 1) {
            return  $html = '<a href="' . $url . '/' . "0" . '">
            <i class="fas fa-check-circle text-success"></i></a>';
        } else {
            return  $html = '<a href="' . $url . '/' . "1" . '">
            <i class="far fa-times-circle text-danger"></i></a>';
        }
    }

    public static function getEdit($url)
    {
        return  $html = '<a href="'.$url . '"><i class="fas fa-edit"></i></a>';
    }



    public static function getCategories()
    {
        return categories::where(['status' => 1])->get();
    }



    public  static function  getTopNavCat()
    {
        $result = menu::where(['menu_type'=>'main_menu'])->get();
        foreach ($result as $row) {
            $arr[$row->id]['categories'] = $row->menu_name;
            $arr[$row->id]['parent_cat_id'] = $row->menu_parent_id;
            $arr[$row->id]['url'] = $row->menu_slug;
            $arr[$row->id]['link'] = $row->link;
        }
        $str = CustomBackEnd::buildTreeView($arr, 0);
        return $str;
    }



    public static function  buildTreeView($arr, $parent, $level = 0, $preLevel = -1)
    {
        $html = '';

        global $html;
        $i = 1;
        foreach ($arr as $id => $data) {

            if($data['parent_cat_id']==null && $data['link']==null ){
                $nav_item = 'nav-item dropdown';
                $a_nav_link = 'nav-link';
                $link = '#';

            }elseif($data['parent_cat_id']==null && $data['link'] !=null){
                $nav_item = 'nav-item';
                $a_nav_link = 'nav-link';
                $link = $data['link'];

            }elseif($data['parent_cat_id']!=null && $data['link'] != null){
                $nav_item = 'nav-item';
                $a_nav_link = 'dropdown-item';
                $link = $data['link'];

            }
            if ($parent == $data['parent_cat_id']) {
                if ($level > $preLevel) {

                    if ($html == '') {
                        $html .= ' <ul class="navbar-nav ml-auto">';
                    } else {
                        $html .= '<ul class="dropdown-menu">';
                    }
                }
                if ($level == $preLevel) {
                    $html .= '</li>';
                }

                $html .= '<li class="'.$nav_item.'">
                <a  class="'.$a_nav_link.'   text-uppercase"   href="'.'/'.$link.'"  >' . $data['categories'] . '</a>';
                if ($level > $preLevel) {
                    $preLevel = $level;
                }
                $level++;
                CustomBackEnd::buildTreeView($arr, $id, $level, $preLevel);
                $level--;
            }
        }
        if ($level == $preLevel) {
            $html .= '</li></ul>';
        }
        return $html;
    }




    public static function active_image($status, $url)
    {
        if (!empty($status)) {
            return  $html = '<a href="' . $url . '/' . "0" . '">
            <i class="fas fa-check-circle text-success"></i></a>';
        } else {
            return  $html = '<a href="' . $url . '/' . "1" . '">
            <i class="far fa-times-circle text-danger"></i></a>';
        }
    }





public static function getFooterLinks(){

    $footer_links_title  = footerLinksTitle::all();
    $html = array();
    foreach($footer_links_title as $footer_links_title_data){
        $html[] = '<div class="col-6 col-lg-2">

        <h3 class="footer-heading">'.$footer_links_title_data->title.'</h3>
        <ul class="footer-links list-unstyled">';
            $footer_links = footerLinks::where(['title_id'=>$footer_links_title_data->id])->get();
                foreach($footer_links  as $footer_links_data){
             $html[] .=  '<li><a href="'.url($footer_links_data->link).'" ><i class="bi bi-chevron-right"></i>'.$footer_links_data->name.'</a></li>';
            }

            $html[] .='</ul>

    </div>';

    }

return  $html;

}





}



class uploadFiles
{

    public static function image($max_file_size = '', $req = '')
    {
        if (empty($max_file_size)) {
            return $file_formats = 'mimes: tif,tiff,jpg,jpeg,gif,bmp,png,eps,webp|' . $req . '|max:10000';
        } else {
            return $file_formats = 'mimes: tif,tiff,jpg,jpeg,gif,bmp,png,eps,webp|' . $req . '|max:' . $max_file_size*1024;
        }
    }




    public static function emailFileUploadValidator($max_file_size = '', $req = '')
    {
        if (empty($max_file_size)) {
            return $file_formats = 'mimes: tif,tiff,jpg,jpeg,gif,bmp,png,eps,mp4,pdf,doc,docm,docx,docx,dot,dotm,dotx,htm,html,xml,odt,3gp,mov,zip,xlsx,csv|' . $req . '|max:10000';
        } else {
            return $file_formats = 'mimes: mimes: tif,tiff,jpg,jpeg,gif,bmp,png,eps,mp4,pdf,doc,docm,docx,docx,dot,dotm,dotx,htm,html,xml,odt,3gp,mov,zip,xlsx,csv|' . $req . '|max:' . $max_file_size*1024;
        }
    }




    public static function video($max_file_size, $req = '')
    {
        if (empty($max_file_size)) {
            return $file_formats = 'mimes:  webm,mp4,ogv,mov,3gp,avi,wmv|' . $req . '|max:10000';
        } else {
            return $file_formats = 'mimes: webm,mp4,ogv,mov,3gp,avi,wmv|' . $req . '|max:' . $max_file_size * 1024;
        }
    }

    public  static $file_name;
    public  static $extension;
    public static $file_size;
    public static $original_filename;


    public static function uploadFileData($name, $file_path = '')
    {
        $file = $name;
        if (empty($file_path)) {
            $path = $file->store('/public/media/upload');
            $file_name = pathinfo($path)['basename'];
            self::$file_name = 'upload/' . $file_name;
        } else {
            $path = $file->store('/public/media/' . $file_path);
            $file_name = pathinfo($path)['basename'];
              self::$file_name = $file_path . '/' . $file_name;
        }

            self::$extension = pathinfo($path, PATHINFO_EXTENSION);
            $size = filesize($name);
            $kb = $size/1024;
            self::$file_size = round($kb/1024,2).' MB';
            self::$original_filename =  $name->getClientOriginalName();





    }





}

class regularModules
{
    public static function defaultNotification($color = '')
    {
        $html = '';
        if (Session::has('message')) {
            $html .=  '<div class="alert alert-' . $color . ' alert-dismissible fade show text-capitalize" role="alert">
            <strong>';
            $html .=  Session::get('message');
            $html .= '</strong><button type="button" class="close" data-dismiss="alert" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>';
            return  $html;
        }
    }

    public static function convertSlugIntoUrl($str)
    {
        $slug = urlencode($str);
        return str_replace('+', '-', $slug);
    }



}


