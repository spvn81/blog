<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\user\userController;
use App\Http\Controllers\user\CategoriesController;
use App\Http\Controllers\front\frontEndController;
use App\Http\Controllers\user\rolesAndPermissionsController;
use App\Http\Controllers\user\webController;
use App\Http\Controllers\menuController;
use App\Models\menu;
use App\Http\Controllers\user\onlineClassCategoryController;
use App\Http\Controllers\user\bannerController;
use App\Http\Controllers\AppInfoController;
use App\Http\Controllers\EmailConfigurationController;
use Illuminate\Support\Facades\Artisan;
use Spatie\Permission\Contracts\Role;
use App\Http\Controllers\CommentsController;
use App\Http\Controllers\fileManager;


/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/




Route::get('/foo', function () {
    Artisan::call('storage:link');
});




Route::group(['middleware' => ['permission:menu']], function () {
    Route::get('menu', [menuController::class, 'menu']);
    Route::get('manage-menus/{id?}', [menuController::class, 'dynamic_menu']);
    Route::post('create-menu',[menuController::class,'store']);
    Route::get('add-categories-to-menu',[menuController::class,'addCatToMenu']);
    Route::get('add-post-to-menu',[menuController::class,'addPostToMenu']);
    Route::get('add-custom-link',[menuController::class,'addCustomLink']);
    Route::get('update-menu',[menuController::class,'updateMenu']);
    Route::post('update-menuitem/{id}',[menuController::class,'updateMenuItem']);
    Route::get('delete-menuitem/{id}/{key}/{in?}',[menuController::class,'deleteMenuItem']);
    Route::get('delete-menu/{id}',[menuController::class,'destroy']);





});
Route::group(['middleware' => ['permission:edit_menu']], function () {
    Route::get('manage-menu', [menuController::class, 'manage_menu']);
    Route::get('manage-menu/{id}', [menuController::class, 'manage_menu']);
    Route::post('manage-menu/process', [menuController::class, 'manage_menu_process']);
});

Route::group(['middleware' => ['permission:create_page']], function () {
    Route::get('page', [webController::class, 'page']);
});


Route::group(['middleware' => ['permission:manage_page']], function () {
    Route::get('manage-page', [webController::class, 'manage_page']);
    Route::get('manage-page/{id}', [webController::class, 'manage_page']);
    Route::post('manage-page/process', [webController::class, 'manage_page_process']);
    Route::post('page/delete', [webController::class, 'page_delete']);
    Route::post('manage-page-image/delete', [webController::class, 'manage_page_image_delete']);
     Route::post('/upload-files/editor',[webController::class,'upload_files_editor']);

     Route::any('/ckfinder/connector', '\CKSource\CKFinderBridge\Controller\CKFinderController@requestAction')
     ->name('ckfinder_connector');

 Route::any('/ckfinder/browser', '\CKSource\CKFinderBridge\Controller\CKFinderController@browserAction')
     ->name('ckfinder_browser');

});

Route::group(['middleware' => ['permission:manage_banner']], function () {
    Route::get('banner', [bannerController::class, 'banner']);
    Route::get('manage-banner', [bannerController::class, 'manage_banner']);
    Route::get('manage-banner/{id}', [bannerController::class, 'manage_banner']);
    Route::post('manage-banner/process', [bannerController::class, 'manage_banner_process']);
    Route::post('banner/delete', [bannerController::class, 'banner_delete']);

});

Route::group(['middleware' => ['permission:manage_home']], function () {
    Route::get('manage-home', [webController::class, 'manage_home']);
    Route::get('manage-home/{id}', [webController::class, 'manage_home']);
    Route::get('home', [webController::class, 'home']);
    Route::post('manage-home/process', [webController::class, 'manage_home_process']);
    Route::post('home/delete', [webController::class, 'home_delete']);
});

Route::group(['middleware' => ['permission:dashboard']], function () {
    Route::get('dashboard', [userController::class, 'dashboard']);
});




Route::get('/login/web', [userController::class, 'login'])->name('login');
Route::get('forgot-password', [userController::class, 'forgot_password']);
Route::post('send-otp', [userController::class, 'send_otp']);
Route::get('reset-password/{str}', [userController::class, 'reset_password']);
Route::get('/', [frontEndController::class, 'index']);
Route::get('/register-user', [frontEndController::class, 'register']);
Route::post('register', [userController::class, 'register']);
Route::post('user-update', [userController::class, 'user_update']);

