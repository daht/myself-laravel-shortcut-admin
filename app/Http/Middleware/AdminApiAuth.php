<?php


namespace App\Http\Middleware;

use App\Events\AdminLogEvent;
use App\Http\Controllers\Controller;
use Closure;
use Illuminate\Support\Facades\Auth;

class AdminApiAuth extends Controller
{
    /**
     * 店铺后台权限验证
     */
    public function handle($request, Closure $next, $guard = null)
    {
        if (!Auth::guard($guard)->check()) {
            return self::failReturn(self::TOKEN_ERROR);
        }
        $admin = Auth::user();
        $url = '/' . ltrim($request->path(), '/');
        if (!$admin->can($url)) {
            return self::failReturn(self::PERMISSION_ERROR);
        }
        $route_name = $request->route()->getName();
        $log = [
            'title' => "操作了[" . $route_name . "]",
            'admin_name' => $admin->name,
            'admin_remark' => $admin->remark,
            'admin_mobile' => $admin->mobile,
            'admin_id' => $admin->admin_id,
            'admin_ip' => $request->getClientIp(),
            'route' => $request->path(),
            'method' => $request->method(),
            'result' => json_encode($request->input()),
            'type' => 0,
        ];
        //更新登录时间
        event(new AdminLogEvent($log));
        return $next($request);
    }
}