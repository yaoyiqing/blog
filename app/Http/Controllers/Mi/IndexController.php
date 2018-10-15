<?php
/**
 * Created by PhpStorm.
 * User: 姚以清
 * Date: 2018/9/28
 * Time: 7:56
 */

namespace App\Http\Controllers\Mi;

use App\Http\Controllers\Controller;
use App\Services\IndexService;

class IndexController extends Controller
{
    public function index()
    {
        $service = new IndexService();
        $navs = $service->getNav();
        $cates = $service->getCate();
        $cates = $service->getSonCates($cates);
        $goods = $service->getGoodsToShow();
        $parts = $service->getPartsToShow();
//        dd($goods);
//        echo "<pre/>"; print_r($cates);die;
        return view('mi.index',['navs' => $navs,'cates' => $cates,'goods' => $goods,'parts' => $parts]);
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