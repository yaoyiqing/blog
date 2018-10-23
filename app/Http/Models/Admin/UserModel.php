<?php
/**
 * Created by PhpStorm.
 * User: 姚以清
 * Date: 2018/10/15
 * Time: 22:28
 */

namespace App\Http\Models\Admin;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class UserModel extends Model
{
    protected $table = 'mi_admin_user';

    public $timestamps = false;

    protected $primaryKey= 'user_id';

    /*
     * 通过用户名获取用户信息
     */
    public function getUserinfoByName($username,$is_freeze = 1)
    {
        $userinfo = DB::table($this->table)->where('is_freeze',$is_freeze)->Where('user_email',$username)->first();
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

    /*
     *  所有管理员信息表
     */
    public function getAdminList($column = ['*'])
    {
        $admins = DB::table($this->table)->select($column)->get();
        return $admins;
    }

    /*
     * 记录管理员最后一次登陆时间
     */
    public function lastLoginTime($key, $value,$updateArr)
    {
        $res = DB::table($this->table)->where($key,$value)->update($updateArr);
        return $res;
    }

    /*
     * 添加管理员
     */
    public function addAdmin($admin)
    {
        $insertId = DB::table($this->table)->insertGetId($admin);
        return $insertId;
    }

    public function updateStates($user_id,$info)
    {
        $res = DB::table($this->table)->where('user_id',$user_id)->update($info);
        return $res;
    }

    /*
     * 获取指定用户拥有的角色
     */
    public function getRolesOfAdmin($user_id)
    {
        $roles = DB::table('mi_admin_role')->select('role_name')
            ->leftJoin('mi_admin_user_role','mi_admin_role.role_id','=','mi_admin_user_role.role_id')
            ->where('mi_admin_user_role.user_id','=',$user_id)
            ->get();
//        dd($roles);
        return $roles;
    }
}