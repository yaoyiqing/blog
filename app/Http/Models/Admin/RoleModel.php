<?php
/**
 * Created by PhpStorm.
 * User: 姚以清
 * Date: 2018/10/18
 * Time: 9:16
 */

namespace App\Http\Models\Admin;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class RoleModel extends Model
{
    protected $table = 'mi_admin_role';

    public $timestamps = false;

    protected $primaryKey= 'role_id';

    /*
     * 添加角色
     */
    public function addRole($role)
    {
        $result = DB::table($this->table)->insert($role);
        return $result;
    }

    /*
     * 所有角色
     */
    public function roleList()
    {
        $roles = DB::table($this->table)->paginate(10);
        return $roles;
    }

    /*
     * 删除角色
     */
    public function delRole($roleid)
    {
        $res = DB::table($this->table)->where('role_id',$roleid)->delete();
        return $res;
    }

    /*
     * 添加角色获取添加的id
     */
    public function addRoleGetId($role)
    {
        $insertId = DB::table($this->table)->insertGetId($role);
        return $insertId;
    }

    /*
     * 获取指定角色
     */
    public function getSingleRole($roleID)
    {
        $role = DB::table($this->table)->where('role_id',$roleID)->first();
        return $role;
    }
}