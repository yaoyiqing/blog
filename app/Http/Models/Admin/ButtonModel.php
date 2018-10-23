<?php
/**
 * Created by PhpStorm.
 * User: 姚以清
 * Date: 2018/10/23
 * Time: 10:08
 */

namespace App\Http\Models\Admin;


use Illuminate\Support\Facades\DB;

class ButtonModel
{
    protected $table = 'mi_admin_button';

    public $timestamps = false;

    protected $primaryKey= 'button_id';

    public function buttonAndMenu()
    {
        $buttons = DB::table('mi_admin_button')
            ->join('mi_admin_menu','mi_admin_button.menu_id','=','mi_admin_menu.menu_id')
            ->get();
        return $buttons;
    }

    public function delButtonByMneu($menuId)
    {
        $res = DB::table($this->table)->where('menu_id',$menuId)->delete();
        return $res;
    }

    public function delButton($buttonId)
    {
        $res = DB::table($this->table)->where('button_id',$buttonId)->delete();
        return $res;
    }

    public function addButton($button)
    {
        $res = DB::table($this->table)->insert($button);
        return $res;
    }

    public function getButtonToShow($buttonId)
    {
        $button = DB::table('mi_admin_button')
            ->join('mi_admin_menu','mi_admin_button.menu_id','=','mi_admin_menu.menu_id')
            ->where('button_id','=',$buttonId)
            ->first();
        return $button;
    }

    public function updateButton($buttonId,$button)
    {
        $res = DB::table($this->table)->where('button_id',$buttonId)->update($button);
        return $res;
    }
}