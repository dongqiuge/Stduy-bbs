<?php

namespace App\Http\Controllers;

use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class NotificationsController extends Controller
{
    /**
     * NotificationsController constructor.
     */
    public function __construct()
    {
        // 只允许登录用户访问
        $this->middleware('auth');
    }

    /**
     * 通知列表
     *
     * @return Application|Factory|View
     */
    public function index(): Factory|View|Application
    {
        // 获取登录用户的所有通知
        $notifications = Auth::user()->notifications()->paginate(20);
        // 标记为已读，未读数量清零
        Auth::user()->markAsRead();
        return view('notifications.index', compact('notifications'));
    }
}
