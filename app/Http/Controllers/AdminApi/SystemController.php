<?php


namespace App\Http\Controllers\AdminApi;


use App\Http\Controllers\Controller;
use App\Http\Requests\adminapi\SystemAdminCreateRequest;
use App\Http\Requests\adminapi\SystemAdminDeleteRequest;
use App\Http\Requests\adminapi\SystemAdminUpdateRequest;
use App\Http\Requests\AdminApi\SystemPermissionsCreateRequest;
use App\Http\Requests\AdminApi\SystemPermissionsDeleteRequest;
use App\Http\Requests\AdminApi\SystemPermissionsUpdateRequest;
use App\Http\Requests\adminapi\SystemRoles2PermissionsUpdateRequest;
use App\Http\Requests\AdminApi\SystemRolesCreateRequest;
use App\Http\Requests\AdminApi\SystemRolesDeleteRequest;
use App\Http\Requests\AdminApi\SystemRolesUpdateRequest;
use App\Models\Admin;
use App\Models\AdminRoute;
use App\Models\Permissions;
use App\Models\Roles;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class SystemController extends Controller
{
    /**
     * 添加权限
     * @param SystemPermissionsCreateRequest $request
     * @param AdminRoute $adminRoute
     * @param Permissions $permissions
     * @return mixed
     */
    function permissions_create(SystemPermissionsCreateRequest $request, AdminRoute $adminRoute)
    {
        $parent_id = $request->input('parent_id');
        if ($parent_id > 0) {
            $adminRouteParent = $adminRoute->newQuery()->find($parent_id);
            $parent_all_id = empty($adminRouteParent->parent_id) ? $parent_id : $adminRouteParent->parent_id . ',' . $parent_id;
            $request->offsetSet('parent_all_id', $parent_all_id);
            $request->offsetSet('level', $adminRouteParent->level + 1);
        }
        DB::beginTransaction();
        $adminRoute->fill($request->toArray())->save();
        Permission::create([
            'name' => $request->input('url'),
        ]);
        DB::commit();
        return self::successReturn();
    }

    /**
     * 跟新权限基础信息
     * @param SystemPermissionsUpdateRequest $request
     * @param AdminRoute $adminRoute
     * @return mixed
     */
    function permissions_update(SystemPermissionsUpdateRequest $request, AdminRoute $adminRoute)
    {
        $adminRouteInfo = $adminRoute->newQuery()->find($request->input('admin_route_id'));
        if (empty($adminRouteInfo)) {
            return self::failReturn(self::THERE_IS_NO_CORRESPONDING_RECORD);
        }

        $request->offsetUnset('url');
        $request->offsetUnset('method');
        //判断更新了父级
        $parent_id = $request->input('parent_id');
        if ($parent_id != $adminRouteInfo['parent_id']) {
            $adminRoute->newQuery()->find($parent_id);
            if ($parent_id > 0) {
                $adminRouteParent = $adminRoute->newQuery()->find($parent_id);
                $parent_all_id = empty($adminRouteParent->parent_id) ? $parent_id : $adminRouteParent->parent_id . ',' . $parent_id;
                $level = $adminRouteParent->level + 1;
            } else {
                $parent_all_id = $parent_id;
                $level = 1;
            }
            $request->offsetSet('parent_all_id', $parent_all_id);
            $request->offsetSet('level', $level);
        }
        $adminRouteInfo->fill($request->toArray())->save();
        return self::successReturn();
    }


    /**
     * 更新权限全部功能(关闭)
     * @param SystemPermissionsUpdateRequest $request
     * @param AdminRoute $adminRoute
     * @return mixed
     */
    function permissions_updatebak(SystemPermissionsUpdateRequest $request, AdminRoute $adminRoute)
    {
        $adminRouteInfo = $adminRoute->newQuery()->find($request->input('admin_route_id'));
        if (empty($adminRouteInfo)) {
            return self::failReturn(self::THERE_IS_NO_CORRESPONDING_RECORD);
        }
        $checkData = $adminRoute->newQuery()->where('admin_route_id', '<>', $adminRouteInfo['admin_route_id'])
            ->where('url', $request->input('url'))
            ->count();
        if ($checkData) {
            return self::failReturn(self::SYSTEM_PERMISSIONS_URL_EXIST);
        }
        DB::beginTransaction();
        $adminRouteRow = clone $adminRouteInfo;
        $adminRouteRow->fill($request->toArray())->save();
        Permission::query()->where('name', $adminRouteInfo['url'])
            ->update([
                'name' => $request->input('url'),
            ]);
        DB::commit();
        return self::successReturn();
    }

    /**
     * 删除权限
     * @param SystemPermissionsDeleteRequest $request
     * @param AdminRoute $adminRoute
     * @param Permissions $permissions
     * @return mixed
     */
    function permissions_delete(SystemPermissionsDeleteRequest $request, AdminRoute $adminRoute)
    {

        $adminRouteInfo = $adminRoute->newQuery()->findOrFail($request->input('admin_route_id'));
        DB::beginTransaction();
        $adminRoute->newQuery()->where('admin_route_id', $request->input('admin_route_id'))->delete();
        Permission::where([
            'name' => $adminRouteInfo->url,
        ])->delete();
        DB::commit();
        return self::successReturn();
    }

    /**
     * 添加管理员
     * @param SystemAdminCreateRequest $request
     * @param Admin $admin
     * @return mixed
     */
    function admin_create(SystemAdminCreateRequest $request, Admin $admin)
    {

        $adminRow = $admin->newQuery()->firstOrCreate([
            'name' => $request->input('name'),
            'mobile' => $request->input('mobile'),
        ], [
            'password' => password_hash($request->input('password'), PASSWORD_DEFAULT),
        ]);

        $role_id = $request->input('role_id');
        if ($role_id > 0) {
            $role = Role::findById($role_id);
            $adminRow->assignRole($role);
        }
        return self::successReturn();
    }

    /**
     * 删除管理员
     * @param SystemAdminDeleteRequest $request
     * @param Admin $admin
     * @return mixed
     */
    function admin_delete(SystemAdminDeleteRequest $request, Admin $admin)
    {
        $admin->newQuery()->where('admin_id', $request->input('admin_id'))->delete();
        return self::successReturn();
    }

    /**
     * 添加身份
     * @param SystemRolesCreateRequest $request
     * @param Roles $roles
     * @return mixed
     */
    function roles_create(SystemRolesCreateRequest $request)
    {
        Role::create(['name' => $request->input('name')]);
        return self::successReturn();
    }


    /**
     * 更新身份
     * @param SystemRolesCreateRequest $request
     * @param Roles $roles
     * @return mixed
     */
    function roles_update(SystemRolesUpdateRequest $request)
    {
        Role::query()->where('id', $request->input('id'))->update([
            'name' => $request->input('name')
        ]);
        return self::successReturn();
    }

    /**
     *
     * @param SystemRoles2PermissionsUpdateRequest $request
     * @return mixed
     */
    function roles2permissions_update(SystemRoles2PermissionsUpdateRequest $request)
    {
        $role = Role::findById($request->input('role_id'));
        if (!$role) {
            return self::failReturn(self::THERE_IS_NO_CORRESPONDING_RECORD);
        }
        $adminRouteIds = array_column(json_decode($request->input('permission_json'), true), 'nodeId');
        DB::beginTransaction();
        $adminRoutes = AdminRoute::query()->whereIn('admin_route_id', $adminRouteIds)->select('url')->get()->pluck('url');
        $permissions = Permission::query()->whereIn('name', $adminRoutes)->get();
        $role->syncPermissions($permissions);
//        $role2PermissionsRemove = $role->permissions()->whereNotIn('name', $adminRoutes)->get();
//        foreach ($role2PermissionsRemove as $permission) {
//            $role->revokePermissionTo($permission);
//        }
//        foreach ($permissions as $permission) {
//            $role->givePermissionTo($permission);
//        }
        DB::commit();
        return self::successReturn();
    }

    /**
     * 删除身份
     * @param SystemRolesDeleteRequest $request
     * @return mixed
     */
    function roles_delete(SystemRolesDeleteRequest $request)
    {
        Role::query()->where('id', $request->input('id'))->delete();
        return self::successReturn();
    }

    /**
     * 更新管理员数据
     * @param SystemAdminDeleteRequest $request
     * @param Admin $admin
     * @return mixed
     */
    function admin_update(SystemAdminUpdateRequest $request, Admin $admin)
    {
        $loginAdminId = Auth::user()->admin_id;
        $adminId = $request->input('admin_id');

        if ($loginAdminId != $adminId) {
            //自身必须为超级管理员才来修改其他人的信息
            if (!in_array($loginAdminId, Admin::Administrators)) {
                return self::failReturn(self::ADMIN_UPDATE_POWER_ERROR);
            }
            //被修改的不可以是其他超级管理员
            if (in_array($adminId, Admin::Administrators)) {
                return self::failReturn(self::ADMIN_UPDATE_POWER_ERROR);
            }
        }
        //判断输入信息身份重复
        $adminRow = $admin->newQuery()->where('admin_id', '<>', $adminId)
            ->where(function ($query) use ($request) {
                $query->where('name', $request->input('name'))->orWhere('mobile', $request->input('mobile'));
            })->first();
        if ($adminRow) {
            return self::failReturn(self::ADMIN_UPDATE_NAME_MOBILE_ERROR);
        }
        if (empty($request->input('password'))) {
            $request->offsetUnset('password');
        } else {
            $request->offsetSet('password', password_hash($request->input('password'), PASSWORD_DEFAULT));
        }
        $adminInfo = $admin->newQuery()->findOrFail($adminId);
        $adminInfo->fill($request->toArray())->save();
//        foreach ($adminInfo['roles'] as $role) {
//            $adminInfo->removeRole($role);
//        }
        $role_id = $request->input('role_id');
        if ($role_id > 0) {
            $role = Role::findById($role_id);
            $adminInfo->syncRoles([$role]);
        } else {
            $adminInfo->syncRoles([]);
        }
        return self::successReturn();
    }
}