Route::get('/', [frontEndController::class, 'index']);
Route::get('verify/{str}', [userController::class, 'verify']);
Route::post('verified/{str}', [userController::class, 'verified']);
Route::post('auth', [userController::class, 'uerLogin']);
Route::post('reset-password-submit', [userController::class, 'reset_password_submit']);
Route::get('/package-info/{str}', [frontEndController::class, 'package_info']);
Route::get('/all-course-category', [frontEndController::class, 'all_course_category']);
Route::post('packages/get', [frontEndController::class, 'packages_get']);
Route::post('category/get', [frontEndController::class, 'category_get']);
Route::get('/trigger_event', [frontEndController::class, 'trigger_event']);


Route::get('404', function () {

    return view('404');
});
Route::get('505', function () {
    return view('505');
});


Route::get('authorized', function () {
    return view('authorized');
});


Route::group(['middleware' => ['permission:manage_footer']], function () {
    Route::get('manage-footer', [webController::class, 'manage_footer']);
    Route::post('manage-footer/process', [webController::class, 'manage_footer_process']);
    Route::get('add-footer-links', [webController::class, 'add_footer_links']);
    Route::get('add-footer-links/{id}', [webController::class, 'add_footer_links']);
    Route::post('add-footer-links/process', [webController::class, 'add_footer_links_process']);
    Route::post('add-footer-links-title-delete', [webController::class, 'add_footer_links_title_delete']);
    Route::get('footer-links/{title_id}', [webController::class, 'footer_links']);
    Route::get('footer-links/{title_id}/{id}', [webController::class, 'footer_links']);
    Route::post('footer-links/process', [webController::class, 'footer_links_process']);
    Route::post('add-footer-links-delete', [webController::class, 'add_footer_links_delete']);
    Route::get('add-social-links', [webController::class, 'add_social_links']);
    Route::get('add-social-links/{id}', [webController::class, 'add_social_links']);
    Route::post('add-social-links/process', [webController::class, 'add_social_links_process']);
    Route::post('add-social-links-delete', [webController::class, 'add_social_links_delete']);
});


Route::group(['middleware' => ['permission:categories']], function () {
    Route::get('categories', [CategoriesController::class, 'categories']);
});



Route::group(['middleware' => ['permission:create_online_class_category']], function () {
    Route::get('online-class-category', [onlineClassCategoryController::class, 'categories']);
});



Route::group(['middleware' => ['permission:edit_categories']], function () {
    Route::get('manage-category', [CategoriesController::class, 'manage_category']);
    Route::get('manage-category/{id}', [CategoriesController::class, 'manage_category']);
    Route::post('manage-category/process', [CategoriesController::class, 'manage_category_process']);
});



Route::group(['middleware' => ['permission:app_settings']], function () {
    Route::get('app-settings', [AppInfoController::class, 'app_settings']);
    Route::post('app-settings/process', [AppInfoController::class, 'app_settings_process']);
});


Route::group(['middleware' => ['permission:email_configs']], function () {
    Route::get('email-configs', [EmailConfigurationController::class, 'email_configs']);
    Route::post('/email-configs/process', [EmailConfigurationController::class, 'email_configs_process']);
    Route::get('test-mail', [EmailConfigurationController::class, 'test_mail']);
    Route::post('/send-email', [EmailConfigurationController::class, 'sendEmail']);
});



Route::group(['middleware' => ['permission:delete_menu']], function () {
    Route::post('/menu/delete', [menuController::class, 'menu_delete']);
});


Route::group(['middleware' => ['permission:categories_update_status']], function () {
    Route::get('categories/status/{id}/{changed_status}', [CategoriesController::class, 'categories_status']);
});

Route::group(['middleware' => ['permission:delete_categories']], function () {
    Route::get('manage-category/delete/{id}', [CategoriesController::class, 'manage_category_delete']);
    Route::post('categories/delete', [CategoriesController::class, 'categories_delete']);
});


Route::group(['middleware' => ['permission:users|create_users']], function () {
    Route::get('create-user', [userController::class, 'users']);
});

