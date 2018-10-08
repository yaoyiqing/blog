<?php
/**
 * Created by PhpStorm.
 * User: 姚以清
 * Date: 2018/9/28
 * Time: 7:56
 */

namespace App\Http\Controllers\Mi;

use App\Http\Controllers\Controller;
use App\Http\Models\CateModel;
use App\Http\Models\NavModel;

class IndexController extends Controller
{
    public function index()
    {
        $navmodel = new NavModel();
        $navs = $navmodel->getNavgate();
        $catemodel = new CateModel();
        $cates = $catemodel->getcategory();
//        dump($navs);die;
        return view('mi.index',['navs' => $navs,'cates' => $cates]);
    }

    public function list()
    {
        return view('mi.list');
    }

    public function detail()
    {
        return view('mi.detail');
    }
}