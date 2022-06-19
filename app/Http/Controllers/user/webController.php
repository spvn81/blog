<?php

namespace App\Http\Controllers\user;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\URL;
use App\Models\menu;
use App\Models\webPage;
use Illuminate\Support\Facades\Validator;
use  Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Storage;
use App\Helpers\uploadFiles;
use App\Models\footer;
use App\Models\footerLinks;
use App\Models\homeSection;
use App\Models\footerLinksTitle;
use Illuminate\Support\Facades\Redis;
use App\Models\socialLinks;
use App\Models\categories;
use App\Models\CategoryHasPost;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Models\postViewCount;


class webController extends Controller
{
    function page()
    {
        $data['page'] = webPage::all();


        foreach($data['page'] as $page_count){
        $data['post_view_count'][$page_count->id] = postViewCount::where(['post_id'=>$page_count->id])->get();
        }


        return view('user.page', $data);
    }


    function manage_page($id = '')
    {

        $data['categories'] = categories::where(['status' => 1])->get();
        $data['user'] = User::where(['user_status'=>1])->get();

        if (!empty($id)) {
            $data['category_id']=CategoryHasPost::join('categories','category_has_posts.category_id','=','categories.id')->join('web_pages','web_pages.id','=','category_has_posts.post_id')
            ->select('category_has_posts.*')
            ->where(['post_id'=>$id])
            ->get();

            $data['page_links'] =
            webPage::join('category_has_posts','category_has_posts.post_id','=','web_pages.id')
            ->join('categories','categories.id','=','category_has_posts.category_id')
           ->select([
            'web_pages.*',
            'categories.id as categories_id',
            'categories.categories',
            'categories.categories_slug',
            'categories.link as category_link',
            ])
            ->where(['web_pages.is_deleted'=>null])->where(['web_pages.status'=>1])
            ->where(['web_pages.id'=>$id])
            ->orderBy('updated_at','desc')
            ->get();




            $data['web_page'] = webPage::find($id);
            $data['id'] = $data['web_page']->id;
            $data['page_name'] = $data['web_page']->page_name;
            $data['page_title'] = $data['web_page']->page_title;
            $data['main_image'] = $data['web_page']->main_image;
            $data['page_description'] = $data['web_page']->page_description;
            $data['small_description'] = $data['web_page']->small_description;
            $data['slug'] = $data['web_page']->slug;
            $data['status'] = $data['web_page']->status;
            $data['published_author_id'] = $data['web_page']->published_author_id;
            $data['post_keywords'] = $data['web_page']->post_keywords;


        } else {
            $data['id'] = '';
            $data['page_name'] = '';
            $data['page_title'] = '';
            $data['main_image'] = '';
            $data['page_description'] = '';
            $data['small_description'] = '';
            $data['slug'] = '';
            $data['category_id'] = '';
            $data['status'] = '';
            $data['published_author_id'] ='';
            $data['page_links'] ='';
            $data['post_keywords'] = '';
        }


        return view('user.manage_page', $data);
    }





