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
use Illuminate\Support\Facades\Auth;
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
        $user = $this->objectToArray($user);
        // 判断信息
        if(!$user || $password != $user['password']){
            return redirect('login');
        }
        return $this->loginLog($user) ? true : false;
    }

    /*
     * 新用户注册
     */
    public function register($info)
    {
//        dd($info);
        $model = new UserModel();

        if ($info) {
            $userinfo = [
                'username' => 'mi_' . microtime(time()),
                'user_email' => $info['user_email'],
                'mobile' => $info['mobile'],
                'password' => md5($info['password']),
                'register_time' => time(),
            ];
            $userId = $model->registerUser($userinfo);
            if($userId != ''){
                $userinfoById = $model->getUserinfoById($userId);
                // 邮箱注册成功
                return $this->loginLog($userinfoById) ? 1 : 2;
            }
        } else {
            // 注册失败
            return 3;
        }
    }

    /*
    * 验证用户名唯一性
    */
    public function checkNameIsOnly($username){
        $model = new UserModel();
        $userinfoByEmail = $model->getUserinfo('user_email',$username);
        $userinfoByMobile = $model->getUserinfo('mobile',$username);
        if(!$userinfoByEmail && !$userinfoByMobile){
            return true;
        }else{
            // 用户存在，不可重复注册
            return false;
        }
    }

    /*
     * 对象转数组
     */
    public function objectToArray($e)
    {
        $e = (array)$e;
        foreach ($e as $k => $v) {
            if (gettype($v) == 'resource') return;
            if (gettype($v) == 'object' || gettype($v) == 'array')
                $e[$k] = (array)$this->objectToArray($v);
        }
        return $e;
    }

    /*
     * 记录登录日志
     */
    public function loginLog($user){
//        dd($user);
        $user = $this->objectToArray($user);
        $logModel = new LoginLogModel();
        $addr = file_get_contents("http://ip.taobao.com/service/getIpInfo.php?ip=" . $_SERVER['REMOTE_ADDR']);
        $addr = json_decode($addr,true);
        $addr = $addr['data']['city'];
        $log = [
            'login_time' => time(),
            'login_ip' => $_SERVER['REMOTE_ADDR'],
            'login_addr' => $addr,
            'login_type' => 0,
            'user_id' => $user['user_id'],
        ];
        $data = $logModel->getLoginCountById($user['user_id']);
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
     * 通过session获取用户详细信息
     */
    public function getUserInfo()
    {
        $user = Session::get('user');
        $userModel = new UserModel();
        $userInfo = $userModel->getUserinfo('user_id',$user['user_id']);
        return $userInfo;
    }
}