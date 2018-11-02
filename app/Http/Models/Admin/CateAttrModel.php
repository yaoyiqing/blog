<?php
/**
 * Created by PhpStorm.
 * User: 姚以清
 * Date: 2018/10/27
 * Time: 11:04
 */

namespace App\Http\Models\Admin;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class CateAttrModel extends Model
{
    protected $table = 'mi_cate_attr';

    public $timestamps = false;

    protected $primaryKey= 'cate_attr_id';

    public function addValues($attrs)
    {
        $res = DB::table($this->table)->insert($attrs);
        return $res;
    }

    public function getAttrsByCate($cateId)
    {
        $attrs = DB::table($this->table)->where('cate_id',$cateId)->get();
        return $attrs;
    }

    public function delValuesByCate($cateId)
    {
        $res = DB::table($this->table)->where('cate_id',$cateId)->delete();
        return $res;
    }

    public function getCateAndAttrs($cateId)
    {
        $attrs = DB::table('mi_cate_attr')
            ->join('mi_attribute','mi_cate_attr.attr_id','=','mi_attribute.attr_id')
            ->where('mi_cate_attr.cate_id',$cateId)
            ->get();
        return $attrs;
    }
}