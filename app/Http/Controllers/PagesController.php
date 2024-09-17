<?php

namespace App\Http\Controllers;

use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Redirector;

class PagesController extends Controller
{
    /**
     * 首页
     *
     * @return Factory|View|Application
     */
    public function root(): Factory|View|Application
    {
        return view('pages.root');
    }

    /**
     * 权限不足页面
     *
     * @return Application|Factory|View|RedirectResponse|Redirector
     */
    public function permissionDenied(): View|Factory|Redirector|RedirectResponse|Application
    {
        // 如果当前用户有权限访问后台，直接跳转访问
        if (config('administrator.permission')()) {
            return redirect(url(config('administrator.uri')), 302);
        }

        // 否则使用视图，没有权限的话
        return view('pages.permission_denied');
    }
}
