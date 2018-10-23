<?php
/**
 * Created by PhpStorm.
 * User: 姚以清
 * Date: 2018/10/18
 * Time: 18:36
 */

namespace App\Http\Models\Admin;


use Illuminate\Support\Facades\DB;

class UserRoleModel
{
    protected $table = 'mi_admin_user_role';

    public $timestamps = false;

    public function addUserRole($userRole)
    {
        $res = DB::table($this->table)->insert($userRole);
        return $res;
    }

    /*
     * 删除指定角色相关的数据
     */
    public function delByRole($roleid)
    {
        $res = DB::table($this->table)->where('role_id',$roleid)->delete();
        return $res;
    }

    public function getRoleByUser($userId)
    {
        $roleOfUser = DB::table('mi_admin_role')
            ->join('mi_admin_user_role','mi_admin_role.role_id','=','mi_admin_user_role.role_id')
            ->where('mi_admin_user_role.user_id','=',$userId)
            ->get();
        return $roleOfUser;
    }

    /*
     * 删除指定角色相关的数据
     */
    public function delByUser($userId)
    {
        $res = DB::table($this->table)->where('user_id',$userId)->delete();
        return $res;
    }
}