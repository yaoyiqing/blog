<?php
/**
 * Created by PhpStorm.
 * User: 姚以清
 * Date: 2018/10/23
 * Time: 13:35
 */

namespace App\Services\Admin;


use App\Http\Models\Admin\ButtonModel;
use App\Http\Models\Admin\MenuModel;
use function Couchbase\defaultDecoder;

class ButtonService
{
    public function getButtons()
    {
        $model = new ButtonModel();
        $buttons = $model->buttonAndMenu();
        return $buttons;
    }

    public function delButton($buttonId)
    {
        $model = new ButtonModel();
        $res = $model->delButton($buttonId);
        if($res){
            return true;
        }else{
            return false;
        }
    }

    public function addButton()
    {
        $model = new MenuModel();
        $menus = $model->getMenu();
        return $menus;
    }

    public function doAddButton($button)
    {
        $data = [
            'button_name' => $button['button_name'],
            'menu_id' => $button['menu_id'],
        ];
        $model = new ButtonModel();
        $res = $model->addButton($data);
        if($res){
            return true;
        }else{
            return false;
        }
    }

    public function updateButton($buttonId)
    {
        $model = new ButtonModel();
        $button = $model->getButtonToShow($buttonId);
        $menuModel = new MenuModel();
        $button->menus = $menuModel->getMenu();
        return $button;
    }

    public function doUpdateButton($buttonId,$button)
    {
        $data = [
            'button_name' => $button['button_name'],
            'menu_id' => $button['menu_id'],
        ];
        $model = new ButtonModel();
        $res = $model->updateButton($buttonId,$data);
        if($res){
            return true;
        }else{
            return false;
        }
    }
}