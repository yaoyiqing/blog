<?php
/**
 * Created by PhpStorm.
 * User: 姚以清
 * Date: 2018/9/27
 * Time: 15:48
 */

namespace App\Http\Controllers\Test;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;

class TestController extends Controller
{
    public function select(){
        $data = DB::table('goods')->get();
        return view('test.select',['data' => $data]);
    }

    public function add(){
        $goods = [
          'goods_name' => '测试数据',
            'brand_id' => 1,
            'cat_id' => 1,
            'is_on_sale' => 1,
            'update_time' => time(),
        ];
        DB::table('goods')->insert($goods);
    }

    public function update(){
        $id = 97;
        $goods = [
            'goods_name' => '测试数据222',
            'brand_id' => 1,
            'cat_id' => 1,
            'is_on_sale' => 1,
            'update_time' => time(),
        ];
        DB::table('goods')->where(['goods_id' => $id])->update($goods);
    }

    public function del(){
        $id = 97;
        DB::table('goods')->where(['goods_id' => $id])->delete();
    }

    public function index(){
        return view('test.index');
    }

    public function insert(){
        $username = empty($_POST['username']) ? '' : $_POST['username'];
        $post['password ']= empty($_POST['password']) ? '' : $_POST['password'];
        $password = md5($post['password ']);
        $res = DB::table('user')->insert(['username' => $username,'password' =>$password]);
        if($res){
            return redirect('show');
        }
    }

    public function show(){
        $users = DB::table('user')->select();
        return view('test.show',['users' => $users]);
    }
}