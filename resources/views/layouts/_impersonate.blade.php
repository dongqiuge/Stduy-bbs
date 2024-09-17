<div class="container mt-5">
    <!-- 切换用户按钮 -->
    <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#userSwitchModal"
            style="position: fixed; bottom: 100px; right: 50px;">
        切换用户
    </button>

    <!-- 模态框 -->
    <div class="modal fade" id="userSwitchModal" tabindex="-1" aria-labelledby="userSwitchModalLabel"
         aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="userSwitchModalLabel">选择用户进行切换</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <table class="table table-striped">
                        <thead>
                        <tr>
                            <th>#</th>
                            <th>用户名</th>
                            <th>操作</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach ($users as $user)
                            <tr>
                                <td>{{ $user->id }}</td>
                                <td>{{ $user->name }}</td>
                                <td>
                                    <a href="{{ route('impersonate', ['id' => $user->id, 'redirect_to' => request()->fullUrl()]) }}"
                                       class="btn btn-sm btn-primary">
                                        切换到 {{ $user->name }}
                                    </a>
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">关闭</button>
                </div>
            </div>
        </div>
    </div>

    @if (session()->has('impersonate'))
        <a href="{{ route('stopImpersonating', ['redirect_to' => request()->fullUrl()]) }}"
           class="btn btn-warning mt-3">
            恢复身份
        </a>
    @endif
</div>
