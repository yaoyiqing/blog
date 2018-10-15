<?php
/**
 * Created by PhpStorm.
 * User: 姚以清
 * Date: 2018/10/10
 * Time: 13:47
 */

namespace App\Services;

use App\Http\Models\CateModel;
use App\Http\Models\GoodsModel;
use App\Http\Models\NavModel;

class IndexService
{
    protected $_cateModel;
    protected $_navModel;
    protected $_goodsModel;

    public function __construct()
    {
        $this->_cateModel = new CateModel();
        $this->_navModel = new NavModel();
        $this->_goodsModel = new GoodsModel();
    }

    /*
     * 导航
     */
    public function getNav()
    {
        $navs = $this->_navModel->getNavgate();
        return $navs;
    }

    /*
     * 分类
     */
    public function getCate()
    {
        $cates = $this->_cateModel->getCategory();
        return $cates;
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

    /*
     * 数组转对象
     */
    public function arrayToObject($e)
    {

        if (gettype($e) != 'array') return;
        foreach ($e as $k => $v) {
            if (gettype($v) == 'array' || getType($v) == 'object')
                $e[$k] = (object)$this->arrayToObject($v);
        }
        return (object)$e;
    }

    public function getSonCates($arr,$path=0)
    {
        $arr = $this->objectToArray($arr);
        $data = [];
        foreach($arr as $key => $val){
            //如果当前的父级id是上条记录的权限id
            foreach($val as $k => $cate){
//                dd($cate);
                if($cate['parent_id'] == $path){
                    $data[$k] = $cate;
                    $data[$k]['son'] = $this->getSonCates($arr,$cate['cate_id']);
                }
            }
        }
        return $data;
    }

    public function getGoodsToShow()
    {
        $singleGoods = $this->_goodsModel->getGoodsByCateOrder('1',5);
        return $singleGoods;
//        dd($singleGoods);
    }

    /*
     * 配件
     */
    public function getPartsToShow()
    {
        $parts = $this->_goodsModel->getGoodsByCateOrder('7',4);
        return $parts;
    }
}