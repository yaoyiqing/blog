<?php
/**
 * Created by PhpStorm.
 * User: 姚以清
 * Date: 2018/10/26
 * Time: 9:38
 */

namespace App\Services\Admin;


use App\Http\Models\Admin\AttributeModel;
use App\Http\Models\Admin\CateAttrModel;

class AttributeService
{
    public function attrList()
    {
        $model = new AttributeModel();
        $attrs = $model->getAttrs();
        return $attrs;
    }

    public function addAttr($input)
    {
        $attr = [
            'attr_name' => $input['attr_name'],
            'is_delete' => 1,
        ];
        $model = new AttributeModel();
        $res = $model->addAttr($attr);
        if($res){
            return true;
        }else{
            return false;
        }
    }

    public function delAttr($attr_id)
    {
        $model = new AttributeModel();
        $res = $model->delAttr($attr_id);
        if($res){
            return true;
        }else{
            return false;
        }
    }

    public function getAttr($attr_id)
    {
        $model = new AttributeModel();
        $attr = $model->getAttr($attr_id);
        return $attr;
    }

    public function updateAttr($attr_id,$input)
    {
        $attr = [
            'attr_name' => $input['attr_name'],
        ];
        $model = new AttributeModel();
        $res = $model->updateAttr($attr_id,$attr);
        if($res){
            return true;
        }else{
            return false;
        }
    }

    public function getAttrByCate($cateId)
    {
        $model = new CateAttrModel();
        $attrs = $model->getCateAndAttrs($cateId);
        return $attrs;
    }

    public function getValueByAttr($attrs)
    {
        $model = new AttributeModel();
        $values = [];
        if($attrs){
            foreach($attrs as $attr){
                $values[] = $model->getValueByAttr($attr);
            }
        }
        $attrs = [];
        foreach($values as $key => $value){
            foreach($value as $val){
                $attrs[$key][] = $val;
            }
        }
        return $attrs;
    }
}