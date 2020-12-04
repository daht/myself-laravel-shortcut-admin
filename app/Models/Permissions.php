<?php


namespace App\Models;


class Permissions extends Base
{
    protected $table = 'permissions';
    protected $fillable = [
        'name',
        'guard_name',
    ];
}