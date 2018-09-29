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
    public function checkCaptcha(Request $request)
    {
        $verificode = $this->validate($request,[
            'verificode' => 'required|captcha',
        ]);
        return $verificode;
    }

    public function login()
    {
        return view('mi.login');
    }

    public function doLogin()
    {

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
        // 密码验证
        if($res){
            if($info['password']){
                if($info['password'] == $info['repassword']){
                    $user = [
                        'username' => $info['username'],
                        'password' => $info['password'],
                        'mobile' => $info['mobile'],
                    ];
                    $res = DB::table('mi_user')->insert($user);
                    if($res){
                        return redirect();
                    }
                }
            }
        }

    }

    public function self()
    {
        return view('mi.self_info');
    }
}