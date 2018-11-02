<?php
/**
 * Created by PhpStorm.
 * User: 姚以清
 * Date: 2018/10/24
 * Time: 8:33
 */

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Services\Admin\AttrValueService;
use App\Services\Admin\CateService;
use App\Services\Admin\GoodsService;
use \Illuminate\Http\Request;
use App\Services\Admin\AttributeService;

class GoodsController extends Controller
{
    public function goodsList()
    {
        $service = new GoodsService();
        $goods = $service->getAllGoods();
        return view('mi.backend.goodslist',['goods'=>$goods]);
    }

    public function addGoods()
    {
        $service = new CateService();
        $cates = $service->cateList();
        return view('mi.backend.addgoods',['cates'=>$cates]);
    }

    public function doAddGoods(Request $request)
    {
        $this->validate($request,[
            'goods_name' => 'required',
            'cate_id' => 'required ',
            'attr_value' => 'required',
            'goods_price' => 'required',
            'goods_count' => 'required',
            'goods_number' => 'required',
            'is_sale' => 'required',
            'is_new' => 'required',
            'goods_desc' => 'required',
            'img_desc' => 'required',
            'sku_str' => 'required',
            'sku_name' => 'required',
            'sku_number' => 'required',
            'sku_price' => 'required',
            'sku_count' => 'required',
        ]);
        $service = new GoodsService();
        $res = $service->addGoods($request);
        if($res){
            return $this->success('添加成功','/admin/goodslist');
        }else{
            return $this->error('添加失败','/admin/goodslist');
        }
    }

    public function onsale(Request $request)
    {
        $goodsid = $request->post('goods_id');
        $service = new GoodsService();
        $res = $service->issale($goodsid);
        if($res){
            return $this->goodsList();
        }else{
            return 0;
        }
    }

    public function goodsDetail($goodsid)
    {
        $service = new GoodsService();
        $goods = $service->getGoodsDetail($goodsid);
//        dd($goods);
        return view('mi.backend.goodsdetail',['goods'=>$goods]);
    }

    public function delGoods($goodsId)
    {
        $service = new GoodsService();
        $res = $service->delGoods($goodsId);
        if($res){
            return $this->success('删除成功','/admin/goodslist');
        }else{
            return $this->error('删除失败','/admin/goodslist');
        }
    }

    public function updateGoods($goodsId)
    {
        $cateService = new CateService();
        $cates = $cateService->cateList();
        $service = new GoodsService();
        $goods = $service->updateGoods($goodsId);
        return view('mi.backend.updategoods',['goods'=>$goods,'cates' => $cates]);
    }

    public function doUpdateGoods(Request $request)
    {
//        $this->validate($request,[
//            'goods_name' => 'required',
//            'cate_id' => 'required ',
//            'attr_value' => 'required',
//            'goods_price' => 'required',
//            'goods_count' => 'required',
//            'goods_number' => 'required',
//            'is_sale' => 'required',
//            'is_new' => 'required',
//            'goods_desc' => 'required',
//            'img_desc' => 'required',
//            'sku_str' => 'required',
//            'sku_name' => 'required',
//            'sku_number' => 'required',
//            'sku_price' => 'required',
//            'sku_count' => 'required',
//        ]);
        $input = $request->input();
        dd($input['goods_image']);
    }

    public function cateList()
    {
        $service = new CateService();
        $cates = $service->cateList();
        return view('mi.backend.catelist',['cates'=>$cates]);
    }

    public function delCate($cate_id)
    {
        $service = new CateService();
        $res = $service->delCate($cate_id);
        if($res){
            return $this->success('删除成功','/admin/catelist');
        }else{
            return $this->error('删除失败','/admin/catelist');
        }
    }

    public function addCate()
    {
        $service = new CateService();
        $cates = $service->cateList();
        $attrService = new AttributeService();
        $attrs = $attrService->attrList();
        return view('mi.backend.addcate',['cates'=>$cates,'attrs'=>$attrs]);
    }

    public function doAddCate(Request $request)
    {
//        dd($request);
        $this->validate($request,[
            'cate_name' => 'required | unique:mi_category,cate_name',
            'cate_route' => 'required | unique:mi_category,cate_route',
            'cate_img' => 'required',
            'parent_id' => 'required',
            'attr_id' => 'required',
        ]);
        $service = new CateService();
        $res = $service->addCate($request);
        if($res){
            return $this->success('添加成功','/admin/catelist');
        }else{
            return $this->error('添加失败','/admin/catelist');
        }
    }

    public function updateCate($cateId)
    {
        $service = new CateService();
        $cate = $service->updateCate($cateId);
        $cates = $service->cateList();
        $attrService = new AttributeService();
        $attrs = $attrService->attrList();
        return view('mi.backend.updatecate',['cate'=>$cate,'cates'=>$cates,'attrs'=>$attrs]);
    }

