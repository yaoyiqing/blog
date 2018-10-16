<?php
/**
 * Created by PhpStorm.
 * User: 姚以清
 * Date: 2018/10/8
 * Time: 8:58
 */

namespace App\Http\Controllers\Mi;


use App\Http\Controllers\Controller;

class TurnController extends Controller
{

    public function turn()
    {
        return view('mi.turn');
    }

    /*
     * 跳转信息提示页
     */
    public function prompt()
    {
        return view('mi.prompt');
    }
}