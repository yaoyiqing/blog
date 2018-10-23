<?php
/**
 * Created by PhpStorm.
 * User: 姚以清
 * Date: 2018/10/8
 * Time: 13:41
 */

namespace App\Http\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class CateModel extends Model
{
    protected $table = 'mi_category';

    public $timestamps = false;

    protected $primaryKey= 'cate_id';

    public function getCategory($column = ['*'])
    {
        $data = DB::table($this->table)->select($column)->get();
        return $data;
    }

    public function addCategory($cate)
    {
        $res = DB::table($this->table)->insert($cate);
        return $res;
    }
}