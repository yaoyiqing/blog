<?php
/**
 * Created by PhpStorm.
 * User: 姚以清
 * Date: 2018/9/28
 * Time: 9:16
 */

namespace App\Http\Controllers\Mi;

use App\Http\Controllers\Controller;
use App\Http\Models\LoginLogModel;
use App\Http\Models\UserModel;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Service\UserService;
use Illuminate\Support\Facades\Mail;

class UserController extends Controller
{
    // 验证码验证
    public function checkCaptcha(Request $request)
    {
        $validated = $this->validate($request,[
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
        $usermodel = new UserModel();
        $logmodel = new LoginLogModel();
        $request = Request();
        $info = $request->all();
        $res = $this->checkVerificode($request);
        if($res){
            $username = $info['username'];
            $password = md5($info['password']);
            $user = $usermodel->getUserinfoByName($username);
//            var_dump($user->password);die;
            if($user){
                if($password == $user->password){
                    $addr = file_get_contents("http://ip.taobao.com/service/getIpInfo.php?ip=" . $_SERVER['REMOTE_ADDR']);
                    $addr = json_decode($addr,true);
                    $addr = $addr['data']['city'];
                    $log = [
                        'login_time' => time(),
                        'login_ip' => $_SERVER['REMOTE_ADDR'],
                        'login_addr' => $addr,
                        'login_type' => 0,
                        'user_id' => $user->user_id,
                    ];
                    $res = $logmodel->loginLog($log);
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

    public function regist(Request $request)
    {
        $model = new UserModel();
        $info = $request->input();
        // 验证验证码
        $res = $this->checkCaptcha($request);
        if ($res) {
            if ($info) {
                $regemail = "/^([a-z0-9_\.-]+)@([\da-z\.-]+)\.([a-z\.]{2,6})$/";
                $regmobile = "/^1[345678][0-9]{9}$/";
                if (preg_match($regemail, $info['username'])) {
                    $data = ['email' => $info['username']];
                    Mail::send('mi/turn', $data, function ($message) use ($data) {
                        $message->to($data['email'])->subject('欢迎加入我们的网站！');
                    });
                } elseif (preg_match($regmobile, $info['username'])) {
                    echo "手机";
                } else {
                    return false;
                }
                $userinfo = [
                    'username' => $info['username'],
                    'password' => md5($info['password']),
                ];
//                var_dump($userinfo);die;
                $res = $model->registerUser($userinfo);
                if ($res) {
                    return redirect('login');
                } else {
                    return redirect('register');
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

    // 验证用户名唯一性
    public function checkName(Request $request){
        $username = $request->input('username');
        $model = new UserModel();
        $userinfo = $model->getUserinfoByName($username);
        return json_encode($userinfo);
    }
}