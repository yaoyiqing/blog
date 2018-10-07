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
//Route::get('/index', 'Index\IndexController@hello');
//Route::get('/test', 'Test\TestController@select');
//Route::get('/add', 'Test\TestController@add');
//Route::get('/del', 'Test\TestController@del');
//Route::get('/update', 'Test\TestController@update');

//Route::get('/index', 'Test\TestController@index');
//Route::post('/insert', 'Test\TestController@insert');

/*
 * 小米商城
*/
Route::get('/index','Mi\IndexController@index');        //  首页

Route::get('/login','Mi\UserController@login');         //  登录页
Route::post('/doLogin','Mi\UserController@doLogin');    //  登录

Route::get('/register','Mi\UserController@register');   //  注册页
Route::post('/regist','Mi\UserController@regist');      //  注册

Route::get('/cart','Mi\CartController@cart');      //  购物车

Route::get('/list','Mi\IndexController@list');      //  列表页

Route::get('/order','Mi\CartController@order');      //  订单

Route::get('/self','Mi\UserController@self');      //  个人信息页

Route::post('/checkName','Mi\UserController@checkName');      //  验证用户名唯一性

Route::get('/detail','Mi\IndexController@detail');      //  详情页








