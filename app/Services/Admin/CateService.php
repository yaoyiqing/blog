<?php
/**
 * Created by PhpStorm.
 * User: 姚以清
 * Date: 2018/10/16
 * Time: 14:32
 */

namespace App\Services\Admin;


use App\Http\Models\Admin\AttributeModel;
use App\Http\Models\Admin\CateAttrModel;
use App\Http\Models\CateModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CateService
{

    public function addCate($request)
    {
        $input = $request->input();
        $upload = $this->postFileupload($request);
        if($upload){
            $cate = [
                'cate_name' => $input['cate_name'],
                'cate_route' => $input['cate_route'],
                'cate_img' => $upload,
                'parent_id' => $input['parent_id'],
                'is_delete' => 1,
            ];
            $cateModel = new CateModel();
            $model = new CateAttrModel();
            $insertId = $cateModel->addCategory($cate);
            if($insertId){
                if($input['parent_id'] == 0){
                    $cates = [
                        'path' => $insertId,
                    ];
                }else{
                    $parentCate = $cateModel->getCate($input['parent_id']);
                    $path = $parentCate->path;
                    $cates = [
                        'path' => $path . '-' . $insertId,
                    ];
                }
                $attrs = [];
                foreach($input as $key => $attr){
                    if($key == 'attr_id'){
                        foreach($attr as $id){
                            $attrs[] = [
                                'cate_id' => $insertId,
                                'attr_id' => $id,
                            ];
                        }
                    }
                }

                $result = true;
                DB::beginTransaction();
                try{
                    $cateModel->updateCateById($insertId,$cates);
                    $model->addValues($attrs);
                    DB::commit();
                }catch(\Exception $e){
                    $result = false;
                    $e->getMessage();
                    DB::rollBack();
                }

                if($result){
                    return true;
                }else{
                    return false;
                }
            }else{
                return false;
            }
        }else{
            return false;
        }
    }

    public function cateList()
    {
        $model = new CateModel();
        $cates = $model->getCates();
        return $cates;
    }

    public function delCate($cate_id)
    {
        $model = new CateModel();
        $result = true;
        DB::beginTransaction();
        try{
            $model->delCate($cate_id);
            $model->delCateByParent($cate_id);
            DB::commit();
        }catch(\Exception $e){
            $result = false;
            $e->getMessage();
            DB::rollBack();
        }
        if($result){
            return true;
        }else{
            return false;
        }
    }

    public function updateCate($cateId)
    {
        $model = new CateModel();
        $cate = $model->getCate($cateId);
        $attrModel = new CateAttrModel();
        $cate->attrs = $attrModel->getAttrsByCate($cateId);
        $attrs = [];
        foreach ($cate->attrs as $attr){
            foreach($attr as $key =>$val){
                if($key == 'attr_id'){
                    $attrs[] = $val;
                }
            }
        }
        $cate->attrs = $attrs;
        return $cate;
    }

    public function doUpdateCate($request)
    {
        $input = $request->input();
        $model = new CateModel();
        $cateAttrModel = new CateAttrModel();
        $cate = $model->getCate($input['cate_id']);
        $upload = $this->postFileupload($request);
        if(!$upload){
            $upload = $cate->cate_img;
        }
        if($input['parent_id'] == 0){
            $cate = [
                'cate_name' => $input['cate_name'],
                'cate_route' => $input['cate_route'],
                'cate_img' => $upload,
                'parent_id' => $input['parent_id'],
                'path' => $input['cate_id'],
            ];
        }else{
            $parentCate = $model->getCate($input['parent_id']);
            $path = $parentCate->path;
            $cate = [
                'cate_name' => $input['cate_name'],
                'cate_route' => $input['cate_route'],
                'cate_img' => $upload,
                'parent_id' => $input['parent_id'],
                'path' => $path . '-' . $input['cate_id'],
            ];
        }
        $attrIds = $input['attr_id'];
        $attrs = [];
        foreach($attrIds as $attr){
            $attrs[] = [
                'cate_id' => $input['cate_id'],
                'attr_id' => $attr,
            ];
        }
        $result = true;
        DB::beginTransaction();
        try{
            $model->updateCateById($input['cate_id'],$cate);
            $cateAttrModel->delValuesByCate($input['cate_id']);
            $cateAttrModel->addValues($attrs);
            DB::commit();
        }catch(\Exception $e){
            $result = false;
            $e->getMessage();
            DB::rollBack();
        }
        if($result){
            return true;
        }else{
            return false;
        }
    }






    //文件上传处理
    public function postFileupload(Request $request){
        //判断请求中是否包含name=file的上传文件
        if(!$request->hasFile('cate_img')){
            return false;
        }
        $file = $request->file('cate_img');
        //判断文件上传过程中是否出错
        if(!$file->isValid()){
            exit('文件上传出错！');
        }
        $destPath = realpath(public_path('mi/images/cates'));
        if(!file_exists($destPath))
            mkdir($destPath,0777,true);
        $sufName = $file->getClientOriginalExtension();
        $filename = date("YmdHis",time()) . '.' . $sufName;
        if(!$file->move($destPath,$filename)){
            exit('保存文件失败！');
        }
        return '/mi/images/cates/' . $filename;
    }
}