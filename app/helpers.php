<?php

use Illuminate\Support\Facades\Route;

/**
 * 通过路由来定义当前页面的样式
 *
 * @return array|string|null
 */
function route_class(): array|string|null
{
    return str_replace('.', '-', Route::currentRouteName());
}

/**
 * 通过路由来判断是否为当前页面，如果是则返回 active，否则返回空字符串
 *
 * @param $category_id
 * @return string
 */
function category_nav_active($category_id): string
{
    return active_class((if_route('categories.show') && if_route_param('category', $category_id)));
}

/**
 * 生成 Topic 的 excerpt 字段
 *
 * @param $value
 * @param int $length
 * @return \Illuminate\Support\Stringable|mixed|string
 */
function make_excerpt($value, int $length = 200): mixed
{
    $excerpt = trim(preg_replace('/\r\n|\r|\n+/', ' ', strip_tags($value)));
    return str()->limit($excerpt, $length);
}
