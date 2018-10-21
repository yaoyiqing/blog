<?php
/**
 * Created by PhpStorm.
 * User: 姚以清
 * Date: 2018/10/16
 * Time: 18:45
 */

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Services\Admin\MenuService;
use Illuminate\Contracts\Session\Session;

class IndexController extends Controller
{
    public function index()
    {
        $service = new MenuService();
        $menus = $service->registerMenu();
//        dd($menus);
        return view('mi.backend.dashboard',['menu' => $menus]);
    }

}