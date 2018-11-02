<?php
/**
 * Created by PhpStorm.
 * User: 姚以清
 * Date: 2018/10/31
 * Time: 14:54
 */

namespace App\Http\Models\Admin;


use Illuminate\Support\Facades\DB;

class GoodsAttrModel
{
    protected $table = 'mi_goods_attribute';

    public $timestamps = false;

    protected $primaryKey= 'goods_attr_id';

    public function addGoodsAttrs($attr)
    {
        $res = DB::table($this->table)->insert($attr);
        return $res;
    }
}