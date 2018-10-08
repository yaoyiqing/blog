<?php
/**
 * Created by PhpStorm.
 * User: 姚以清
 * Date: 2018/10/8
 * Time: 10:45
 */

namespace App\Http\Models;


use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class NavModel extends Model
{
    protected $table = 'mi_navgate';

    public $timestamps = false;

    protected $primaryKey= 'nav_id';

    public function getNavgate($column = ['*'])
    {
        $nav = DB::table($this->table)->select($column)->get();
        return $nav;
    }
}