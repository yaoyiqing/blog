<?php
/**
 * Created by PhpStorm.
 * User: 姚以清
 * Date: 2018/10/26
 * Time: 11:59
 */

namespace App\Services\Admin;

use App\Http\Models\Admin\AttrValueModel;

class AttrValueService
{
    public function valueList()
    {
        $model = new AttrValueModel();
        $values = $model->getValues();
        return $values;
    }

    public function doAddValue($input)
    {
        $value = [
            'attr_value_name' => $input['attr_value_name'],
            'attr_id' => $input['attr_id'],
            'is_delete' => 1,
        ];
        $model = new AttrValueModel();
        $res = $model->addValue($value);
        if($res){
            return true;
        }else{
            return false;
        }
    }

    public function delValue($value_id)
    {
        $model = new AttrValueModel();
        $res = $model->delValue($value_id);
        if($res){
            return true;
        }else{
            return false;
        }
    }

    public function getValue($value_id)
    {
        $model = new AttrValueModel();
        $value = $model->getValue($value_id);
        return $value;
    }

    public function updateValue($valueId,$input)
    {
        $value = [
            'attr_value_name' => $input['attr_value_name'],
            'attr_id' => $input['attr_id'],
        ];

        $model = new AttrValueModel();
        $res = $model->updateValue($valueId,$value);
        if($res){
            return true;
        }else{
            return false;
        }
    }
}