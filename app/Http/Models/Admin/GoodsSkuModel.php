<?php
/**
 * Created by PhpStorm.
 * User: 姚以清
 * Date: 2018/10/31
 * Time: 14:55
 */

namespace App\Http\Models\Admin;


use Illuminate\Support\Facades\DB;

class GoodsSkuModel
{
    protected $table = 'mi_sku';

    public $timestamps = false;

    protected $primaryKey= 'sku_id';

    public function addSkus($sku)
    {
        $res = DB::table($this->table)->insert($sku);
        return $res;
    }
}