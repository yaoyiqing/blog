<?php
/**
 * Created by PhpStorm.
 * User: 姚以清
 * Date: 2018/10/16
 * Time: 18:36
 */

namespace App\Http\Models\Admin;

use Illuminate\Support\Facades\DB;

class MenuModel
{
    protected $table = 'mi_admin_menu';

    public $timestamps = false;

    protected $primaryKey= 'menu_id';

    public function getMenu()
    {
        $menus = DB::table($this->table)->where('is_menu',1)->get();
        return $menus;
    }

    public function getAllMenu()
    {
        $menus = DB::table($this->table)->orderBy('path')->get();
        return $menus;
    }

    /*
     * 获取单个角色ID对应的Menu(角色列表查看权限)
     */
    public static function getSingleMenu($roleId)
    {
        $data = DB::table( 'mi_admin_menu')       //join进行查询menu表数据
        ->leftjoin('mi_admin_role_resource','mi_admin_menu.menu_id','=','mi_admin_role_resource.resource_id')
            ->where('mi_admin_role_resource.role_id','=',$roleId)
            ->orderBy('path','asc')
            ->get();
        return $data;
    }


    public function delMenu($menu_id)
    {
        $res = DB::table($this->table)->where('menu_id',$menu_id)->delete();
        return $res;
    }

    public function delMenuByParent($menu_id)
    {
        $res = DB::table($this->table)->where('parent_id',$menu_id)->delete();
        return $res;
    }

    public function addMenu($menu)
    {
        $menuId = DB::table($this->table)->insertGetId($menu);
        return $menuId;
    }

    public function getPathByMenu($menu_id)
    {
        $res = DB::table($this->table)->where('menu_id',$menu_id)->first();
        return $res;
    }

    public function updateMenuOfPath($menuId,$menu)
    {
        $res = DB::table($this->table)->where('menu_id',$menuId)->update($menu);
        return $res;
    }

    public function getOneMenu($menuId)
    {
        $menu = DB::table($this->table)->where('menu_id',$menuId)->first();
        return $menu;
    }
    public function updateMenu($menuId,$menu)
    {
        $res = DB::table($this->table)->where('menu_id',$menuId)->update($menu);
        return $res;
    }
}