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

Route::get('/', function () {
    return view('welcome');
});
//Route::get('/hello', function () {
//    return 'My Laravel!';
//});

/*
 * 小米商城前台
*/
Route::get('/index','Mi\IndexController@index');        //  首页

Route::get('/login','Mi\UserController@login');         //  登录页
Route::post('/doLogin','Mi\UserController@doLogin');    //  登录

Route::get('/logout','Mi\UserController@logout');      //  退出登录

Route::get('/register','Mi\UserController@register');   //  注册页
Route::post('/regist','Mi\UserController@regist');      //  注册

Route::get('/cart','Mi\CartController@cart');      //  购物车

Route::get('/list','Mi\IndexController@list');      //  列表页

Route::get('/order','Mi\CartController@order');      //  订单

Route::get('/self','Mi\UserController@self');      //  个人信息页

Route::post('/checkName','Mi\UserController@checkName');      //  验证用户名唯一性

Route::get('/detail','Mi\IndexController@detail');      //  详情页

Route::get('/turn','Mi\TurnController@turn');      //  详情页

Route::get('/prompt','Mi\TurnController@turn');     // 跳转提示信息




/*
 * 小米商城后台
*/

//Auth::routes();

//Route::get('/home', 'HomeController@index')->name('home');

Route::get('/admin/login', 'Admin\AdminController@login');
Route::post('/admin/doLogin', 'Admin\AdminController@doLogin');

/*
 * 利用中间件防止非法进入管理后台
 */
Route::group(['middleware' => ['login'],'namespace' => 'Admin','prefix' => '/admin'], function (){
    Route::get('/','IndexController@index');

    Route::get('/register', 'AdminController@register');
    Route::post('/regist', 'AdminController@regist');

    Route::post('/logout', 'AdminController@logout');
    Route::get('/list', 'AdminController@list');
    Route::get('/add', 'AdminController@add');
    Route::post('/doAdd', 'AdminController@doAdd');
    Route::post('/freeze', 'AdminController@freeze');
    Route::get('/update/user_id/{user_id}', 'AdminController@update');
    Route::post('/doUpdate/', 'AdminController@doUpdate');
    Route::get('/admindetail/user_id/{user_id}', 'AdminController@adminDetail');
    Route::get('/roleforadmin/user_id/{user_id}', 'AdminController@roleForAdmin');
    Route::post('/doRoleForUser', 'AdminController@doRoleForAdmin');

    Route::get('/rolelist', 'AdminController@roleList');
    Route::get('/delrole/role_id/{role_id}', 'AdminController@delRole');
    Route::get('/addrole', 'AdminController@addRole');
    Route::post('/doAddRole', 'AdminController@doAddRole');
    Route::get('/detail/role_id/{role_id}', 'AdminController@roleDetail');
    Route::post('/doupdaterole', 'AdminController@doUpdateRole');
    Route::get('/updaterole/role_id/{role_id}', 'AdminController@updateRole');

    Route::get('/menulist', 'AdminController@menuList');
    Route::get('/updatemenu/menu_id/{menu_id}', 'AdminController@updateMenu');
    Route::post('/doUpdateMenu', 'AdminController@doUpdateMenu');
    Route::get('/delmenu/menu_id/{menu_id}', 'AdminController@delMenu');
    Route::get('/addmenu', 'AdminController@addMenu');
    Route::post('/doAddMenu', 'AdminController@doAddMenu');

    Route::get('/buttonlist', 'AdminController@buttonList');
    Route::get('/delbutton/button_id/{button_id}', 'AdminController@delButton');
    Route::get('/addbutton', 'AdminController@addButton');
    Route::post('/doAddButton', 'AdminController@doAddButton');
    Route::get('/updatebutton/button_id/{button_id}', 'AdminController@updateButton');
    Route::post('/doUpdateButton', 'AdminController@doUpdateButton');
});

