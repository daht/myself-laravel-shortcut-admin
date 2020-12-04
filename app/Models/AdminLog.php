<?php


namespace App\Models;


class AdminLog extends Base
{
    protected $table = 'admin_log';
    protected $primaryKey = 'admin_log_id';
    protected $fillable = [
        'title',
        'admin_name',
        'admin_remark',
        'admin_mobile',
        'admin_id',
        'admin_ip',
        'route',
        'route',
        'method',
        'result',
        'type',
    ];
}