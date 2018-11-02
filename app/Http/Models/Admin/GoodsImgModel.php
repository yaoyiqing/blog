<?php
/**
 * Created by PhpStorm.
 * User: 姚以清
 * Date: 2018/10/31
 * Time: 19:59
 */

namespace App\Http\Models\Admin;


use Illuminate\Support\Facades\DB;

class GoodsImgModel
{
    protected $table = 'mi_goods_img';

    public $timestamps = false;

    protected $primaryKey= 'img_id';

    public function addGoodsImgs($imgs)
    {
        $res = DB::table($this->table)->insert($imgs);
        return $res;
    }
}