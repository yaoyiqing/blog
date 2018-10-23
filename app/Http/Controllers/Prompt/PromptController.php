<?php
/**
 * Created by PhpStorm.
 * User: 姚以清
 * Date: 2018/10/23
 * Time: 17:24
 */

namespace App\Http\Controllers\Prompt;

use Illuminate\Routing\Controller;
use Illuminate\Http\Request;

class PromptController extends Controller
{
    /*
       *公共跳转提示
       */
    public function index()
    {
        //验证参数
        if(!empty(session('message')) && !empty(session('url'))){
            $data = [
                'message' => session('message'),  //跳转展示信息
                'url' => session('url'),    //跳转url
                'jumpTime' => 3,  //跳转时间
                'status' => session('status')   //跳转类型 true | false
            ];
        } else {
            $data = [
                'message' => '请勿非法访问！',
                'url' => '/admin',
                'jumpTime' => 3,
                'status' => false,
            ];
        }
        return view('mi.prompt',['data' => $data]);
    }
}