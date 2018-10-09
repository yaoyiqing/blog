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
use Illuminate\Support\Facades\Mail;

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
        ],[
            'username.required' => '用户名不能为空',
            'password.required' => '用户密码不能为空',
            'verificode.required' => '验证码不能为空',
            'verificode.captcha' => '验证码有误',
        ]);
        // 调用service层登录方法
        $userService = new UserService();
        $info = $request->all();
        $result = $userService->login($info);
        // 根据service层登录方法的返回值判断执行相应的结果（跳转/返回错误信息）
        if($result){
            return redirect('index');
        }
    }

    /*
     * 用户退出登录，继续浏览首页
     */
    public function logout()
    {
        Session::forget('user');
        return redirect('index');
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
//            'telephone' => ['required_without:id_no', 'regex:/^1[3-9]\d{9}$/'],
//            'username' => ['required','unique:mi_user,username','regex:/^([a-z0-9_\.-]+)@([\da-z\.-]+)\.([a-z\.]{2,6})$/'],
            'username' => 'required | unique:mi_user,username',
            'password' => 'required | min:6 | confirmed',
            'verificode' => 'required | captcha',
        ],[
            'username.required' => '用户名不能为空',
            'username.unique' => '用户名已被注册',
//            'username.regex' => '用户名格式不正确',
            'password.required' => '密码不能为空',
            'password.min' => '密码不能少于六位',
            'password.confirmed' => '两次密码不一致',
            'repassword.required' => '密码不能为空',
            'verificode.required' => '验证码不能为空',
            'verificode.captcha' => '验证码有误',
        ]);
        // 调用service层注册方法
        $userService = new UserService();
        $info = $request->input();
        $result = $userService->register($info);
        // 根据service层注册方法的返回值判断执行相应的结果（跳转/返回错误信息）
        if($result == 1){
            // 队列发送邮件
            $this->dispatch(new SendEmail($info['username']));
            return redirect('login')->with('message','邮箱注册成功,请登录');
        }else if($result == 2){
            return redirect('login')->with('message','手机号注册成功,请登录');
        }else{
            return redirect('register')->with('message','注册失败,请重试');
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
            return true;
        }else{
            return false;
        }
    }
}