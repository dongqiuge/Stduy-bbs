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

/**
 * 生成管理后台的链接
 *
 * @param $title
 * @param $model
 * @return string
 */
function model_admin_link($title, $model): string
{
    return model_link($title, $model, 'admin');
}

/**
 * 生成前台的链接
 * 前端页面上显示的链接
 *
 * @param $title
 * @param $model
 * @param string $prefix
 * @return string
 */
function model_link($title, $model, string $prefix = ''): string
{
    // 获取数据模型的复数小写格式
    $model_name = model_plural_name($model);

    // 初始化前缀
    $prefix = $prefix ? "/$prefix/" : '/';

    // 使用站点 URL 拼接全量 URL
    $url = config('app.url') . $prefix . $model_name . '/' . $model->id;

    // 拼接 HTML A 标签，并返回
    return '<a href="' . $url . '" target="_blank">' . $title . '</a>';
}

/**
 * 获取数据模型的复数小写格式
 * snake_case 蛇形命名法
 *
 * @param $model
 * @return \Illuminate\Support\Stringable|mixed
 */
function model_plural_name($model): mixed
{
    // 从实体中获取完整类名，例如：App\Models\User
    $full_class_name = get_class($model);

    // 获取基础类名，例如：传参 `App\Models\User` 会得到 `User`
    $class_name = class_basename($full_class_name);

    // 获取小写/下划线命名（蛇形命名），例如：传参 `User` 会得到 `user`，传参 `UserAction` 会得到 `user_action`
    $snake_case_name = str()->snake($class_name);

    // 获取复数形式，例如：传参 `user` 会得到 `users`
    return str()->plural($snake_case_name);
}
