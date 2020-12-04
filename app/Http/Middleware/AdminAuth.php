<?php


namespace App\Http\Middleware;

use App\Events\AdminLogEvent;
use App\Services\AdminRouteService;
use Closure;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;

class AdminAuth
{
    /**
     * 店铺后台权限验证
     */
    public function handle($request, Closure $next, $guard = null)
    {

        if (!Auth::guard($guard)->check()) {
            return redirect('/admin/login');
        }
        $admin = Auth::user();
        $url = '/' . ltrim($request->path(), '/');
        if (!$admin->can($url) && $url != '/' ) {
            return redirect('/');
        }

        $adminRouteService = new AdminRouteService();
        $admin_route_list = $adminRouteService->getAdminRoutesTree($request->path());
        view()->share("admin_route_list", $admin_route_list['tree']);
        view()->share("active_route_list", $admin_route_list['active']);
        view()->share("current_nav", array_keys($admin_route_list['active']));
        //文件js/css缓存码
        view()->share("cache_code", Cache::remember('cache_code', 3600, function () {
            return time();
        }));

        $route_name = $request->route()->getName();
        $log = [
            'title' => "访问了[" . $route_name . "]",
            'admin_name' => $admin->name,
            'admin_remark' => $admin->remark,
            'admin_mobile' => $admin->mobile,
            'admin_id' => $admin->admin_id,
            'admin_ip' => $request->getClientIp(),
            'route' => $request->path(),
            'method' => $request->method(),
            'result' => json_encode($request->input()),
            'type' => 1,
        ];
        //更新登录时间
        event(new AdminLogEvent($log));

        return $next($request);
    }
}