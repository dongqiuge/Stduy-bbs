<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Link;
use App\Models\Topic;
use App\Models\User;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;

class CategoriesController extends Controller
{
    /**
     * 显示分类下的话题列表
     *
     * @param Category $category
     * @param Request $request
     * @param Topic $topic
     * @param User $user
     * @param Link $link
     * @return Application|Factory|View
     */
    public function show(Category $category, Request $request, Topic $topic, User $user, Link $link): View|Factory|Application
    {
        // 读取分类 ID 关联的话题，并按每 20 条分页
        $topics = $topic->withOrder($request->order)
            ->where('category_id', $category->id)
            ->with('user', 'category') // 预加载 user 和 category 关联，避免 N+1 问题
            ->paginate(20);

        // 活跃用户列表
        $active_users = $user->getActiveUsers();
        // 资源链接
        $links = $link->getAllCached();

        // 传参变量话题和分类到模板中
        return view('topics.index', compact('topics', 'category', 'active_users', 'links'));
    }
}
