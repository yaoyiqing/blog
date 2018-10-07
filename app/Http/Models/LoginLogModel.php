<?php
/**
 * Created by PhpStorm.
 * User: 姚以清
 * Date: 2018/10/7
 * Time: 13:47
 */

namespace App\Http\Models;


use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class LoginLogModel extends Model
{
    protected $table = 'mi_user_login_log';

    public $timestamps = false;

    protected $primaryKey= 'user_login_id';

    public function loginLog($log)
    {
        $res = DB::table($this->table)->insert($log);
        if($res){
            return true;
        }else{
            return false;
        }
    }
}