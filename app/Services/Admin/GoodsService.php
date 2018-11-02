<?php
/**
 * Created by PhpStorm.
 * User: 姚以清
 * Date: 2018/10/24
 * Time: 8:36
 */

namespace App\Services\Admin;

use App\Http\Models\Admin\CategoryModel;
use App\Http\Models\Admin\GoodsAttrModel;
use App\Http\Models\Admin\GoodsImgModel;
use App\Http\Models\Admin\GoodsSkuModel;
use App\Http\Models\GoodsModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class GoodsService
{
    public function getAllGoods()
    {
        $model = new GoodsModel();
        $goods = $model->getGoodsAndCate();
        return $goods;
    }

    public function addGoods($request)
    {
        $input = $request->input();

        $goodsModel = new GoodsModel();
        $goodsAttrModel = new GoodsAttrModel();
        $skuModel = new GoodsSkuModel();
        $imgModel = new GoodsImgModel();
        $time = time();

        if(!$request->file('goods_img')){
            $goods = [
                'goods_name' => $input['goods_name'],
                'goods_price' => $input['goods_price'],
                'goods_count' => $input['goods_count'] ? $input['goods_count'] : array_sum($input['sku_count']),
                'goods_number' => $input['goods_number'],
                'is_sale' => $input['is_sale'],
                'is_new' => $input['is_new'],
                'goods_desc' => $input['goods_desc'],
                'cate_id' => $input['cate_id'],
                'is_delete' => 1,
                'add_time' => $time,
                'update_time' => $time,
                'promotion_price' => $input['goods_price'],
            ];
        }else{
            $upload = $this->postFileupload($request);
            $goods = [
                'goods_name' => $input['goods_name'],
                'goods_price' => $input['goods_price'],
                'goods_count' => $input['goods_count'] ? $input['goods_count'] : array_sum($input['sku_count']),
                'goods_number' => $input['goods_number'],
                'is_sale' => $input['is_sale'],
                'is_new' => $input['is_new'],
                'goods_desc' => $input['goods_desc'],
                'cate_id' => $input['cate_id'],
                'goods_img' => $upload[0],
                'img_desc' => $input['img_desc'][0],
                'is_delete' => 1,
                'add_time' => $time,
                'update_time' => $time,
                'promotion_price' => $input['goods_price'],
            ];
        }

        $skus = [
            'sku_name' => $input['goods_name'] . ',' . $input['sku_name'],
            'sku_number' => $input['sku_number'],
            'sku_count' => $input['sku_count'],
            'sku_price' => $input['sku_price'],
            'sku_str' => $input['sku_str'],
        ];

        $result = true;
        DB::beginTransaction();
        try{

            $goods_id = $goodsModel->addGoods($goods);

            $sku = [];
            foreach($skus as $key => $value){
                foreach($value as $k => $val){
                    $sku[$k][$key] = $val;
                    $sku[$k]['create_time'] = $time;
                    $sku[$k]['update_time'] = $time;
                    $sku[$k]['goods_id'] = $goods_id;
                }
            }
            $skuModel->addSkus($sku);

            $attr = [];
            $i = 0;
            foreach($input['attr_value'] as $key => $value){
                foreach($value as $k => $val){
                    $attr[$i]['attr_id'] = $key;
                    $attr[$i]['attr_value_id'] = $val;
                    $attr[$i]['goods_id'] = $goods_id;
                    $i++;
                }
            }
            $goodsAttrModel->addGoodsAttrs($attr);

            $uploads['goods_img'] = $upload;
            $uploads['img_desc'] = $input['img_desc'];
            $imgs = [];
            foreach($uploads as $key => $val){
                foreach($val as $k => $v){
                    $imgs[$k][$key]=$v;
                    $imgs[$k]['goods_id'] = $goods_id;
                }
            }

            $imgModel->addGoodsImgs($imgs);

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

    public function issale($goodsid)
    {
        $model = new GoodsModel();
        $goods = $model->getGoodsById($goodsid);
        $goods->is_sale == 1 ? $goods->is_sale = 0 : $goods->is_sale = 1;
        $goods = $this->objectToArray($goods);
        $res = $model->updateStatus($goodsid,$goods);
        if($res){
            return true;
        }else{
            return false;
        }
    }

    public function delGoods($goodsId)
    {
        $model = new GoodsModel();
        $res = $model->delGoods($goodsId);
        if($res){
            return true;
        }else{
            return false;
        }
    }

    public function getGoodsDetail($goodsid)
    {
        $model = new GoodsModel();
        $goods = $model->getGoodsDetailById($goodsid);
        return $goods;
    }

    public function updateGoods($goodsId)
    {
        $model = new GoodsModel();
        $goods = $model->getGoodsDetailById($goodsId);
        return $goods;
    }

    /*
     * 对象转数组
     */
    public function objectToArray($e)
    {
        $e = (array)$e;
        foreach ($e as $k => $v) {
            if (gettype($v) == 'resource') return;
            if (gettype($v) == 'object' || gettype($v) == 'array')
                $e[$k] = (array)$this->objectToArray($v);
        }
        return $e;
    }

    // 文件上传处理
    public function postFileupload(Request $request){
        $file = $request->file('goods_img');
        $filePath = [];
        foreach($file as $key => $value){
            // 判断文件上传过程中是否出错
            if(!$value->isValid()){
                exit('文件上传出错！');
            }
            $destPath = realpath(public_path('mi/images/goods'));
            if(!file_exists($destPath))
                mkdir($destPath,0777,true);
            $sufName = $value->getClientOriginalExtension();
            $filename = date("YmdHis",time()) . rand(1000,9999) . '.' . $sufName;
            if(!$value->move($destPath,$filename)){
                exit('保存文件失败！');
            }
            $filePath[] = '/mi/images/goods/' . $filename;
        }
        return $filePath;
    }
}