Route::group(['middleware' => ['permission:create_users|update_user']], function () {
    Route::get('manage-user', [userController::class, 'manage_user']);
    Route::get('manage-user/{id}', [userController::class, 'manage_user']);
    Route::get('manage-user/status/{id}/{changed_status}', [userController::class, 'user_status']);
    Route::get('manage-user/status-image/{id}/{changed_status}/{uid}', [userController::class, 'user_status_profile_pic']);
});

Route::group(['middleware' => ['permission:delete_user']], function () {
    Route::post('create-user/delete', [userController::class, 'user_delete']);
});





Route::group(['middleware' => ['permission:roles_and_permissions|edit_roles|delete_roles|create_roles']], function () {
    Route::get('create-roles', [rolesAndPermissionsController::class, 'create_roles']);
    Route::get('manage-roles', [rolesAndPermissionsController::class, 'manage_roles']);
    Route::get('manage-roles/{id}', [rolesAndPermissionsController::class, 'manage_roles']);
    Route::post('manage-role/process', [rolesAndPermissionsController::class, 'manage_role_process']);
    Route::get('create-roles/status/{id}/{changed_status}', [rolesAndPermissionsController::class, 'categories_status']);
    Route::post('create-roles/delete', [rolesAndPermissionsController::class, 'role_delete']);
});



Route::group(['middleware' => ['permission:permissions|edit_permissions|delete_permissions|update_permissions']], function () {
    Route::get('role-permissions', [rolesAndPermissionsController::class, 'role_permissions']);
    Route::get('role-permissions/{id}', [rolesAndPermissionsController::class, 'role_permissions']);
    Route::post('permissions-role/process', [rolesAndPermissionsController::class, 'permissions_role_process']);
    Route::post('role-permissions/delete', [rolesAndPermissionsController::class, 'role_permissions_delete']);
});




Route::group(['middleware' => 'auth'], function () {
    Route::get('settings', [userController::class, 'settings']);
    Route::get('my-account', [userController::class, 'my_account']);
    Route::post('submit-mobile-number/process', [userController::class, 'submit_mobile_number_process']);
    Route::get('logout', [userController::class, 'logout']);
});


Route::group(['middleware' => ['permission:user_comments']], function () {
    Route::get('user-comments',[CommentsController::class,'commentsController']);
    Route::get('user-comments-reply/{id}',[CommentsController::class,'user_comments_reply']);
    Route::post('user-comments-reply/send',[CommentsController::class,'user_comments_reply_send']);
    Route::post('user-comments/delete',[CommentsController::class,'user_comments_delete']);


});


Route::group(['middleware' => ['permission:file_manager']], function () {
Route::get('/albums', [fileManager::class, 'index']);
Route::get('/manage-album', [fileManager::class, 'manage_album']);
Route::get('/manage-album/edit/{id}', [fileManager::class, 'manage_album']);
Route::post('/manage-album/save', [fileManager::class, 'myadm_manage_album_save']);
Route::get('/manage-album/upload/{id}', [fileManager::class, 'manage_album_upload']);
Route::get('/manage-album/upload/album-id/{album_id}/file-id/{file_id}', [fileManager::class, 'manage_album_upload']);
route::post('/manage-album/upload/files/{album_id}/{file_id}', [fileManager::class, 'manage_album_upload_data']);
route::post('//manage-album/upload/first/data/insert/files/{album_id}', [fileManager::class, 'manage_album_upload_data']);
Route::get('/manage-album/view/{id}', [fileManager::class, 'manage_album_view']);
route::post('/manage-album/file/delete', [fileManager::class, 'file_delete']);
route::post('/albums/data/delete', [fileManager::class, 'albums_data_delete']);
Route::get('upload-video/thumbnail/{id}', [fileManager::class, 'upload_video_thumbnail']);
route::post('/upload-video/thumbnail/process', [fileManager::class, 'upload_video_thumbnail_process']);





});






Route::get('{category}/{pageUrl}', [frontEndController::class, 'single_blog_page']);
Route::get('{category}', [frontEndController::class, 'category']);
Route::post('submit-comment/process',[CommentsController::class,'submit_comment']);
Route::get('search/post/data', [frontEndController::class, 'Search']);
Route::get('gallery/{category}/{pageUrl}', [frontEndController::class, 'gallery_page']);



