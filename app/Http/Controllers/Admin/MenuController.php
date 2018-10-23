<?php
/**
 * Created by PhpStorm.
 * User: 姚以清
 * Date: 2018/10/16
 * Time: 18:40
 */

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Services\Admin\MenuService;

class MenuController extends Controller
{
    public function menuList()
    {
        $service = new MenuService();
        $menus = $service->registerMenu();
        dump($menus);
    }
}