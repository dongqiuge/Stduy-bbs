<?php

namespace App\Http\Controllers;

use App\Handlers\ImageUploadHandler;
use App\Models\Category;
use App\Models\Topic;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\TopicRequest;
use Illuminate\Support\Facades\Auth;

class TopicsController extends Controller
{

    /**
     * TopicsController constructor.
     */
    public function __construct()
    {
        // 中间件是介于请求和响应之间的过滤器，用于过滤进入应用程序的 HTTP 请求
        // 通过中间件，我们可以在请求到达应用程序之前或响应离开应用程序之后，对请求和响应进行处理
        // 通过 $this->middleware('auth') 方法，我们可以为控制器指定中间件，这样，只有登录用户才能访问这些控制器
        // 通过 $this->middleware('auth', ['except' => ['index', 'show']]) 方法，我们可以为控制器指定中间件，这样，除了 index 和 show 方法，其他方法都需要登录用户才能访问
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
        $categories = Category::all();
        return view('topics.create_and_edit', compact('topic', 'categories'));
    }

    /**
     * 创建话题
     *
     * @param TopicRequest $request
     * @param Topic $topic
     * @return RedirectResponse
     */
    public function store(TopicRequest $request, Topic $topic): RedirectResponse
    {
        // Topic $topic 是依赖注入，这里的 $topic 是一个空的 Topic 实例
        // $request->all() 获取所有用户的请求数据
        // $topic->fill() 方法将 $request->all() 返回的数据填充到 $topic 实例中
        // $topic->user_id = Auth::id() 为话题的 user_id 字段赋值为当前登录用户的 ID
        // $topic->save() 方法将数据保存到数据库
        $topic->fill($request->all());
        $topic->user_id = Auth::id();
        $topic->save();

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

    /**
     * 上传图片
     *
     * @param Request $request
     * @param ImageUploadHandler $uploader
     * @return array
     */
    public function uploadImage(Request $request, ImageUploadHandler $uploader): array
    {
        // 初始化返回数据，默认是失败的
        $data = [
            'success' => false,
            'msg' => '上传失败！',
            'file_path' => ''
        ];

        // 判断是否上传文件，并赋值给 $file
        if ($file = $request->upload_file) {
            // 保存图片到本地
            $result = $uploader->save($file, 'topics', Auth::id(), 1024);
            // 图片保存成功的话
            if ($result) {
                $data['file_path'] = $result['path'];
                $data['msg'] = '上传成功！';
                $data['success'] = true;
            }
        }
        return $data;
    }
}
