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
    Route::get('/admin/logout', [AdminController::class, "logout"])->name("登录");
    Route::get('/verify/picture_captcha', [AdminController::class, "logout"])->name("登录");
    Route::group(["middleware" => "admin.auth"], function () {
        Route::get('/', [HomeController::class, "index"])->name("登录");
        Route::get('/system/permissions', [SystemController::class, "permissions"])->name("权限列表");
        Route::get('/system/add', [SystemController::class, "add"])->name("添加权限");
        Route::get('/system/roles', [SystemController::class, "roles"])->name("身份管理");
        Route::get('/user/create', "UserController@create")->name("登录");
        Route::get('/user/login', "UserController@login")->name("登录");
        Route::get('/user/role', "UserController@role")->name("登录");
    });
});

