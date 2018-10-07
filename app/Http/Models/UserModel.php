<?php

namespace App\Http\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class UserModel extends Model
{
    protected $table = 'mi_user';

    public $timestamps = false;

    protected $primaryKey= 'user_id';

    public function registerUser($user)
    {
        $res = DB::table($this->table)->insert($user);
        if($res){
            return true;
        }else{
            return false;
        }
    }

    public function getUserinfoById($user_id)
    {
        $userinfo = DB::table($this->table)->find($user_id);
        return $userinfo;
    }

    public function getUserinfoByName($username)
    {
        $userinfo = DB::table($this->table)->where('username',$username)->first();
        return $userinfo;
    }
}
