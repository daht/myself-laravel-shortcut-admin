<?php

use App\Http\Controllers\AdminApi\AdminController;
use App\Http\Controllers\AdminApi\SystemController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/


Route::group(['namespace' => 'AdminApi'], function () {
    Route::post('/admin/login', [AdminController::class, "login"])->name("登录");
    Route::post('/cache/clear', [AdminController::class, "clear_cache"])->name("清理缓存");
    Route::group(["middleware" => "adminApi.auth"], function () {
        Route::post('/system/permissions/create', [SystemController::class, "permissions_create"])->name("添加权限");
        Route::post('/system/permissions/delete', [SystemController::class, "permissions_delete"])->name("删除权限");
        Route::post('/system/permissions/update', [SystemController::class, "permissions_update"])->name("更改权限");

        Route::post('/system/roles/create', [SystemController::class, "roles_create"])->name("添加身份");
        Route::post('/system/roles/delete', [SystemController::class, "roles_delete"])->name("删除身份");
        Route::post('/system/roles/update', [SystemController::class, "roles_update"])->name("更改身份");
        Route::post('/system/roles2permissions/update', [SystemController::class, "roles2permissions_update"])->name("编辑身份权限");

        Route::post('/system/admin/create', [SystemController::class, "admin_create"])->name("添加管理员");
        Route::post('/system/admin/delete', [SystemController::class, "admin_delete"])->name("删除管理员");
        Route::post('/system/admin/update', [SystemController::class, "admin_update"])->name("更改管理员");

    });
});

