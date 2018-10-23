<?php
/**
 * Created by PhpStorm.
 * User: 姚以清
 * Date: 2018/10/16
 * Time: 13:44
 */

namespace App\Services\Admin;

use App\Http\Models\Admin\RoleModel;
use App\Http\Models\Admin\UserModel;
use App\Http\Models\Admin\UserRoleModel;
use function Couchbase\defaultDecoder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;

class AdminUserService
{
    public function login($user)
    {
        $model = new UserModel();

        $email = $user['email'];
        $password = $user['password'];

        $info = $model->getUserinfoByName($email);
        $info = $this->objectToArray($info);

        if(!$info || $password != $info['user_pwd']){
            return false;
        }
        $result = $model->lastLoginTime('user_id',$info['user_id'],['last_login_time' => time()]);
        if($result){
            Session::put('user',$info);
            return true;
        }
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
     * 所有管理员信息列表
     */
    public function getAdminList()
    {
        $model = new UserModel();
        $admins = $model->getAdminList();
        return $admins;
    }

    /*
     * 获取指定管理员信息
     */
    public function getSingleDetail($user_id)
    {
        $model = new UserModel();
        $admin = $model->getUserinfo('user_id',$user_id);
        $admin = $this->objectToArray($admin);
        $roles = $model->getRolesOfAdmin($user_id);
        $admin['roles'] = [];
        foreach($roles as $val){
            foreach ($val as $v){
                $admin['roles'][] = $v;
            }
        }
        $admin['roles'] = implode('，',$admin['roles']);
        return $admin;
    }

    /*
     * 添加管理员
     */
    public function addAdmin($info)
    {
        $admin = [
            'user_name' => $info['user_name'],
            'user_email' => $info['user_email'],
            'mobile' => $info['mobile'],
            'create_time' => time(),
            'create_name' => $info['create_name'],
            'update_time' => time(),
            'last_login_time' => 0,
            'is_supper' => $info['is_supper'],
            'is_freeze' => 1,
        ];
        $model = new UserModel();
        $insertId = $model->addAdmin($admin);
        if($insertId){
            $userRole = [
                'user_id' => $insertId,
                'role_id' => $info['role_id'],
            ];
            $userRoleModel = new UserRoleModel();
            $result = $userRoleModel->addUserRole($userRole);
            if($result){
                return true;
            }else{
                return false;
            }
        }else{
            return false;
        }

    }

    /*
     * 冻结与解冻管理员
     */
    public function isFreeze($userid)
    {
        $model = new UserModel();
        $userinfo = $model->getUserinfo('user_id',$userid);

        $userinfo->is_freeze == 1 ? $userinfo->is_freeze = 0 : $userinfo->is_freeze = 1;

        $userinfo = $this->objectToArray($userinfo);
        $res = $model->updateStates($userid,$userinfo);
        if($res){
            return true;
        }else{
            return false;
        }
    }

    /*
     * 修改管理员资料
     */
    public function update($userid)
    {
        $model = new UserModel();
        $userinfo = $model->getUserinfo('user_id',$userid);
        return $userinfo;
    }

    public function doUpdate($info)
    {
        $model = new UserModel();
        $info = [
            'user_id' => $info['user_id'],
            'user_name' => $info['user_name'],
            'user_email' => $info['user_email'],
            'mobile' =>$info['mobile'],
            'update_time' => time(),
        ];
        $res = $model->updateStates($info['user_id'],$info);
        return $res;
    }

    public function roleForAdmin($userId)
    {
        $model = new RoleModel();
        $user['roles'] = $model->allRole();
        $userRoleModel = new UserRoleModel();
        $roleforuser = $userRoleModel->getRoleByUser($userId);
        $user['roleforuser'] = [];
        foreach($roleforuser as $key => $role){
            foreach($role as $k => $val){
                if($k == 'role_id'){
                    $user['roleforuser'][] = $val;
                }
            }
        }
        $userModel = new UserModel();
        $user['userinfo'] = $userModel->getUserinfo('user_id',$userId);
        return $user;
    }

    public function doRoleForUser($info)
    {
        $model = new UserRoleModel();
        foreach($info['role_name'] as $val){
            $rolesOfUser[] = [
                'user_id' => $info['user_id'],
                'role_id' => $val,
            ];
        }
//        dd($rolesOfUser);
        $result = true;
        DB::beginTransaction();
        try{
            $model->delByUser($info['user_id']);
            $model->addUserRole($rolesOfUser);
            DB::commit();
        }catch(\Exception $e){
            $result = false;
            $e->getMessage();
            DB::rollBack();
        }
        if($result){
            return true;
        }else{
            return false;
        }
    }
}