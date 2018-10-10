<?php
/**
 * Created by PhpStorm.
 * User: 姚以清
 * Date: 2018/9/29
 * Time: 10:01
 */

namespace App\Services;

use App\Http\Models\UserModel;
use App\Http\Models\LoginLogModel;
use Illuminate\Support\Facades\Session;


class UserService
{
    /*
     * 用户登录
     */
    public function login($info)
    {
        // 实例化对象
        $userModel = new UserModel();
        $logModel = new LoginLogModel();

        $username = $info['username'];
        $password = md5($info['password']);

        // 获取用户信息
        $user = $userModel->getUserinfoByName($username);

        // 判断信息
        if(!$user || $password != $user->password){
            return redirect('login');
        }

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
        $data = $logModel->getLoginCountById($user->user_id);
        $count = count($data);
        // 判断同一个用户的登录信息是否满10条
        if($count < 10){
            $result = $logModel->loginLog($log);
        }else{
            $result = $logModel->saveLoginLogByUser($data[0]->user_id,$data[0]->user_login_id,$log);
        }
        if($result){
            Session::put('user',$user);
            return true;
        }
    }

    /*
     * 新用户注册
     */
    public function register($info)
    {
        $model = new UserModel();
        if ($info) {
            $regemail = "/^([a-z0-9_\.-]+)@([\da-z\.-]+)\.([a-z\.]{2,6})$/";
            $regmobile = "/^1[345678][0-9]{9}$/";
            if (preg_match($regemail, $info['username'])) {
                $userinfo = [
                    'username' => $info['username'],
                    'password' => md5($info['password']),
                ];
                $result = $model->registerUser($userinfo);
                if($result){
                    // 邮箱注册成功
                    return 1;
                }
            } elseif (preg_match($regmobile, $info['username'])) {
                $userinfo = [
                    'username' => $info['username'],
                    'password' => md5($info['password']),
                ];
                $result = $model->registerUser($userinfo);
                if($result){
                    // 手机号注册成功
                    return 2;
                }
            } else {
                // 注册失败
                return 3;
            }
        }
    }

    /*
    * 验证用户名唯一性
    */
    public function checkNameIsOnly($username){
        $model = new UserModel();
        $userinfo = $model->getUserinfoByName($username);
        if(!$userinfo){
            return true;
        }else{
            // 用户名存在，不可重复注册
            return false;
        }
    }
}