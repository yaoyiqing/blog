<?php
/**
 * Created by PhpStorm.
 * User: 姚以清
 * Date: 2018/10/15
 * Time: 21:15
 */

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Models\Admin\RoleModel;
use App\Services\Admin\AdminUserService;
use App\Services\Admin\RoleService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class AdminController extends Controller
{
    public function login()
    {
        return view('auth.login');
    }

    public function doLogin(Request $request)
    {
        //验证数据
        $this->validate($request,[
            'email' => 'required',
            'password' => 'required',
        ]);
        //调用service层的登录方法
        $service = new AdminUserService();
        $user = $request->input();
        $result = $service->login($user);
        // 根据service层登录方法的返回值判断执行相应的结果（跳转/返回错误信息）
        if($result){
            return $this->success('登录成功','/admin');
        }else{
            return $this->error('登录失败','/admin/login');
        }
    }

    public function register()
    {
        return view('auth.register');
    }

    public function regist()
    {
        return;
    }

    public function logout()
    {
        Session::forget('user');
        return $this->success('退出成功','/admin/login');
    }

    public function list()
    {
        $service = new AdminUserService();
        $admins = $service->getAdminList();
//        dd($admins);
        return view('mi.backend.adminlist',['admins' => $admins]);
    }

    public function add()
    {
        $roleService = new RoleService();
        $roles = $roleService->roleList();
        return view('mi.backend.adminadd',['roles' => $roles]);
    }

    public function doAdd(Request $request){
        // 验证表单数据
        $this->validate($request,[
            'user_name' => 'required',
            'user_email' => 'required | unique:mi_admin_user,user_email',
            'mobile' => ['required','unique:mi_admin_user,mobile','regex:/^1[345678][0-9]{9}$/'],
            'create_name' => 'required',
            'is_supper' => 'required',
            'role_id' => 'required',
        ]);
//        dd($request->input());
        // 调用service层方法
        $service = new AdminUserService();
        $info = $request->input();
        $result = $service->addAdmin($info);
        // 判断service层的返回值
        if($result){
            return $this->success('添加管理员成功','/admin/list');
        }else{
            return $this->error('添加管理员失败','/admin/add');
        }
    }

    /*
     * 冻结管理员
     */
    public function freeze(Request $request)
    {
        $userid = $request->post('user_id');
        $service = new AdminUserService();
        $res = $service->isFreeze($userid);
        if($res){
            return $this->list();
        }else{
            return 0;
        }
    }

    /*
     * 修改管理员资料
     */
    public function update($user_id)
    {
        $service = new AdminUserService();
        $userinfo = $service->update($user_id);
        if($userinfo)
        return view('mi.backend.updateadmin',['userinfo'=>$userinfo]);
    }

    public function doUpdate(Request $request)
    {
        $info = $request->input();
        $this->validate($request,[
            'user_name' => 'required',
            'user_email' => 'required | unique:mi_admin_user,user_email,'.$info["user_id"].',user_id',
            'mobile' => ['required','unique:mi_admin_user,mobile,'.$info["user_id"].',user_id','regex:/^1[345678][0-9]{9}$/'],
        ]);
        $service = new AdminUserService();
        $res = $service->doUpdate($info);
        if($res){
            return $this->success('修改资料成功','/admin/list');
        }else{
            return $this->error('修改资料失败','/admin/list');
        }
    }

    /*
     * 查看管理员详情
     */
    public function adminDetail($user_id)
    {
        $service = new AdminUserService();
        $admin = $service->getSingleDetail($user_id);
        return view('mi.backend.admindetail',['admin'=>$admin]);
    }

    /*
     * 添加角色
     */
    public function addRole()
    {
        $service = new RoleService();
        $menus = $service->allMenu();
        return view('mi.backend.addrole',['menus'=>$menus]);
    }

    public function doAddRole(Request $request)
    {
        // 验证表单数据
        $this->validate($request,[
            'role_name' => 'required | unique:mi_admin_role,role_name',
        ]);
        $service = new RoleService();
        $role = $request->input();
        $res = $service->addRole($role);
        if($res){
            return $this->success('添加角色成功','/admin/rolelist');
        }else{
            return $this->error('添加角色失败','/admin/addrole');
        }
    }

    /*
     * 角色列表
     */
    public function roleList()
    {
        $service = new RoleService();
        $roles = $service->roleList();
        return view('mi.backend.rolelist',['roles' => $roles]);
    }

    /*
     * 删除角色
     */
    public function delRole($role_id)
    {
        $service = new RoleService();
        $res = $service->delRole($role_id);
        if($res){
            return $this->success('删除成功','/admin/rolelist');
        }else{
            return $this->error('删除失败','/admin/rolelist');
        }
    }

    /*
     * 角色详情
     */
    public function roleDetail($role_id)
    {
        $service = new RoleService();
        $service->getAuthByRole($role_id);
        $arr = $service->getAuthByRole($role_id);
//        dd($arr);
        return view('mi.backend.singlerole',['menus'=>$arr['menus'],'role'=>$arr['role']]);
    }

    /*
     * 修改角色及权限
     */
    public function updateRole($role_id)
    {
        $service = new RoleService();
        $data = $service->updateRole($role_id);
//        dd($data['menus']);
        return view('mi.backend.updaterole',['role'=>$data['role'],'resource'=>$data['roleResource'],'menus'=>$data['menus']]);
    }

    public function doUpdateRole(Request $request)
    {
        $roleId = $request->post('role_id');
        $this->validate($request,[
            'role_name' => 'required | unique:mi_admin_role,role_name,' . $roleId . ',role_ids',
        ]);
    }
}