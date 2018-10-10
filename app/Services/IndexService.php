<?php
/**
 * Created by PhpStorm.
 * User: 姚以清
 * Date: 2018/10/10
 * Time: 13:47
 */

namespace App\Services;

use App\Http\Models\CateModel;
use App\Http\Models\NavModel;

class IndexService
{
    protected $_cateModel;
    protected $_navModel;

    public function __construct()
    {
        $this->_cateModel = new CateModel();
        $this->_navModel = new NavModel();
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
}