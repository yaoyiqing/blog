<?php

namespace App\Http\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class UserModel extends Model
{
    protected $table = 'mi_user';

    public $timestamps = false;

    protected $primaryKey= 'user_id';

    /*
     * 注册用户信息入库
     */
    public function registerUser($user)
    {
        $res = DB::table($this->table)->insertGetId($user);
//        dd($res);
        return $res ? $res : '';
    }

    /*
     * 通过用户主键获取用户信息
     */
    public function getUserinfoById($user_id)
    {
        $userinfo = DB::table($this->table)->where('user_id',$user_id)->first();
        return $userinfo;
    }

    /*
     * 通过用户名获取用户信息
     */
    public function getUserinfoByName($username)
    {
        $userinfo = DB::table($this->table)->where('username',$username)->orWhere('user_email',$username)->orWhere('mobile',$username)->first();
//        dd($userinfo);
        return $userinfo;
    }

    public function getUserinfoByEmail($username)
    {
        $userinfo = DB::table($this->table)->Where('user_email',$username)->first();
//        dd($userinfo);
        return $userinfo;
    }
    public function getUserinfoByMobile($username)
    {
        $userinfo = DB::table($this->table)->Where('mobile',$username)->first();
//        dd($userinfo);
        return $userinfo;
    }

    /*
     * 获取单条用户信息
     */
    public function getUserinfo($key,$value)
    {
        $userinfo = DB::table($this->table)->Where($key,$value)->first();
//        dd($userinfo);
        return $userinfo;
    }
}