    function manage_page_process(Request $request)
    {

        $id = $request->id;

        $validator = validator::make($request->all(), [

            'page_name' => 'required',
            'page_title' => 'required',
            'page_description' => 'required',
            'page_description' => 'required',
            'small_description' => 'required',
            'slug' => "required|regex:/(^[A-Za-z0-9 ]+$)+/|unique:web_pages,slug,$id",
            'main_image' => uploadFiles::image(512),


        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()]);
        } else {

            $description = $request->input('page_description');



            if (!empty($request->id)) {
                $save_data = webPage::find($request->id);
                $status_up ='updated';
            } else {
                $save_data = new webPage();
                $status_up ='saved';

            }



            $url = urlencode(strtolower($request->slug));
            $link =  str_replace('+', '-', $url);
            $category_id = $request->category_id;
            $save_data->page_name = $request->page_name;
            $save_data->page_title = $request->page_title;
            $save_data->page_description = $description;
            $save_data->slug = $request->slug;
            $save_data->link = $link;
            $save_data->post_keywords = $request->post_keywords;



            $save_data->user_id = Auth::user()->id;
            $save_data->published_author_id = $request->published_author_id;
            if ($request->status == 'draft') {
                $status = 0;
            } else {
                $status = 1;
            }

            $save_data->status = $status;
            $save_data->small_description = $request->small_description;
            if($request->published_author_id==''){
                $save_data->published_author_id = Auth::user()->id;

            }else{
                $save_data->published_author_id = $request->published_author_id;

            }

            if ($request->hasFile('main_image')) {
                $file_name =   uploadFiles::uploadFileData($request->file('main_image'), 'uploads');
                $save_data->main_image = uploadFiles::$file_name;
            }
                 $save_data->save();

                $lst_inserted_post_id = $save_data->id;
                CategoryHasPost::where(['post_id' => $lst_inserted_post_id])->delete();

                if(!empty($category_id)){
                foreach ($category_id as $category_id_data) {
                    $save_cat_with_post = new CategoryHasPost();
                    $save_cat_with_post->category_id = $category_id_data;
                    $save_cat_with_post->post_id = $lst_inserted_post_id;
                    $save_cat_with_post->save();
                }

                    }
        return response()->json(['success' => 'page data saved','status'=>$status_up,'url'=>'/manage-page/'.$lst_inserted_post_id]);

        }
    }





    function manage_home_process(Request $request)
    {

        $id = $request->id;
        $validator = validator::make($request->all(), [

            'title' => 'required',
            'description' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()]);
        } else {

            $description = $request->input('description');
            $dom = new \DomDocument();
            libxml_use_internal_errors(true);

            $dom->loadHtml($description, LIBXML_HTML_NOIMPLIED | LIBXML_HTML_NODEFDTD);

            $images = $dom->getElementsByTagName('img');
            foreach ($images as $k => $img) {
                $data = $img->getAttribute('src');
                $pattern = "/;/";
                if (preg_match($pattern, $data)) {
                    list($type, $data) = explode(';', $data);
                    list(, $data)      = explode(',', $data);
                    $data = base64_decode($data);
                    $image_name = "/storage/media/upload/" . time() . $k . '.png';
                    $path = public_path() . $image_name;
                    file_put_contents($path, $data);
                    $img->removeAttribute('src');
                    $img->setAttribute('src', $image_name);
                }
            }


            $description = $dom->saveHTML();
            if (!empty($request->id)) {
                $save_data = homeSection::find($request->id);
            } else {
                $save_data = new homeSection();
            }
            $save_data->title = $request->title;
            $save_data->description = $description;
            $save_data->order = $request->order;
            $save_data->save();
            return response()->json(['success' => 'Home data saved']);
        }
    }






    function page_delete(Request $request)
    {
        $id = $request->post('id');
        $delete_data = webPage::find($id);
        $delete_data->delete();
        return response()->json(['success' => 'deleted', 'msg' => 'page data deleted']);
    }




    function manage_page_image_delete(Request $request)
    {
        $id = $request->post('id');
        $delete_data = webPage::find($id);
        $main_image = $delete_data->main_image;
        Storage::delete('public/' . $main_image);
        $delete_data->main_image = '';
        $delete_data->save();
        return response()->json(['success' => 'deleted', 'msg' => 'page main image deleted']);
    }





    function manage_home($id = '')
    {

        if (!empty($id)) {
            $home_section = homeSection::find($id);
            $data['title'] = $home_section->title;
            $data['description'] = $home_section->description;
            $data['button_name'] = $home_section->button_name;
            $data['link'] = $home_section->link;
            $data['order'] = $home_section->order;
            $data['id'] = $home_section->id;
        } else {

            $data['title'] = '';
            $data['description'] = '';
            $data['button_name'] = '';
            $data['link'] = '';
            $data['order'] = '';
            $data['id'] = '';
        }


        return view('user.manage_home', $data);
    }



    function home()
    {
        $data['home'] = homeSection::all();
        return view('user.home', $data);
    }







    function home_delete(Request $request)
    {
        $id = $request->post('id');
        $delete_data = homeSection::find($id);
        $dom = new \DomDocument();
        libxml_use_internal_errors(true);
        $data = array();
        $dom->loadHtml($delete_data->description, LIBXML_HTML_NOIMPLIED | LIBXML_HTML_NODEFDTD);
        $images = $dom->getElementsByTagName('img');
        foreach ($images as $k => $img) {
            $data[] = $img->getAttribute('src');
        }

        foreach ($data as $images_data) {
            $images_data  =   str_replace('storage', 'public', $images_data);
            Storage::delete($images_data);
        }



        $delete_data->delete();
        return response()->json(['success' => 'deleted', 'msg' => 'Home data deleted']);
    }




    function manage_footer()
    {

        $footer = footer::all();
        if (!empty($footer[0])) {
            $data['footer_description'] = $footer[0]->footer_description;
            $data['copyright_message'] = $footer[0]->copyright_message;
            $data['id'] = $footer[0]->id;
        } else {
            $data['footer_description'] = '';
            $data['copyright_message'] = '';
            $data['id'] = '';
        }

        return view('user.manage_footer', $data);
    }



    function manage_footer_process(Request $request)
    {

        if (!empty($request->id)) {
            $save_data = footer::find($request->id);
        } else {
            $save_data = new footer();
        }
        $save_data->footer_description = $request->footer_description;
        $save_data->copyright_message = $request->copyright_message;
        $save_data->save();
        return response()->json(['success' => 'footer data saved']);
    }


    function add_footer_links($id = '')
    {
        if (!empty($id)) {
            $footer_title = footerLinksTitle::find($id);
            $data['title'] = $footer_title->title;
            $data['id'] = $footer_title->id;
        } else {

            $data['title'] = '';
            $data['id'] = '';
        }
        $data['footer_links_title'] = footerLinksTitle::all();
        return view('user.add_footer_links', $data);
    }





    function add_footer_links_process(Request $request)
    {


        $validator = validator::make($request->all(), [
            'title' => "required|regex:/(^[A-Za-z0-9 ]+$)+/|unique:footer_links_title,title,$request->id",
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()]);
        } else {

            if (!empty($request->id)) {
                $save_data = footerLinksTitle::find($request->id);
            } else {
                $save_data = new footerLinksTitle();
            }
            $save_data->title = $request->title;
            $save_data->save();

            return response()->json(['success' => 'data saved']);
        }
    }







    function add_footer_links_title_delete(Request $request)
    {
        $id = $request->post('id');
        $delete_data = footerLinksTitle::find($id);
        $delete_data->delete();
        return response()->json(['success' => 'deleted', 'msg' => 'footerLinksTitle data deleted']);
    }



    function footer_links($title_id, $id = '')
    {

        if (!empty($id)) {
            $links = footerLinks::find($id);
            if (!empty($links)) {
                $data['name'] = $links->name;
                $data['link'] = $links->link;
                $data['title_id'] = $links->title_id;
                $data['id'] = $links->id;
            } else {
                return redirect('footer-links/' . $title_id);
            }
        } else {
            $data['name'] = '';
            $data['link'] = '';
            $data['title_id'] = '';
            $data['id'] = '';
        }

        $data['footer_links'] = footerLinks::where(['title_id' => $title_id])->get();
        $data['title_id'] = $title_id;

        return view('user.footer_links', $data);
    }








    function footer_links_process(Request $request)
    {


        $validator = validator::make($request->all(), [
            'name' => "required",
            'link' => "required",
            'title_id' => "required",

        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()]);
        } else {

            if (!empty($request->id)) {
                $save_data = footerLinks::find($request->id);
            } else {
                $save_data = new footerLinks();
            }
            $save_data->name = $request->name;
            $save_data->link = $request->link;
            $save_data->title_id  = $request->title_id;
            $save_data->save();

            return response()->json(['success' => 'data saved']);
        }
    }



    function add_footer_links_delete(Request $request)
    {

        $id = $request->post('id');
        $delete_data = footerLinks::find($id);
        $delete_data->delete();
        return response()->json(['success' => 'deleted', 'msg' => 'footerLinks data deleted']);
    }



    function add_social_links($id = '')
    {
        if (!empty($id)) {
            $social_links = socialLinks::find($id);
            $data['fount_awesome_class'] = $social_links->fount_awesome_class;
            $data['link'] = $social_links->link;
            $data['id'] = $social_links->id;
        } else {
            $data['fount_awesome_class'] = '';
            $data['link'] = '';
            $data['id'] = '';
        }

        $data['social_links'] = socialLinks::all();
        return view('user.add_social_links', $data);
    }






    function add_social_links_process(Request $request)
    {


        $validator = validator::make($request->all(), [
            'fount_awesome_class' => "required",
            'link' => "required",

        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()]);
        } else {

            if (!empty($request->id)) {
                $save_data = socialLinks::find($request->id);
            } else {
                $save_data = new socialLinks();
            }
            $save_data->fount_awesome_class = $request->fount_awesome_class;
            $save_data->link = $request->link;

            $save_data->save();

            return response()->json(['success' => 'data saved']);
        }
    }




    function add_social_links_delete(Request $request)
    {
        $id = $request->post('id');
        $delete_data = socialLinks::find($id);
        $delete_data->delete();
        return response()->json(['success' => 'deleted', 'msg' => 'footerLinksTitle data deleted']);
    }




function upload_files_editor(Request $request){


}




}
