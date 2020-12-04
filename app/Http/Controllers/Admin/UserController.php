<?php


namespace App\Http\Controllers\Admin;


use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class UserController
{

    function role(Request $request)
    {
//        if (!Auth::guard()->check())
//            dd("login...");
//        $roleUrl = '/user/check';
//        $permissionName = '编辑员工';
//        $user = User::query()->find(3);
//        $role = Role::firstOrCreate(['name' => '/user/check']);
//        $permission = Permission::create(['name' => '编辑员工']);
//        $role->givePermissionTo($permission);
//        $permission->assignRole($role);


//        $user->assignRole($roleUrl);
//        $user->revokePermissionTo($permissionName);
//        $permissionNames = $user->getPermissionNames();
//        dd($user->can($permissionName));
//        $role->syncPermissions($permissions);
//        $permission->syncRoles($roles);
    }

}