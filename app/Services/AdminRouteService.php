<?php
/**
 * 业务逻辑
 */

namespace App\Services;


use App\Models\AdminRoute;
use Illuminate\Support\Facades\Auth;

class AdminRouteService
{
    function getAdminRoutesTree($path = "")
    {
        $user = Auth::user();
        $tree = [];

        $all = AdminRoute::query()->where('is_menu', 1)->get();
        if ($all->isEmpty()) {
            return $tree;
        }
        $allTree = [];
        $path = '/' . ltrim($path, '/');
        $active = 0;
        $activeList = [];
        foreach ($all->toArray() as $value) {
            if ($path == $value['url'] && $value['method'] == AdminRoute::METHOD_GET) {
                $active = $value['admin_route_id'];

            }
            //默认路径未打开
            $value["is_active"] = false;

            if (!$user->can($value['url'])) {
                continue;
            }
            $allTree[$value['admin_route_id']] = $value;
        }
        //处理打开路径
        if (isset($allTree[$active])) {
            foreach (explode(',', $allTree[$active]['parent_all_id']) as $route_id) {
                if (isset($allTree[$route_id])) {
                    $allTree[$route_id]['is_active'] = true;
                    $activeList[$allTree[$route_id]['admin_route_id']] = &$allTree[$route_id];
                }
            }
            $allTree[$active]["is_active"] = true;
            $activeList[$allTree[$active]['admin_route_id']] = &$allTree[$active];
        }

        foreach ($allTree as $kk => $vv) {
            if (isset($allTree[$vv['parent_id']])) {
                $allTree[$vv['parent_id']]['sons'][] = &$allTree[$kk];
            } else {
                $tree[] = &$allTree[$kk];
            }
        }
        return ['tree' => $tree, 'active' => $activeList];
    }


}
