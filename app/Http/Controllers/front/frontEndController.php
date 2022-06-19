<?php

namespace App\Http\Controllers\front;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\webPage;
use phpDocumentor\Reflection\Types\Void_;
use Spatie\MediaLibrary\MediaCollections\Models\Media;
use App\Models\homeBanner;
use App\Models\categories;
use App\Helpers\CustomBackEnd;
use App\Helpers\regularModules;
use App\Models\homeSection;
use App\Models\CategoryHasPost;
use App\Models\comment;
use App\Models\replay;
use App\Models\postViewCount;
use App\Models\album;
use App\Models\mediaFile;

class frontEndController extends Controller
{


    function index()
    {
        $data['banner'] = homeBanner::where(['status' => 1])->get();
        $data['home_section'] = homeSection::orderBy('order', 'asc')->get();
        $data['categories'] = categories::where(['is_home' => 1])->where(['status' => 1])->get();
        $data['get_post'] = get_post();
        $data['get_latest_post'] =get_latest_post(3);
        $data['get_latest_post_two'] = webPage::join('category_has_posts', 'category_has_posts.post_id', '=', 'web_pages.id')
            ->join('categories', 'categories.id', '=', 'category_has_posts.category_id')
            ->join('users', 'users.id', 'web_pages.published_author_id')
            ->select([
                'web_pages.*',
                'categories.id as categories_id',
                'categories.categories',
                'categories.categories_slug',
                'categories.link as category_link',
                'users.name as publisher',
                'users.avatar'
            ])->where(['web_pages.is_deleted' => null])->where(['web_pages.status' => 1])
           ->groupBy('category_has_posts.post_id')
            ->orderBy('updated_at', 'desc')->skip(3)->take(3)->get();

        $data['get_trending_posts'] = get_trending_posts(5);
       foreach ($data['categories'] as $categories_data) {
            $data['post_with_categories'][$categories_data->id] =
                webPage::join('users', 'users.id', 'web_pages.published_author_id')
                ->join('category_has_posts', 'category_has_posts.post_id', '=', 'web_pages.id')
                ->join('categories', 'categories.id', '=', 'category_has_posts.category_id')
                ->select([
                    'web_pages.*',
                    'categories.id as categories_id',
                    'categories.categories',
                    'categories.categories_slug',
                    'categories.link as category_link',
                    'users.name as publisher',
                    'users.avatar'
                ])->where(['web_pages.is_deleted' => null])->where(['web_pages.status' => 1])
                ->where(['categories.id' => $categories_data->id])
                ->orderBy('updated_at', 'desc')
                ->get();
        }

    return view('frontend.home', $data);
    }


    function dashboard()
    {
        if (Auth::check()) {
            return view('user.dashboard');
        } else {
            return  redirect('/');
        }
    }



    function register()
    {
        return view('frontend.home');
    }







    function web_pages($url)
    {

        if (!empty($url)) {
            $data['get_page'] = webPage::where(['link' => $url])->get();

            return view('frontend.web', $data);
        }
    }

