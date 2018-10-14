<?php
/**
 * Created by PhpStorm.
 * User: 姚以清
 * Date: 2018/9/28
 * Time: 9:16
 */

namespace App\Http\Controllers\Mi;

use App\Http\Controllers\Controller;
use App\Jobs\SendEmail;
use Illuminate\Http\Request;
use App\Services\UserService;
use Illuminate\Support\Facades\Session;

class UserController extends Controller
{
    public function login()
    {
        return view('mi.login');
    }

    /*
     * 用户登录
     */
    public function doLogin(Request $request)
    {
        // 验证数据
        $this->validate($request,[
            'username' => 'required',
            'password' => 'required',
            'verificode' => 'required | captcha',
        ]);
        // 调用service层登录方法
        $userService = new UserService();
        $info = $request->all();
        $result = $userService->login($info);
        // 根据service层登录方法的返回值判断执行相应的结果（跳转/返回错误信息）
        if($result){
            return $this->success('登录成功','index');
        }
    }

    /*
     * 用户退出登录，继续浏览首页
     */
    public function logout()
    {
        Session::forget('user');
        return $this->success('退出成功','login');
    }

    public function register()
    {
        return view('mi.register');
    }

    /*
     * 新用户注册
     */
    public function regist(Request $request)
    {
        // 验证数据
        $this->validate($request,[
            'mobile' => ['required_without_all:user_email,mobile', 'unique:mi_user,mobile','regex:/^1[345678][0-9]{9}$/'],
            'user_email' => ['required_without_all:mobile,user_email', 'unique:mi_user,user_email','regex:/^([a-z0-9_\.-]+)@([\da-z\.-]+)\.([a-z\.]{2,6})$/'],//
            'password' => ['required','confirmed','regex:/^[A-Za-z\d]{6,11}$/'],
            'verificode' => 'required | captcha',
        ]);
        // 调用service层注册方法
        $userService = new UserService();
        $info = $request->input();
        $result = $userService->register($info);
        // 根据service层注册方法的返回值判断执行相应的结果（跳转/返回错误信息）
        if($result == 1){
            // 队列发送邮件
            $this->dispatch(new SendEmail($info['user_email']));
            return $this->success('注册成功','index');
        }else if($result == 2){
            return $this->success('注册成功,请登录','index');
        }else{
            return $this->error('注册失败,请重试','register');
        }

    }

    public function self()
    {
        return view('mi.self_info');
    }

    /*
     * 验证用户名唯一性
     */
    public function checkNameIsOnly(Request $request){
        $username = $request->input('username');
        $userService = new UserService();
        $result = $userService->checkNameIsOnly($username);
        if($result){
            // 用户未被注册，可以使用
            return 1;
        }else{
            return 0;
        }
    }
}