<?php

namespace App\Http\Controllers;

use App\Models\Topic;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\TopicRequest;

class TopicsController extends Controller
{

    /**
     * TopicsController constructor.
     */
    public function __construct()
    {
        $this->middleware('auth', ['except' => ['index', 'show']]);
    }

    /**
     * 显示话题列表
     * 用 with() 方法预加载了话题数据的用户数据和分类数据，预加载是为了避免 N+1 问题
     *
     * @param Request $request
     * @param Topic $topic
     * @return View|Factory|Application
     */
    public function index(Request $request, Topic $topic): View|Factory|Application
    {
        $topics = $topic->withOrder($request->order)
            ->with('user', 'category') // 预加载 user 和 category 关联，避免 N+1 问题
            ->paginate(20);
        return view('topics.index', compact('topics'));
    }

    /**
     * 显示话题详情
     *
     * @param Topic $topic
     * @return Application|Factory|View
     */
    public function show(Topic $topic): Factory|View|Application
    {
        return view('topics.show', compact('topic'));
    }

    /**
     * 显示创建话题页面
     *
     * @param Topic $topic
     * @return Factory|View|Application
     */
    public function create(Topic $topic): Factory|View|Application
    {
        return view('topics.create_and_edit', compact('topic'));
    }

    /**
     * 创建话题
     *
     * @param TopicRequest $request
     * @return RedirectResponse
     */
    public function store(TopicRequest $request): RedirectResponse
    {
        $topic = Topic::create($request->all());
        return redirect()->route('topics.show', $topic->id)->with('message', 'Created successfully.');
    }


    /**
     * 显示编辑话题页面
     *
     * @param Topic $topic
     * @return Factory|View|Application
     * @throws AuthorizationException
     */
    public function edit(Topic $topic): Factory|View|Application
    {
        $this->authorize('update', $topic);
        return view('topics.create_and_edit', compact('topic'));
    }

    /**
     * 更新话题
     *
     * @param TopicRequest $request
     * @param Topic $topic
     * @return RedirectResponse
     * @throws AuthorizationException
     */
    public function update(TopicRequest $request, Topic $topic): RedirectResponse
    {
        $this->authorize('update', $topic);
        $topic->update($request->all());

        return redirect()->route('topics.show', $topic->id)->with('message', 'Updated successfully.');
    }

    /**
     * 删除话题
     *
     * @param Topic $topic
     * @return RedirectResponse
     * @throws AuthorizationException
     */
    public function destroy(Topic $topic): RedirectResponse
    {
        $this->authorize('destroy', $topic);
        $topic->delete();

        return redirect()->route('topics.index')->with('message', 'Deleted successfully.');
    }
}