    function category_get(Request $request)
    {



        $data['categories'] = categories::where(['categories.status' => 1])
            ->whereRaw('concat(categories," ",categories_slug) like ?', "%{$request->data}%")
            ->get();

        foreach ($data['categories'] as  $categories_data) {

            $html_data[] = '<input type="checkbox" id="option-category-1"  name="categories[]" value="' . $categories_data->id . '" >' . $categories_data->categories . '</label><br>';
        }

        return response()->json(['html' => $html_data]);
    }




function single_blog_page($category,$pageUrl){
    if(empty($category) && empty($pageUrl)){
        return back();
    }else{



          $get_category= categories::where(['link'=>$category])->get();
        if(!empty($get_category[0])){
              $category_id = $get_category[0]->id;
             $get_page_id =  webPage::where(['link'=>$pageUrl])->get();


           if(!empty($get_page_id[0])){
            $data['post_id'] = $get_page_id[0]->id;
             $data['comments'] = comment::where(['post_id'=>$data['post_id'] ])->get();
             foreach($data['comments'] as $comments_data){
                 $data['replays'][$comments_data->id] = replay::join('users','users.id','replays.user_id')
                 ->select(['replays.*','users.name','users.avatar'])
                 ->where(['comment_id'=>$comments_data->id])
                 ->get();
             }





            $page_id = $get_page_id[0]->id;
              $data['get_single_post'] = webPage::join('users', 'users.id', 'web_pages.published_author_id')
            ->join('category_has_posts', 'category_has_posts.post_id', '=', 'web_pages.id')
            ->join('categories', 'categories.id', '=', 'category_has_posts.category_id')
            ->select([
                'web_pages.*',
                'categories.id as categories_id',
                'categories.categories',
                'categories.categories_slug',
                 'categories.link as category_link',
                'users.name as publisher',
                'users.avatar'
            ])
            ->where(['web_pages.is_deleted' => null])->where(['web_pages.status' => 1])
            ->where(['categories.id' => $category_id])
            ->where(['web_pages.id' => $page_id])
            ->get();

            $post = webPage::find($page_id);
             views($post)->record();
            $views_count =  views($post)->count();
             $check_post_exist = postViewCount::where(['post_id'=>$page_id])->get();
             if(!empty($check_post_exist[0])){
                 $count_id = $check_post_exist[0]->id;
                 $save_count =   postViewCount::find($count_id);
             }else{
                 $save_count = new  postViewCount();
             }
             $save_count->count = $views_count;
             $save_count->post_id = $page_id;
             $save_count->save();



            $data['get_latest_post'] = get_latest_post(10);
            $data['get_trending_posts'] = get_trending_posts(10);
            $data['categories'] = categories::where(['status'=>1])->get();
            $data['get_post'] = get_post();


            return view('frontend.single_blog_page',$data);
            }else{
            return back();

           }

        }else{
            return back();

           }



    }
}



function category($url){


    if (!empty($url)) {
        $category = categories::where(['link'=>$url])->get();
        if (!empty($category[0])) {
            $category_id = $category[0]->id;
            $type = $category[0]->type;
            if($type==='gallery'){

                $data['album'] = album::where(['menu_id'=>$category_id])->get();
                $data['category'] = $url;


            }else{


                $data['post_by_category'] =   webPage::join('category_has_posts', 'category_has_posts.post_id', '=', 'web_pages.id')
                ->join('categories', 'categories.id', '=', 'category_has_posts.category_id')
                ->join('users', 'users.id', 'web_pages.published_author_id')
                ->select([
                    'web_pages.*',
                    'categories.id as categories_id',
                    'categories.categories',
                    'categories.categories_slug',
                    'categories.keywords as cat_keywords',
                    'categories.description as cat_description',
                    'categories.link as category_link',
                    'users.name as publisher',
                    'users.avatar'
                ])
                ->where(['web_pages.is_deleted' => null])->where(['web_pages.status' => 1])
                ->where(['categories.id'=>$category_id])
                ->paginate(20);

            }


            return view('frontend.category', $data);
        }else{
            return back();
        }
    }else{
       return redirect('/');
    }
}



function search(Request $request){

    $q =  $request->get('q');

    $data['search'] =   webPage::join('category_has_posts', 'category_has_posts.post_id', '=', 'web_pages.id')
      ->join('categories', 'categories.id', '=', 'category_has_posts.category_id')
      ->join('users', 'users.id', 'web_pages.published_author_id')
      ->select([
          'web_pages.*',
          'categories.id as categories_id',
          'categories.categories',
          'categories.categories_slug',
          'categories.link as category_link',
          'users.name as publisher',
          'users.avatar'
      ])->where(['web_pages.is_deleted' => null])->where(['web_pages.status' => 1])
      ->Where(function ($query) use ($q) {
        $query->orWhere('web_pages.page_name', 'like', '%'.$q.'%')
              ->orWhere('web_pages.page_title', 'like', '%'.$q.'%')
              ->orWhere('web_pages.page_description', 'like', '%'.$q.'%')
              ->orWhere('users.name', 'like', '%'.$q.'%')
              ->orWhere('categories.link', 'like', '%'.$q.'%');
    })->paginate(20);



    return view('frontend.search',$data);

}
function gallery_page($category,$page_url){

    if (!empty($category)&& !empty($page_url)) {

        $data['gallery_files'] = mediaFile::join('albums','albums.id','=','media_files.album_id')
        ->select(['media_files.*','albums.name','albums.description'])
        ->where(['albums.link'=>$page_url])
        ->get();

        return view('frontend.gallery',$data);
    }

}

}
