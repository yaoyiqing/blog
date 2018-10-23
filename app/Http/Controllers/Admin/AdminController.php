<?php
/**
 * Created by PhpStorm.
 * User: 姚以清
 * Date: 2018/10/15
 * Time: 21:15
 */

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Models\Admin\ButtonModel;
use App\Http\Models\Admin\MenuModel;
use App\Http\Models\Admin\RoleModel;
use App\Services\Admin\AdminUserService;
use App\Services\Admin\ButtonService;
use App\Services\Admin\MenuService;
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
     * 给管理员分配角色
     */
    public function roleForAdmin($userId)
    {
        $service = new AdminUserService();
        $user = $service->roleForAdmin($userId);
//        dd($user);
        return view('mi.backend.roleforuser',['user'=>$user['userinfo'],'roles'=>$user['roles'],'roleForUser'=>$user['roleforuser']]);
    }

    public function doRoleForAdmin(Request $request)
    {
        $info = $request->input();
        $this->validate($request,[
            'role_name' => 'required',
        ]);
        $service = new AdminUserService();
        $res = $service->doRoleForUser($info);
        if($res){
            return $this->success('分配角色成功','/admin/list');
        }else{
            return $this->error('分配角色失败','/admin/list');
        }
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
            'role_name' => 'required | unique:mi_admin_role,role_name,' . $roleId . ',role_id',
        ]);
        $service = new RoleService();
        $role = $request->input();
        $res = $service->doUpdateRole($roleId,$role);
        if($res){
            return $this->success('修改成功','/admin/rolelist');
        }else{
            return $this->error('修改失败','/admin/rolelist');
        }
    }

    /*
     * 权限列表
     */
    public function menuList()
    {
        $service = new MenuService();
        $menus = $service->menuList();
         return view('mi.backend.menuList',['menus'=>$menus]);
    }

    /*
     * 删除权限
     */
    public function delMenu($menu_id)
    {
        $service = new MenuService();
        $result = $service->delMenu($menu_id);
        if($result){
            return $this->success('删除权限成功','/admin/menulist');
        }else{
            return $this->error('删除权限失败','/admin/menulist');
        }
    }

    public function addMenu()
    {
        $service = new MenuService();
        $menus = $service->menuList();
        return view('mi.backend.addmenu',['menus'=>$menus]);
    }

    public function doAddMenu(Request $request)
    {
        $this->validate($request,[
            'text' => 'required | unique:mi_admin_menu,text',
            'url' => 'unique:mi_admin_menu',
            'is_menu' => 'required',
            'parent_id' => 'required',
        ]);
        $menu = $request->input();
        $service = new MenuService();
        $res = $service->addMenu($menu);
        if($res){
            return $this->success('添加权限成功','/admin/menulist');
        }else{
            return $this->success('添加权限失败','/admin/menulist');
        }
    }

    public function updateMenu($menuId)
    {
        $service = new MenuService();
        $menu = $service->updateMenu($menuId);
        return view('mi.backend.updatemenu',['menu'=>$menu]);
    }

    public function doUpdateMenu(Request $request)
    {
        $menuId = $request->post('menu_id');
        $this->validate($request,[
            'text' => 'required | unique:mi_admin_menu,text,' . $menuId . ',menu_id',
            'url' => 'unique:mi_admin_menu,url,' . $menuId . ',menu_id',
            'is_menu' => 'required',
            'parent_id' => 'required',
        ]);
        $menu = $request->input();
        $service = new MenuService();
        $res = $service->doUpdateMenu($menuId,$menu);
        if($res){
            return $this->success('修改权限成功','/admin/menulist');
        }else{
            return $this->success('修改权限失败','/admin/menulist');
        }
    }

    public function buttonList()
    {
        $service = new ButtonService();
        $buttons = $service->getButtons();
        return view('mi.backend.buttonlist',['buttons'=>$buttons]);
    }

    public function delButton($buttonId)
    {
        $service = new ButtonService();
        $res = $service->delButton($buttonId);
        if($res){
            return $this->success('删除按钮成功','/admin/buttonlist');
        }else{
            return $this->error('删除按钮失败','/admin/buttonlist');
        }
    }

    public function addButton()
    {
        $service = new ButtonService();
        $menus = $service->addButton();
        return view('mi.backend.addbutton',['menus'=>$menus]);
    }

    public function doAddButton(Request $request)
    {
        $this->validate($request,[
            'button_name' => 'required | unique:mi_admin_button,button_name',
            'menu_id' => 'required',
        ]);
        $button = $request->input();
        $service = new ButtonService();
        $res = $service->doAddButton($button);
        if($res){
            return $this->success('添加按钮成功','/admin/buttonlist');
        }else{
            return $this->error('添加按钮失败','/admin/buttonlist');
        }
    }

    public function updateButton($buttonId)
    {
        $service = new ButtonService();
        $buttoninfo = $service->updateButton($buttonId);
        return view('mi.backend.updatebutton',['button'=>$buttoninfo,'menus'=>$buttoninfo->menus]);
    }

    public function doUpdateButton(Request $request)
    {
        $buttonId = $request->post('button_id');
        $this->validate($request,[
            'button_name' => 'required | unique:mi_admin_button,button_name,' . $buttonId . ',button_id',
            'menu_id' => 'required',
        ]);
        $info = $request->input();
        $service = new ButtonService();
        $res = $service->doUpdateButton($buttonId,$info);
        if($res){
            return $this->success('修改按钮成功','/admin/buttonlist');
        }else{
            return $this->error('修改按钮失败','/admin/buttonlist');
        }
    }
}