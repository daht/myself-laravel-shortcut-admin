<?php


namespace App\Http\Controllers\Admin;


use App\Http\Controllers\Controller;
use App\Models\Admin;
use App\Models\AdminRoute;
use App\Models\Permissions;
use App\Models\Roles;
use Illuminate\Http\Request;
use Spatie\Permission\Exceptions\PermissionDoesNotExist;
use Spatie\Permission\Models\Role;

class SystemController extends Controller
{
    protected $adminRoute;
    protected $permissions;
    protected $roles;

    public function __construct(AdminRoute $adminRoute, Permissions $permissions, Roles $roles)
    {
        $this->adminRoute = $adminRoute;
        $this->permissions = $permissions;
        $this->roles = $roles;
    }

    /**
     * 导航管理
     * @param Request $request
     * @return \Illuminate\Contracts\Foundation\Application|mixed
     * @throws \Illuminate\Contracts\Container\BindingResolutionException
     */
    public function menu(Request $request)
    {
        $result = $this->adminRoute->newQuery()
            ->where('is_menu', 1)->orderBy('sort', 'desc')->get();
        $menu = array2Tree($result->toArray(), 'admin_route_id', 'parent_id');
        return view_prefix('system_menu', compact('result', 'request', 'menu'));
    }

    /**
     * 权限管理
     * @param Request $request
     * @return \Illuminate\Contracts\Foundation\Application|mixed
     * @throws \Illuminate\Contracts\Container\BindingResolutionException
     */
    public function permissions(Request $request)
    {
        $search = $request->input('search', '');
        $admin_route_id = $request->input('admin_route_id', '');
        $result = $this->adminRoute->newQuery()
            ->when(!empty($admin_route_id), function ($query) use ($admin_route_id) {
                $query->where('parent_id', $admin_route_id);
            })
            ->when(!empty($search), function ($query) use ($search) {
                $query->Where('name', 'like', '%' . $search . '%');
                $query->orWhere('url', 'like', '%' . $search . '%');
            })
            ->orderBy('sort', 'desc')
            ->orderBy('admin_route_id')
            ->paginate();
        $parentAdminRoute = $this->adminRoute->find($admin_route_id);
        return view_prefix('system_permissions', compact('result', 'request', 'parentAdminRoute'));
    }

    /**
     * 身份管理
     * @param Request $request
     * @return \Illuminate\Contracts\Foundation\Application|mixed
     * @throws \Illuminate\Contracts\Container\BindingResolutionException
     */
    public function roles(Request $request)
    {
        $result = $this->roles->newQuery()->paginate();
        return view_prefix('system_roles', compact('result', 'request'));
    }

    /**
     * 管理员管理
     * @param Request $request
     * @param Admin $admin
     * @return \Illuminate\Contracts\Foundation\Application|mixed
     * @throws \Illuminate\Contracts\Container\BindingResolutionException
     */
    public function admin(Request $request, Admin $admin)
    {
        $result = $admin->newQuery()->with('roles')->paginate();
        $roles = Role::get();
        return view_prefix('system_admin', compact('result', 'request', 'roles'));
    }

    /**
     * 修改
     * @param Request $request
     * @param AdminRoute $adminRoute
     * @return \Illuminate\Contracts\Foundation\Application|mixed
     * @throws \Illuminate\Contracts\Container\BindingResolutionException
     */
    public function roles2permissions(Request $request, AdminRoute $adminRoute)
    {
        $role = Role::findById($request->input('id'));
        $adminRouteAll = $adminRoute->get();
        $idKey = 'admin_route_id';
        $pidKey = 'parent_id';
        $sonKey = 'sons';
        $tree = $allTree = [];
        foreach ($adminRouteAll->toArray() as $item) {
            $checkArr = ['type' => 0, 'checked' => 0];
            try {
                if ($role->hasPermissionTo($item['url'])) {
                    $checkArr = ['type' => 0, 'checked' => 1];
                }
            } catch (PermissionDoesNotExist $exception) {
            }
            $item["checkArr"][] = $checkArr;
            $allTree[$item[$idKey]] = $item;
        }
        foreach ($allTree as $key => $value) {
            if (isset($allTree[$value[$pidKey]])) {
                $allTree[$value[$pidKey]][$sonKey][] = &$allTree[$key];
            } else {
                $tree[] = &$allTree[$key];
            }
        }
//        dd($tree);
        $result = json_encode($tree);
        return view_prefix('system_roles2permissions', compact('result', 'request', 'role'));
    }
}