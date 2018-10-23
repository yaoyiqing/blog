<?php
/**
 * Created by PhpStorm.
 * User: 姚以清
 * Date: 2018/10/23
 * Time: 16:37
 */

namespace App\Services\Admin;

use App\Http\Models\Admin\UserRoleModel;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;

class BackendRoleService
{
    /*
         *  路由访问权限
         */
    public static function getUrl($pathInfo)
    {
        $roleId = self::getRole();          //获取角色ID
        $data = DB::table('mi_admin_menu')
            ->leftjoin('mi_admin_role_resource','mi_admin_menu.menu_id','=','mi_admin_role_resource.resource_id')
            ->whereIn('mi_admin_role_resource.role_id',$roleId)
            ->get();
        $url = [];
        foreach ($data as $key => $v) {
            $url[] = $v->url;
        }
//        dd($pathInfo);
        if (in_array($pathInfo,$url)){
            return true;
        }else {
            return false;
        }
    }

    public static function getRole()
    {
        $user = Session::get('user');
        $model = new UserRoleModel();
        $roles = $model->getRoleByUser($user['user_id']);
        $roleIds = [];
        foreach($roles as $role){
            foreach($role as $key => $val){
                if($key == 'role_id'){
                    $roleIds[] = $val;
                }
            }
        }
        return $roleIds;
    }
}