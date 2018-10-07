<?php
/**
 * Created by PhpStorm.
 * User: 姚以清
 * Date: 2018/9/28
 * Time: 9:16
 */

namespace App\Http\Controllers\Mi;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Service\UserService;

class UserController extends Controller
{
    // 注册验证
    public function checkCaptcha(Request $request)
    {
        $validated = $this->validate($request,[
            'username' => 'required|string|max:30|unique:mi_user',
            'password' => 'required|string|max:32',
            'mobile' => 'required|string|max:11|unique:mi_user',
//            'user_email' => 'required|string|max:255|unique:mi_user',
            'verificode' => 'required|captcha',
        ]);
        return $validated;
    }

    // 登录验证
    public function checkVerificode(Request $request)
    {
        $validated = $this->validate($request,[
            'username' => 'required',
            'password' => 'required',
            'verificode' => 'required|captcha',
        ]);
        return $validated;
    }

    public function login()
    {
        return view('mi.login');
    }

    public function doLogin()
    {
        $request = Request();
        $info = $request->all();
        $res = $this->checkVerificode($request);
        if($res){
            $username = $info['username'];
            $password = md5($info['password']);
            $user = DB::table('mi_user')->where('username',$username)->first();
//            var_dump($user->password);die;
            if($user){
                if($password == $user->password){
                    $log = [
                        'login_time' => time(),
                        'login_ip' => 0,
                        'login_addr' => 0,
                        'login_type' => 0,
                        'user_id' => $user->user_id,
                    ];
                    $res = DB::table('mi_user_login_log')->insert($log);
                    if($res){
                        return redirect('index');
                    }
                }else{
                    return redirect('login');
                }
            }else{
                return redirect('login');
            }
        }else{
            return redirect('login');
        }
    }

    public function register()
    {
        return view('mi.register');
    }

    public function regist()
    {
        $request = Request();
        $info = $request->all();
        // 验证验证码
        $res = $this->checkCaptcha($request);
//        var_dump($res);die;
        // 密码验证
        if($res){
            if($info['password']){
                if($info['password'] == $info['repassword']){
                    $user = [
                        'username' => $info['username'],
                        'password' => md5($info['password']),
                        'mobile' => $info['mobile'],
                    ];
                    $res = DB::table('mi_user')->insert($user);
                    if($res){
                        return redirect('login');
                    }else{
                        return redirect('register');
                    }
                }
            }
        }else{
            return redirect('register');
        }
    }

    public function self()
    {
        return view('mi.self_info');
    }
}