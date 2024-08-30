<?php

namespace App\Http\Controllers;

use App\Models\Reply;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\ReplyRequest;
use Illuminate\Support\Facades\Auth;

/**
 * Class RepliesController
 * @package App\Http\Controllers
 */
class RepliesController extends Controller
{

    /**
     * RepliesController constructor.
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * 发布评论
     *
     * @param ReplyRequest $request
     * @param Reply $reply
     * @return RedirectResponse
     */
    public function store(ReplyRequest $request, Reply $reply): RedirectResponse
    {
        $reply->content = $request->content;
        $reply->user_id = Auth::id();
        $reply->topic_id = $request->topic_id;
        $reply->save();
        return redirect()->to($reply->topic->link())->with('success', '评论创建成功！');
    }

    /**
     * 删除评论
     *
     * @param Reply $reply
     * @return RedirectResponse
     * @throws AuthorizationException
     */
    public function destroy(Reply $reply): RedirectResponse
    {
        $this->authorize('destroy', $reply);
        $reply->delete();

        return redirect()->route('replies.index')->with('success', '评论删除成功！');
    }
}
