<?php
/**
 * Created by PhpStorm.
 * User: 姚以清
 * Date: 2018/10/14
 * Time: 20:59
 */

namespace App\Http\Models;

use Illuminate\Support\Facades\DB;

class GoodsModel
{
    protected $table = 'mi_goods';

    public $timestamps = false;

    protected $primaryKey= 'goods_id';

    public function getGoods($column = ['*'])
    {
        $data = DB::table($this->table)->select($column)->get();
        return $data;
    }

    public function getGoodsByCateOrder($cate_id,$limit=5,$type='desc')
    {
        $goods = DB::table($this->table)->where('cate_id',$cate_id)->orderBy('add_time',$type)->limit($limit)->get();
        return $goods;
    }
}