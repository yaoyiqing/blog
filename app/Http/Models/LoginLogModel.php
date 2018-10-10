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

    /*
     * 通过用户id查找登录日志并根据登录时间排序
     */
    public function getLoginCountById($user_id)
    {
        $data = DB::table($this->table)->where('user_id',$user_id)->orderBy('login_time')->get();
        return $data;
    }

    /*
     * 根据用户id以及日志表的自增id修改单条数据
     */
    public function saveLoginLogByUser($user_id,$login_id,$data)
    {
        $result = DB::table($this->table)->where('user_id',$user_id)->where('user_login_id',$login_id)->update($data);
        return $result;
    }
}