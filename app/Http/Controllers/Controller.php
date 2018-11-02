<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    /*
     * 操作成功跳转提示
     */
    public function success($message,$url,$jumpTime = 3)
    {
        $data = [
            'message' => $message,  //跳转展示信息
            'url' => $url,    //跳转url
            'jumpTime' => $jumpTime,  //跳转时间
            'status' => true,   //跳转类型 true | false
        ];
        return view('mi.prompt',['data' => $data]);
    }

    /*
     * 操作失败跳转提示
     */
    public function error($message,$url,$jumpTime = 3)
    {
        $data = [
            'message' => $message,
            'url' => $url,
            'jumpTime' => $jumpTime,
            'status' => false,
        ];
        return view('mi.prompt',['data' => $data]);
    }
}
