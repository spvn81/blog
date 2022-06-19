<?php

use App\Models\webPage;
use App\Models\categories;
use App\Models\staticMenu;

function get_latest_post($limit)
{
    return   webPage::join('category_has_posts', 'category_has_posts.post_id', '=', 'web_pages.id')
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
        ])
        ->where(['web_pages.is_deleted' => null])->where(['web_pages.status' => 1])
         ->groupBy('category_has_posts.post_id')
        ->orderBy('updated_at', 'desc')->take($limit)->get();
}




function get_post()
{
    return webPage::join('category_has_posts', 'category_has_posts.post_id', '=', 'web_pages.id')
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
        ])
        ->where(['web_pages.is_deleted' => null])->where(['web_pages.status' => 1])
        ->get();
}


function get_post_tags()
{
    return webPage::join('category_has_posts', 'category_has_posts.post_id', '=', 'web_pages.id')
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
        ])
        ->where(['web_pages.is_deleted' => null])->where(['web_pages.status' => 1])
        ->groupBy('categories_id')
        ->get();
}





function get_tags()
{
    $arr = array();
    $get_post = get_post_tags();
    foreach ($get_post as $get_post_data) {
        $arr[] = $get_post_data;
    }
    return $arr;
}



function get_trending_posts($limit)
{
    return webPage::join('category_has_posts', 'category_has_posts.post_id', '=', 'web_pages.id')
        ->join('categories', 'categories.id', '=', 'category_has_posts.category_id')
        ->join('users', 'users.id', 'web_pages.published_author_id')
        ->join('post_view_counts','post_view_counts.post_id','web_pages.id')
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
        ->orderBy('post_view_counts.count', 'desc')->take($limit)->get();
}



function get_trending_posts_html()
{
    $get_trending_posts = get_trending_posts(10);
    $html = array();
    foreach ($get_trending_posts as $get_trending_posts_data) {
        $html[] = '<div class="post-entry-1 border-bottom">';
        $html[] .= ' <div class="post-meta"><span class="date">' . $get_trending_posts_data->categories . '</span> <span class="mx-1">&bullet;</span> <span>' .
            \Carbon\Carbon::parse($get_trending_posts_data->updated_at)->diffForhumans() . '</span></div><h2 class="mb-2">
    <a href="' . url($get_trending_posts_data->category_link . '/' . $get_trending_posts_data->link) . '">' . $get_trending_posts_data->page_title . '</a></h2><span class="author mb-3 d-block">' . $get_trending_posts_data->publisher . '</span></div>';
    }

    return $html;
}


function get_latest_post_html()
{
    $get_latest_post = get_latest_post(10);
    $html = array();
    foreach ($get_latest_post as $get_latest_post_data) {
        $html[] = '<div class="post-entry-1 border-bottom">';
        $html[] .= ' <div class="post-meta"><span class="date">' . $get_latest_post_data->categories . '</span> <span class="mx-1">&bullet;</span> <span>' .
            \Carbon\Carbon::parse($get_latest_post_data->updated_at)->diffForhumans() . '</span></div><h2 class="mb-2">
    <a href="' . url($get_latest_post_data->category_link . '/' . $get_latest_post_data->link) . '">' . $get_latest_post_data->page_title . '</a></h2><span class="author mb-3 d-block">' . $get_latest_post_data->publisher . '</span></div>';
    }
    return $html;
}

function get_category()
{
    return  $categories = categories::where(['status' => 1])->get();
}






    function getTopNavCat()
    {
        $result= staticMenu::where(['status'=>1])
            ->orderBy('order_by', 'ASC')
            ->get();
        $arr=[];
        foreach ($result as $row) {
            $arr[$row->id]['menu']=$row->menu_name;
            $arr[$row->id]['parent_id']=$row->menu_parent_id;
            $arr[$row->id]['url']=$row->menu_slug;
            $arr[$row->id]['is_data']=$row->is_data;
        }
        $str=buildTreeView($arr, 0);
        return $str;
    }

    $html='';
    function buildTreeView($arr, $parent, $level=0, $pre_level= -1)
    {
        global $html;
        $i=1;
        foreach ($arr as $id=>$data) {
            if ($data['is_data']==1 && $data['parent_id'] != null) {
                $enc_url = urlencode($data['url']);
                $url_store = str_replace('+', '-', $enc_url);
                $drop_down = '';
            } elseif ($data['parent_id'] == null && $data['is_data']==1) {
                $drop_down = '';
                $enc_url = urlencode($data['url']);
                $url_store = str_replace('+', '-', $enc_url);
            } else {
                $url_store ='#';
                $drop_down = 'class="dropdown"';
            }


            if ($parent==$data['parent_id']) {
                if ($level>$pre_level) {
                    if ($html=='') {
                        $html.=' <ul>';
                    } else {
                        $html.='<ul>';
                    }
                }
                if ($level==$pre_level) {
                    $html.='</li>';
                }



                $html.='<li ' .$drop_down.'>
            <a href="'.'/'.$url_store.'"  class="text-capitalize">'.$data['menu'].'</a>';
                if ($level>$pre_level) {
                    $pre_level=$level;
                }
                $level++;
                buildTreeView($arr, $id, $level, $pre_level);
                $level--;
            }
        }
        if ($level==$pre_level) {
            $html.='</li></ul>';
        }
        return $html;
    }

