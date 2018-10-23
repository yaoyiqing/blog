<?php
/**
 * Created by PhpStorm.
 * User: 姚以清
 * Date: 2018/10/18
 * Time: 9:19
 */

namespace App\Services\Admin;


use App\Http\Models\Admin\AuthModel;
use App\Http\Models\Admin\MenuModel;
use App\Http\Models\Admin\RoleModel;
use App\Http\Models\Admin\RoleResourceModel;
use App\Http\Models\Admin\UserRoleModel;
use Illuminate\Support\Facades\DB;
use PharIo\Version\Exception;

class RoleService
{
    public function addRole($roles)
    {
        $role = [
            'role_name' => $roles['role_name'],
        ];
        $model = new RoleModel();
        $role_id = $model->addRoleGetId($role);
//        dd($roles);
        if($role_id){
            foreach($roles['menu_name'] as $resource){
                $roleResource[] = [
                    'role_id' => intval($role_id),
                    'resource_id' => intval($resource),
                    'type' => 0,
                ];
            }
//            dd($role);
            $resourceModel = new RoleResourceModel();
            $rs = $resourceModel->addResource($roleResource);
            if($rs){
                return true;
            }else{
                return false;
            }
        }else{
            return false;
        }
    }

    /*
     * 角色列表
     */
    public function roleList()
    {
        $model = new RoleModel();
        $roles = $model->roleList();
        return $roles;
    }

    /*
     * 删除角色
     */
    public function delRole($roleid)
    {
        $roleModel = new RoleModel();
        $userRoleModel = new UserRoleModel();
        $roleResourceModel = new RoleResourceModel();
        DB::beginTransaction();
        $result = true;
        try{
            $roleModel->delRole($roleid);
            $userRoleModel->delByRole($roleid);
            $roleResourceModel->delByRole($roleid);
            DB::commit();
        }catch(\Exception $e){
            $result = false;
            $e->getMessage();
            DB::rollBack();
        }
        if($result){
            return true;
        }else{
            return false;
        }
    }

    /*
     * 展示所有权限
     */
    public function allMenu()
    {
        $model = new MenuModel();
        $menus = $model->getAllMenu();
        $menus = $this->getSonMenu($menus);
        return $menus;
    }

    public function getSonMenu($arr,$path=0)
    {
        $arr = $this->objectToArray($arr);
        $data = [];
        foreach($arr as $key => $val){
            //如果当前的父级id是上条记录的权限id
            foreach($val as $k => $menu){
    //                dd($menu);
                if($menu['parent_id'] == $path){
                    $menu['submenu'] = $this->getSonMenu($arr,$menu['menu_id']);
                    $data[] = array_filter($menu);
                }
            }
        }
        return $data;
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
     * 获取指定角色的权限
     */
    public function getAuthByRole($role_id)
    {
        $menuModel = new MenuModel();
        $arr['menus'] = $menuModel->getSingleMenu($role_id);
        $roleModel = new RoleModel();
        $arr['role'] = $roleModel->getSingleRole($role_id);
        return $arr;
    }

    public function updateRole($role_id)
    {
        $roleModel = new RoleModel();
        $arr['role'] = $roleModel->getSingleRole($role_id);
        $arr['role'] = $this->objectToArray($arr['role']);
        $resourceModel = new RoleResourceModel();
        $roleResource = $resourceModel->getResourceByRole($role_id);
        $arr['roleResource'] = [];
        foreach($roleResource as $role){
            foreach ($role as $key => $val){
                if($key == 'resource_id'){
                    $arr['roleResource'][] = $val;
                }
            }
        }
//        dd($arr['roleResource']);
        $arr['roleResource'] = $this->objectToArray($arr['roleResource']);
        $menuModel = new MenuModel();
        $arr['menus'] = $menuModel->getAllMenu();
        $arr['menus'] = $this->getSonMenu($arr['menus']);
        $arr['menus']= $this->objectToArray($arr['menus']);
        return $arr;
    }

    public function doUpdateRole($role_id,$role)
    {
        $roleModel = new RoleModel();
        $roleMenuModel = new RoleResourceModel();
        $roles = [
            'role_name'=>$role['role_name'],
        ];
        foreach($role['menu_name'] as $resource){
            $roleResource[] = [
                'role_id' => intval($role_id),
                'resource_id' => intval($resource),
                'type' => 0,
            ];
        }
        $result = true;
        DB::beginTransaction();
        try{
            $roleModel->updateRoleName($role_id,$roles);
            $roleMenuModel->delByRole($role_id);
            $roleMenuModel->addResource($roleResource);
            DB::commit();
        }catch(\Exception $e){
            $result = false;
            $e->getMessage();
            DB::rollBack();
        }
        if($result){
            return true;
        }else{
            return false;
        }
    }
}
