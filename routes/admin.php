<?php

use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\HomeController;
use App\Http\Controllers\Admin\SystemController;
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


Route::group(['namespace' => 'Admin'], function () {

    Route::get('/admin/login', [AdminController::class, "login"])->name("登录");
    Route::get('/admin/logout', [AdminController::class, "logout"])->name("退出登陆");
    Route::get('/verify/picture_captcha', [AdminController::class, "logout"])->name("验证码");
    Route::group(["middleware" => "admin.auth"], function () {
        Route::get('/', [HomeController::class, "index"])->name("首页");
        Route::get('/system/menu', [SystemController::class, "menu"])->name("导航管理");
        Route::get('/system/permissions', [SystemController::class, "permissions"])->name("权限列表");
        Route::get('/system/roles', [SystemController::class, "roles"])->name("身份管理");
        Route::get('/system/admin', [SystemController::class, "admin"])->name("管理员列表");
        Route::get('/system/roles2permissions', [SystemController::class, "roles2permissions"])->name("身份权限管理");
    });
});

