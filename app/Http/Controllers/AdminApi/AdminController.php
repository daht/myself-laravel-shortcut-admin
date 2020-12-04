<?php


namespace App\Http\Controllers\AdminApi;


use App\Http\Controllers\Controller;
use App\Http\Requests\AdminApi\AdminLoginRequest;
use App\Models\Admin;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;

class AdminController extends Controller
{
    function login(AdminLoginRequest $request, Admin $admin)
    {
        $adminInfo = $admin->newQuery()->where('mobile', $request->input('mobile'))->first();

        if (!$adminInfo) {
            return self::failReturn(self::ADMIN_INVALID_MOBILE);
        }
        if (!password_verify($request->input('password'), $adminInfo->password)) {
            return self::failReturn(self::ADMIN_INVALID_MOBILE);
        }
        $adminInfo->last_login_at = time();
        $adminInfo->save();
        Auth::login($adminInfo, true);
        return self::successReturn();
    }

    function clear_cache()
    {
        Cache::pull('cache_code');
        return self::successReturn();
    }
}