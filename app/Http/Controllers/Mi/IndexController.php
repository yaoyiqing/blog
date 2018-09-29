<?php
/**
 * Created by PhpStorm.
 * User: 姚以清
 * Date: 2018/9/28
 * Time: 7:56
 */

namespace App\Http\Controllers\Mi;

use App\Http\Controllers\Controller;

class IndexController extends Controller
{
    public function index()
    {
        return view('mi.index');
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