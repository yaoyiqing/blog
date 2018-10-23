<?php
/**
 * Created by PhpStorm.
 * User: 姚以清
 * Date: 2018/10/18
 * Time: 19:41
 */

namespace App\Http\Models\Admin;


use Illuminate\Support\Facades\DB;

class RoleResourceModel
{
    protected $table = 'mi_admin_role_resource';

    public $timestamps = false;

    protected $primaryKey= 'id';

    /*
     * 删除指定角色相关的数据
     */
    public function delByRole($roleid)
    {
        $res = DB::table($this->table)->where('role_id',$roleid)->delete();
        return $res;
    }

    /*
     *
     */
    public function addResource($resource)
    {
        $res = DB::table($this->table)->insert($resource);
        return $res;
    }

    /*
     * 获取指定角色的权限id
     */
    public function getResourceByRole($role_id)
    {
        $resource = DB::table($this->table)->where('role_id',$role_id)->orderBy('resource_id')->get();
//        dd($resource);
        return $resource;
    }

    /*
     * 通过菜单删除相关数据
     */
    public function delByMenu($menu_id)
    {
        $res = DB::table($this->table)->where('resource_id',$menu_id)->where('type',0)->delete();
        return $res;
    }
}