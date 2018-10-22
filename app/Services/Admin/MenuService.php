<?php
/**
 * Created by PhpStorm.
 * User: 姚以清
 * Date: 2018/10/16
 * Time: 18:33
 */

namespace App\Services\Admin;

use App\Http\Models\Admin\MenuModel;
use App\Http\Models\Admin\RoleResourceModel;
use Illuminate\Support\Facades\DB;
use JeroenNoten\LaravelAdminLte\ServiceProvider;

class MenuService
{
    public function registerMenu()
    {
        $user_id = session()->get('user.user_id');
        $sql = 'SELECT menu_id,text,url,parent_id FROM mi_admin_menu join (select resource_id,`type` from mi_admin_role_resource as a join (select role_id from mi_admin_user_role where user_id = ' . $user_id . ') as b where a.role_id = b.role_id)
as z where mi_admin_menu.menu_id = z.resource_id and mi_admin_menu.is_menu = 1';
        $menus = DB::select($sql);
//        dump($data);die;
//        $model = new MenuModel();
//        $menus = $model->getMenu();
        $menu = $this->getSonMenu($menus);
//        dump($menu);die;
        return $menu;
    }

    public function getSonMenu($arr,$path=0)
    {
        $arr = $this->objectToArray($arr);
        $data = [];
//        foreach($arr as $key => $val){
            //如果当前的父级id是上条记录的权限id
            foreach($arr as $k => $menu){
//                dd($menu);
                if($menu['parent_id'] == $path){
                    $menu['submenu'] = $this->getSonMenu($arr,$menu['menu_id']);
                    $data[] = array_filter($menu);
                }
            }
//        }
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
     * 权限列表
     */
    public function menuList()
    {
        $model = new MenuModel();
        $menus = $model->getAllMenu();
        return $menus;
    }

    public function delMenu($menu_id)
    {
        $model = new MenuModel();
        $resourceModel = new RoleResourceModel();
        $result = true;
        DB::beginTransaction();
        try{
            $model->delMenu($menu_id);
            $model->delMenuByParent($menu_id);
            $resourceModel->delByMenu($menu_id);
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

    public function addMenu($menu)
    {
        $menuinfo = [
            'text' => $menu['text'],
            'url' => $menu['url'],
            'is_menu' => intval($menu['is_menu']),
            'parent_id' => $menu['parent_id'],
            'icon' => ($menu['parent_id'] == 0) ? 'share' : '',
        ];
        $model = new MenuModel();
        $menuId = $model->addMenu($menuinfo);
        if($menuId){
            if($menu['parent_id'] == 0){
                $menuinfo = [
                    'path' => $menuId,
                ];
            }else{
                $parentMenu = $model->getPathByMenu($menu['parent_id']);
                $parentPath = $parentMenu->path;
                $menuinfo = [
                    'path' => $parentPath . '-' . $menuId,
                ];
            }
            $res = $model->updateMenuOfPath($menuId,$menuinfo);
            if($res){
                return true;
            }else{
                return false;
            }
        }else{
            return false;
        }
    }

    public function updateMenu($menuId)
    {
        $model = new MenuModel();
        $menu = $model->getOneMenu($menuId);
        $menu->menus = $model->getAllMenu();
        return $menu;
    }

    public function doUpdateMenu($menuId, $menu)
    {
        $menuinfo = [
            'text' => $menu['text'],
            'url' => $menu['url'],
            'is_menu' => intval($menu['is_menu']),
            'parent_id' => intval($menu['parent_id']),
            'icon' => ($menu['parent_id'] == 0) ? 'share' : '',
        ];
        $model = new MenuModel();
        $res = $model->updateMenu($menuId,$menuinfo);
        if($res){
            if($menu['parent_id'] == 0){
                $menuinfo = [
                    'path' => intval($menuId),
                ];
            }else{
                $parentMenu = $model->getPathByMenu($menu['parent_id']);
                $parentPath = $parentMenu->path;
                $menuinfo = [
                    'path' => $parentPath . '-' . $menuId,
                ];
            }
            $res = $model->updateMenuOfPath($menuId,$menuinfo);
            if($res){
                return true;
            }else{
                return false;
            }
        }else{
            return false;
        }
    }
}