<?php
/**
 * Created by PhpStorm.
 * User: 姚以清
 * Date: 2018/10/16
 * Time: 14:32
 */

namespace App\Services\Admin;


use App\Http\Models\CateModel;

class CateService
{
    public function addCate($cate)
    {
        $model = new CateModel();
        $result = $model->addCategory($cate);
        if($result){
            return true;
        }else{
            return false;
        }
    }
}