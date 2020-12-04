<?php


namespace App\Models;


class AdminRoute extends Base
{
    const METHOD_GET = 0;
    const METHOD_POST = 1;
    const METHOD_PUT = 2;
    const METHOD_PATCH = 3;
    const METHOD_DELETE = 4;
    const METHOD_NAME = [
        self::METHOD_GET => 'get',
        self::METHOD_POST => 'post',
        self::METHOD_PUT => 'put',
        self::METHOD_PATCH => 'patch',
        self::METHOD_DELETE => 'delete',
    ];

    protected $fillable = [
        'parent_id',
        'parent_all_id',
        'level',
        'name',
        'is_menu',
        'method',
        'url',
        'icon',
        'sort',
    ];

    protected $table = 'admin_route';
    protected $primaryKey = 'admin_route_id';

    function getMethodFormatAttribute()
    {
        return self::METHOD_NAME[$this->method];
    }

    function getIsMenuFormatAttribute()
    {
        $result = [
            '权限',
            '导航',
        ];
        return $result[$this->is_menu];
    }
}