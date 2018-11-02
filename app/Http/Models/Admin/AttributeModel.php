<?php
/**
 * Created by PhpStorm.
 * User: 姚以清
 * Date: 2018/10/26
 * Time: 9:36
 */

namespace App\Http\Models\Admin;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class AttributeModel extends Model
{
    protected $table = 'mi_attribute';

    public $timestamps = false;

    protected $primaryKey= 'attr_id';

    public function getAttrs()
    {
        $attrs = DB::table($this->table)->where('is_delete',1)->paginate(20);
        return $attrs;
    }

    public function delAttr($attr_id)
    {
        $res = DB::table($this->table)->where('attr_id',$attr_id)->update(['is_delete'=>0]);
        return $res;
    }

    public function addAttr($attr)
    {
        $res = DB::table($this->table)->insert($attr);
        return $res;
    }

    public function getAttr($attr_id)
    {
        $attr = DB::table($this->table)->where('attr_id',$attr_id)->first();
        return $attr;
    }

    public function updateAttr($attr_id,$attr)
    {
        $res = DB::table($this->table)->where('attr_id',$attr_id)->update($attr);
        return $res;
    }

    public function getValueByAttr($attr)
    {
        $values = DB::table('mi_attribute')
            ->leftJoin('mi_attribute_value','mi_attribute.attr_id','=','mi_attribute_value.attr_id')
            ->where('mi_attribute.attr_id',$attr)
            ->select('mi_attribute.attr_id','mi_attribute.attr_name','mi_attribute_value.attr_value_id','mi_attribute_value.attr_value_name')
            ->get();
        return $values;
    }
}