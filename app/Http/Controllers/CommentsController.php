<?php

namespace App\Http\Controllers;
use App\Models\comment;
use App\Models\replay;
use App\Models\webPage;
use Illuminate\Support\Facades\Validator;
use Carbon\Carbon;



use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CommentsController extends Controller
{

function submit_comment(Request $request){


    $validator = validator::make($request->all(), [
        'post_id' => 'required',
        'name' => 'required',
        'email' => 'required|email',
        'message' => 'required',
    ]);

    if ($validator->fails()) {
        return response()->json(['errors' => $validator->errors()]);
    } else {
        $post_id = $request->post_id;
        $name = $request->name;
        $email = $request->email;
        $message = $request->message;
        $save_data = new comment();
        $save_data->post_id = $post_id;
        $save_data->name = $name;
        $save_data->email = $email;
        $save_data->message = $message;
        $save_data->save();
    }
}



function commentsController(){



    $data['comments'] =  webPage::join('category_has_posts', 'category_has_posts.post_id', '=', 'web_pages.id')
    ->join('categories', 'categories.id', '=', 'category_has_posts.category_id')
    ->join('users', 'users.id', 'web_pages.published_author_id')
    ->join('comments','comments.post_id','=','category_has_posts.post_id')
    ->select([
        'comments.*',
        'web_pages.link',
        'web_pages.page_name',
        'categories.id as categories_id',
        'categories.categories',
        'categories.categories_slug',
        'categories.link as category_link',
        'users.name as publisher',
        'users.avatar'
    ])
    ->where(['web_pages.is_deleted' => null])->where(['web_pages.status' => 1])
    ->get();


    return view('user.user_comments',$data);
}




function user_comments_reply($id){

$data['comment'] = comment::find($id);
$data['comment']->read_status = Carbon::now()->toDateTimeString();
$data['comment']->save();
 $data['get_replays'] = replay::join('users','users.id','=','replays.user_id')->
select(['replays.*','users.name','users.avatar'])
->where(['comment_id'=>$id])
->get();

return view('user.user_comments_reply',$data);
}




function user_comments_reply_send(Request $request){
    $message = $request->message;
    $comment_id = $request->comment_id;
    $save_data = new replay();
    $save_data->user_id = Auth::user()->id;
    $save_data->comment_id = $comment_id;
    $save_data->message = $message;
    $save_data->save();
    return response()->json(['success' => 'Replay Sent']);

}







function user_comments_delete(Request $request)
{
    $id = $request->post('id');
    $delete_data = comment::find($id);
    $delete_data->delete();
    return response()->json(['success' => 'deleted', 'msg' => 'user comment is deleted']);
}




}
