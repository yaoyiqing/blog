<?php
/**
 * Created by PhpStorm.
 * User: 姚以清
 * Date: 2018/10/26
 * Time: 14:41
 */

namespace App\Http\Models\Admin;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class AttrValueModel extends Model
{
    protected $table = 'mi_attribute_value';

    public $timestamps = false;

    protected $primaryKey= 'attr_value_id';

    public function getValues()
    {
        $values = $this->leftJoin('mi_attribute','mi_attribute.attr_id','=','mi_attribute_value.attr_id')
            ->where('mi_attribute_value.is_delete',1)
            ->paginate(20);
        return $values;
    }

    public function addValue($value)
    {
        $res = DB::table($this->table)->insert($value);
        return $res;
    }

    public function delValue($value_id)
    {
        $res = DB::table($this->table)->where('attr_value_id',$value_id)->update(['is_delete'=>0]);
        return $res;
    }

    public function getValue($value_id)
    {
        $value = DB::table($this->table)->where('attr_value_id',$value_id)->first();
        return $value;
    }

    public function updateValue($valueId,$value)
    {
        $res = DB::table($this->table)->where('attr_value_id',$valueId)->update($value);
        return $res;
    }
}