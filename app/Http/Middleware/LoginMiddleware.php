<?php

namespace App\Http\Middleware;

use App\Services\Admin\BackendRoleService;
use Closure;

class LoginMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
//        dd(123);
        if(!session()->has('user')){
            return redirect('/admin/login');
        }

//        $arr = explode('/',$request->getPathInfo());
//        if(count($arr) < 4){
//            $path = $request->getPathInfo();
//        }else{
//            unset($arr[3]);
//            unset($arr[4]);
//            $path = implode('/',$arr);
//        }
////        dd($path);
//        if ($path != '/admin'){         //如果是访问首页的
//            //调用Service
//            $data = BackendRoleService::getUrl($path);
////            dd($_SERVER);
//            if (!$data) {
//                return redirect('/prompt')->with([
//                    'message' => '您无访问此操作的权限，请联系管理员',  //跳转展示信息
//                    'url' => '/admin',    //跳转url
//                ]);
//            }
//        }

        return $next($request);
    }
}
