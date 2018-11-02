<?php
/**
 * Created by PhpStorm.
 * User: 姚以清
 * Date: 2018/10/8
 * Time: 13:41
 */

namespace App\Http\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class CateModel extends Model
{
    protected $table = 'mi_category';

    public $timestamps = false;

    protected $primaryKey= 'cate_id';

    public function getCates()
    {
        $cates = DB::table($this->table)->where('is_delete',1)->orderBy('path')->get();
        return $cates;
    }

    public function delCate($cate_id)
    {
        $res = DB::table($this->table)->where('cate_id',$cate_id)->update(['is_delete'=>0]);
        return $res;
    }

    public function delCateByParent($cate_id)
    {
        $res = DB::table($this->table)->where('parent_id',$cate_id)->update(['is_delete'=>0]);
        return $res;
    }

    public function addCategory($cate)
    {
        $insertId = DB::table($this->table)->insertGetId($cate);
        return $insertId;
    }

    public function getCate($cate_id)
    {
        $cate = DB::table($this->table)->where('cate_id',$cate_id)->first();
        return $cate;
    }

    public function updateCateById($cate_id,$cate)
    {
        $res = DB::table($this->table)->where('cate_id',$cate_id)->update($cate);
        return $res;
    }
}