<?php

namespace App\Http\Controllers;

use App\Handlers\ImageUploadHandler;
use App\Models\User;
use App\Http\Requests\UserRequest;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Redirector;
use Illuminate\Support\Facades\Auth;

/**
 * Class UsersController
 *
 * @package App\Http\Controllers
 */
class UsersController extends Controller
{

    /**
     * UsersController constructor.
     */
    public function __construct()
    {
        $this->middleware('auth', ['except' => ['show']]);
    }

    /**
     * 显示用户个人信息页面
     *
     * @param User $user
     * @return Factory|View|Application
     */
    public function show(User $user): Factory|View|Application
    {
        return view('users.show', compact('user'));
    }

    /**
     * 显示用户注册页面
     *
     * @param User $user
     * @return Factory|View|Application
     * @throws AuthorizationException
     */
    public function edit(User $user): View|Factory|Application
    {
        $this->authorize('update', $user);
        return view('users.edit', compact('user'));
    }

    /**
     * 更新用户信息
     *
     * @param UserRequest $request
     * @param ImageUploadHandler $uploader
     * @param User $user
     * @return RedirectResponse
     * @throws AuthorizationException
     */
    public function update(UserRequest $request, ImageUploadHandler $uploader, User $user): RedirectResponse
    {
        $this->authorize('update', $user);
        $data = $request->all();

        if ($request->avatar) {
            $result = $uploader->save($request->avatar, 'avatars', $user->id, 416);
            if ($result) {
                $data['avatar'] = $result['path'];
            }
        }

        $user->update($data);
        return redirect()->route('users.show', $user->id)->with('success', '个人资料更新成功！');
    }

    /**
     * 模拟登录
     *
     * @param $id
     * @param Request $request
     * @return Redirector|Application|RedirectResponse
     */
    public function impersonateUser($id, Request $request): Redirector|Application|RedirectResponse
    {
        $user = User::find($id);

        if ($user) {
            Auth::user()->impersonate($user);
            // 获取传递过来的重定向 URL，如果没有则默认重定向到首页
            $redirectTo = $request->input('redirect_to', '/');
            return redirect($redirectTo);
        }

        return redirect()->back()->with('error', 'User not found.');
    }

    /**
     * 停止模拟登录
     *
     * @param Request $request
     * @return Redirector|Application|RedirectResponse
     */
    public function stopImpersonating(Request $request): Redirector|Application|RedirectResponse
    {
        Auth::user()->leaveImpersonation();
        // 获取传递过来的重定向 URL，如果没有则默认重定向到首页
        $redirectTo = $request->input('redirect_to', '/');
        return redirect($redirectTo);
    }
}
