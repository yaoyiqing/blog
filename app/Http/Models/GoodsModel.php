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
        $data = DB::table($this->table)->where('is_delete',1)->select($column)->get();
        return $data;
    }

    public function getGoodsByCateOrder($cate_id,$limit=5,$type='desc')
    {
        $goods = DB::table($this->table)->where('cate_id',$cate_id)->orderBy('add_time',$type)->limit($limit)->get();
        return $goods;
    }

    public function getGoodsAndCate()
    {
        $goods = DB::table('mi_goods')
            ->leftJoin('mi_category','mi_goods.cate_id','=','mi_category.cate_id')
            ->where('mi_goods.is_delete',1)
            ->paginate(10);
        return $goods;
    }

    public function getGoodsById($goodsid)
    {
        $goods = DB::table($this->table)->where('goods_id',$goodsid)->first();
        return $goods;
    }

    public function updateStatus($goodsid,$goods)
    {
        $res = DB::table($this->table)->where('goods_id',$goodsid)->update($goods);
        return $res;
    }

    public function getGoodsDetailById($goodsid)
    {
        $goods = DB::table('mi_goods')
            ->leftJoin('mi_category','mi_goods.cate_id','=','mi_category.cate_id')
            ->where('goods_id',$goodsid)
            ->first();
        return $goods;
    }

    public function delGoods($goodsId)
    {
        $res = DB::table($this->table)->where('goods_id',$goodsId)->update(['is_delete'=>0]);
        return $res;
    }

    public function addGoods($goods)
    {
        $goodsId = DB::table($this->table)->insertGetId($goods);
        return $goodsId;
    }

}