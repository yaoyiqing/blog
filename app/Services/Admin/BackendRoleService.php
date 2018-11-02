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
        $menus = DB::table('mi_admin_menu')
            ->join('mi_admin_role_resource','mi_admin_menu.menu_id','=','mi_admin_role_resource.resource_id')
//            ->join('mi_admin_button','mi_admin_button.button_id','=','mi_admin_role_resource.resource_id')
            ->where('mi_admin_role_resource.role_id',$roleId)
            ->where('mi_admin_role_resource.type','=','0')
            ->get();

        $buttons = DB::table('mi_admin_button')
            ->join('mi_admin_role_resource','mi_admin_button.button_id','=','mi_admin_role_resource.resource_id')
            ->where('mi_admin_role_resource.role_id',$roleId)
            ->where('mi_admin_role_resource.type','=','1')
            ->get();

        $button = [];
        $menu = [];
        foreach ($buttons as $key => $v) {
            $button[] = $v->url;
        }
        foreach ($menus as $key => $v) {
            $menu[] = $v->url;
        }
        $url =array_merge($menu,$button);
//        dd($url);
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