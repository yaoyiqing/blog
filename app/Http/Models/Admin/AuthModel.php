<?php
/**
 * Created by PhpStorm.
 * User: 姚以清
 * Date: 2018/10/18
 * Time: 9:35
 */

namespace App\Http\Models\Admin;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class AuthModel
{
    protected $table = 'mi_admin_menu';

    public $timestamps = false;

    protected $primaryKey= 'menu_id';

    /*
     * 查询所有权限
     */
    public function allAuthOfMenu()
    {
        $allAuthOfMenu = DB::table($this->table)->orderBy('path')->get();
        return $allAuthOfMenu;
    }
}