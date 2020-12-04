<?php

namespace App\Http\Controllers;


use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;
    const SERVER_ERROR = '500';
    const TOKEN_ERROR = '401';
    const PERMISSION_ERROR = '403';
    const ADMIN_INVALID_MOBILE = '01091300';
    const ADMIN_PASSWORD_ERROR = '01160500';
    const ADMIN_UPDATE_POWER_ERROR = '01211605';
    const ADMIN_UPDATE_NAME_MOBILE_ERROR = '01211413';
    const THERE_IS_NO_CORRESPONDING_RECORD = '20091403';
    const SYSTEM_PERMISSIONS_URL_EXIST = '19162105';

    protected $admin_template_prefix;

    public function __construct()
    {
        $this->admin_template_prefix = config('view.admin_template_prefix');
    }

    /**
     * 请求成功响应结果
     * @param string $data
     * @param string $object
     * @param string $is_item
     * @return mixed
     */
    public function successReturn($data = "", $object = "", $is_item = "item")
    {
        $return = resource_data();
        if (!empty($data)) {
            $return['data'] = $data;
        }
        return response()->json($return);

    }

    /**
     * 请求失败响应结果
     * @param int $errorCode
     * @param string $message
     * @return \Illuminate\Http\JsonResponse
     */
    public function failReturn($errorCode = 500, $message = "")
    {
        $return = resource_data();
        $return['meta'] = [
            'status_code' => $errorCode,
            'message' => self::errorCode($errorCode) . $message ? self::errorCode($errorCode) . $message : '服务器错误',
        ];
        return response()->json($return);
    }

    /**
     * 定义错误提示
     * @param $code
     * @return string
     */
    public static function errorCode($code): string
    {
        $arr = [
            self::TOKEN_ERROR => '请重新登录',
            self::SERVER_ERROR => '系统错误',
            self::PERMISSION_ERROR => '无操作权限',
            self::ADMIN_INVALID_MOBILE => '用户名/密码 错误',
            self::ADMIN_PASSWORD_ERROR => '密码错误',
            self::ADMIN_UPDATE_POWER_ERROR => '管理员权限不足',
            self::ADMIN_UPDATE_NAME_MOBILE_ERROR => '昵称或手机号重复',
            self::THERE_IS_NO_CORRESPONDING_RECORD => '没有对应的记录',
            self::SYSTEM_PERMISSIONS_URL_EXIST => '已存在相同的权限路径',
        ];
        return $arr[$code];
    }
}
