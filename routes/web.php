<?php

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

// Route::get('/', function () {
// });
Route::get('/', 'RegisterController@home_route');
Route::get('/landing', 'RegisterController@landing_route');
Route::get('skill_search/','RegisterController@skill_search_route');
Route::get('/register','RegisterController@register_route');
Route::get('/login','RegisterController@login_route');
Route::get('/view_people','RegisterController@people_route');
Route::get('/contact','RegisterController@contact_route');
// Route::get('/index', function () {
//     return view('index');
// });
Route::get('/edit', function () {
    return view('user_profile.update');
});
Route::get('profile', function () {
    return view('user_profile.view');
});


Route::post('create_r', 'RegisterController@store');
Route::post('Account/login', 'RegisterController@login');
Route::get('people', 'RegisterController@index');
Route::get('edit/{id}', 'RegisterController@edit');
Route::post('update/{id}', 'RegisterController@update');
Route::post('updateProfile', 'RegisterController@updateProfile');


Route::get('profile_view/{id}', 'RegisterController@show');
Route::get('profile_view_other/{id}', 'RegisterController@show_other');
Route::get('logout', 'RegisterController@logout');
Route::post('upload', 'RegisterController@Upload');
Route::post('imageUpload/{id}', 'RegisterController@imageUpload');
Route::post('coverUpload/{id}', 'RegisterController@coverUpload');
// Route::get('skill_search/{skill}', 'RegisterController@showdata');
Route::get('search', 'RegisterController@search');

Route::post('changepwd/{id}', 'RegisterController@changePassword');
 Route::post('sendemail', 'RegisterController@ship');
Route::post('contact', 'RegisterController@contact');
Route::post('change/contact/{id}', 'RegisterController@contactUpdate');
Route::get('verify_account/{token}', 'RegisterController@change_status');

Route::get('/user/hire/{id}', 'RegisterController@user_hire');
Route::get('show_hire_provider', 'RegisterController@show_provider');
Route::post('/user/rating', 'RegisterController@user_rating');
Route::post('gallery_imgUpload', 'RegisterController@gallery_imageUpload');
Route::post('/show_rating/{id}', 'RegisterController@rating_home');
Route::post('/user/hiring', 'RegisterController@user_hiring');
Route::post('/provider/work', 'RegisterController@start_work');
Route::post('/provider/cancel_work', 'RegisterController@cancel_work');
Route::post('/provider/end_work', 'RegisterController@end_work');
Route::get('/change_password', 'RegisterController@password_route');
Route::post('change_pwd', 'RegisterController@PasswordChange');





//Admin

Route::get('/admin/dashboard', 'frontend\Admin@admin_dashboard_route');
// Route::get('/admin/dashboard', function () {
//     return view('admin.admin_account.dashboard');
// });
Route::get('/admin/user', 'frontend\Admin@show_user');
Route::get('/admin/categories', 'frontend\Admin@show_categories');
Route::get('/admin/editUser/{w_id}', 'frontend\Admin@admin_edit_route');
Route::post('edit_user', 'frontend\Admin@admin_edit_user');
Route::get('/admin/creatUser', 'frontend\Admin@admin_create_route');
Route::get('delete_user/{id}', 'frontend\Admin@admin_delete_user');
Route::get('admin_verify_account/{token}', 'frontend\Admin@change_status_admin');
Route::get('/admin/add_category', 'frontend\Admin@admin_add_category_route');
Route::get('/admin/editCategory/{w_id}', 'frontend\Admin@admin_editCategory_route');
Route::post('edit_category', 'frontend\Admin@admin_edit_category');
Route::get('delete_category/{s_id}', 'frontend\Admin@admin_delete_category');