    public function doUpdateCate(Request $request)
    {
        $cate_id = $request->post('cate_id');
        $this->validate($request,[
            'cate_name' => 'required | unique:mi_category,cate_name,' . $cate_id . ',cate_id',
            'cate_route' => 'required | unique:mi_category,cate_route,' . $cate_id . ',cate_id',
            'parent_id' => 'required',
        ]);
        $service = new CateService();
        $res = $service->doUpdateCate($request);
        if($res){
            return $this->success('修改成功','/admin/catelist');
        }else{
            return $this->error('修改失败','/admin/catelist');
        }
    }

    public function attrList()
    {
        $service = new AttributeService();
        $attrs = $service->attrList();
        return view('mi.backend.attrlist',['attrs'=>$attrs]);
    }

    public function addAttr()
    {
        return view('mi.backend.addattr');
    }

    public function doAddAttr(Request $request)
    {
        $this->validate($request,[
            'attr_name' => 'required | unique:mi_attribute,attr_name',
        ]);
        $input = $request->input();
        $service = new AttributeService();
        $res = $service->addAttr($input);
        if($res){
            return $this->success('添加成功','/admin/attrlist');
        }else{
            return $this->error('添加失败','/admin/attrlist');
        }
    }

    public function delAttr($attr_id)
    {
        $service = new AttributeService();
        $res = $service->delAttr($attr_id);
        if($res){
            return $this->success('删除成功','/admin/attrlist');
        }else{
            return $this->error('删除失败','/admin/attrlist');
        }
    }

    public function updateAttr($attr_id)
    {
        $service = new AttributeService();
        $attr = $service->getAttr($attr_id);
        return view('mi.backend.updateattr',['attr'=>$attr]);
    }

    public function doUpdateAttr(Request $request)
    {
        $attr_id = $request->post('attr_id');
        $this->validate($request,[
            'attr_name' => 'required | unique:mi_attribute,attr_name,' . $attr_id . ',attr_id',
        ]);
        $input = $request->input();
        $service = new AttributeService();
        $res = $service->updateAttr($attr_id,$input);
        if($res){
            return $this->success('修改成功','/admin/attrlist');
        }else{
            return $this->error('修改失败','/admin/attrlist');
        }
    }

    public function attrValueList()
    {
        $service = new AttrValueService();
        $values = $service->valueList();
        return view('mi.backend.attrvaluelist',['values'=>$values]);
    }

    public function addAttrValue()
    {
        $service = new AttributeService();
        $attrs = $service->attrList();
        return view('mi.backend.addattrvalue',['attrs'=>$attrs]);
    }

    public function doAddValue(Request $request)
    {
        $this->validate($request,[
//             | unique:mi_attribute_value,value_name
            'attr_value_name' => 'required',
            'attr_id' => 'required',
        ]);
        $input = $request->input();
//        dd($input);
        $service = new AttrValueService();
        $res = $service->doAddValue($input);
        if($res){
            return $this->success('添加成功','/admin/attrvaluelist');
        }else{
            return $this->error('添加失败','/admin/attrvaluelist');
        }
    }

    public function delValue($value_id)
    {
        $service = new AttrValueService();
        $res = $service->delValue($value_id);
        if($res){
            return $this->success('删除成功','/admin/attrvaluelist');
        }else{
            return $this->error('删除失败','/admin/attrvaluelist');
        }
    }

    public function updateValue($value_id)
    {
        $service = new AttrValueService();
        $attrService = new AttributeService();
        $attrs = $attrService->attrList();
        $value = $service->getValue($value_id);
        return view('mi.backend.updateattrvalue',['attrs'=>$attrs,'value'=>$value]);
    }

    public function doUpdateAttrValue(Request $request)
    {
        $valueId = $request->post('attr_value_id');
        $this->validate($request,[
            'attr_value_name' => 'required',
            'attr_id' => 'required',
        ]);
        $input = $request->input();
        $service = new AttrValueService();
        $res = $service->updateValue($valueId,$input);
        if($res){
            return $this->success('修改成功','/admin/attrvaluelist');
        }else{
            return $this->error('修改失败','/admin/attrvaluelist');
        }
    }

    public function getAttrByCate(Request $request)
    {
        $cateId = $request->post('cate');
//        return  $cateId;
        $service = new AttributeService();
        $attrs = $service->getAttrByCate($cateId)->toArray();
        return $attrs;
    }

    public function getValueByAttr(Request $request)
    {
        $attrs = $request->post('attr');
        $service = new AttributeService();
        $attrs = $service->getValueByAttr($attrs);
        return $attrs;
    }
}