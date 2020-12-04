<?php

use Illuminate\Contracts\View\Factory as ViewFactory;

/**
 * 二维数组排序
 * @param array $array
 * @param array $orderArray
 * @return array
 */
function arraySort($array = [], $orderArray = [])
{
    $orderField = [
        'regular' => SORT_REGULAR,
        'numeric' => SORT_NUMERIC,
        'string' => SORT_STRING,
        'desc' => SORT_DESC,
        'asc' => SORT_ASC,
    ];
    foreach ($orderArray as $key => $order) {
        $sort = $orderField[$order] ?? $order;
        $keysValue = [];
        foreach ($array as $k => $v) {
            $keysValue[$k] = $v[$key];
        }
        array_multisort($keysValue, $sort, $array);
    }
    return $array;
}

/**
 * 无线级分类整合
 * @param array $array
 * @param string $idKey 主键key
 * @param string $pidKey 父级key
 * @param string $sonKey 子数组key
 * @return array
 */
function array2Tree($array = [], $idKey = "id", $pidKey = "parent_id", $sonKey = "sons")
{
    $tree = $allTree = [];
    foreach ($array as $item) {
        $allTree[$item[$idKey]] = $item;
    }
    foreach ($allTree as $key => $value) {
        if (isset($allTree[$value[$pidKey]])) {
            $allTree[$value[$pidKey]][$sonKey][] = &$allTree[$key];
        } else {
            $tree[] = &$allTree[$key];
        }
    }
    return $tree;
}


function array2Object($arr)
{
    if (gettype($arr) != 'array') {
        return;
    }
    foreach ($arr as $k => $v) {
        if (gettype($v) == 'array' || getType($v) == 'object') {
            $arr[$k] = (object)array2Object($v);
        }
    }
    return (object)$arr;
}

function resource_data()
{
    return
        $return = [
            'data' => null,
            'meta' => [
                'status_code' => 200,
                'message' => '操作成功',
            ]
        ];
}

/**
 * 带默认前缀的视图
 * @param null $view
 * @param array $data
 * @param array $mergeData
 * @return \Illuminate\Contracts\Foundation\Application|mixed
 * @throws \Illuminate\Contracts\Container\BindingResolutionException
 */
function view_prefix($view = null, $data = [], $mergeData = [])
{
    $factory = app(ViewFactory::class);
    if (func_num_args() === 0) {
        return $factory;
    }
    if(!empty($view)){
        $view = config('view.admin_template_prefix').'.'.$view;
    }
    return $factory->make($view, $data, $mergeData);
}