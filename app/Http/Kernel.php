<?php

namespace App\Http;

use Illuminate\Foundation\Http\Kernel as HttpKernel;

class Kernel extends HttpKernel
{
    /**
     * The application's global HTTP middleware stack.
     *
     * These middleware are run during every request to your application.
     *
     * 全局中间件
     *
     * @var array<int, class-string|string>
     */
    protected $middleware = [
        // \App\Http\Middleware\TrustHosts::class,

        // 修正代理服务器后的服务器参数
        \App\Http\Middleware\TrustProxies::class,

        // 解决 CORS 跨域问题
        \Illuminate\Http\Middleware\HandleCors::class,

        // 检查应用程序是否在「维护模式」
        \App\Http\Middleware\PreventRequestsDuringMaintenance::class,

        // 检测表单请求的数据是否超出了限制
        \Illuminate\Foundation\Http\Middleware\ValidatePostSize::class,

        // 对所有提交的数据进行 PHP 函数 `trim()` 处理
        \App\Http\Middleware\TrimStrings::class,

        // 将提交请求参数中的空字符串转换为 `null`
        \Illuminate\Foundation\Http\Middleware\ConvertEmptyStringsToNull::class,
    ];

    /**
     * The application's route middleware groups.
     * 设定中间件组
     *
     * @var array<string, array<int, class-string|string>>
     */
    protected $middlewareGroups = [
        // web 中间件组，应用于 routes/web.php 中的路由
        // 在 RouteServiceProvider 中设定
        'web' => [
            // Cookie 加密解密
            \App\Http\Middleware\EncryptCookies::class,

            // 将 Cookie 加入到响应中
            \Illuminate\Cookie\Middleware\AddQueuedCookiesToResponse::class,

            // 开启会话
            \Illuminate\Session\Middleware\StartSession::class,

            // 将系统的错误数据注入到视图变量 $errors 中
            \Illuminate\View\Middleware\ShareErrorsFromSession::class,

            // 检查 CSRF，防止跨站请求伪造
            // 见：https://learnku.com/docs/laravel/9.x/csrf
            \App\Http\Middleware\VerifyCsrfToken::class,

            // 处理路由绑定
            // 见：https://learnku.com/docs/laravel/9.x/routing/12209#route-model-binding
            \Illuminate\Routing\Middleware\SubstituteBindings::class,

            // 强制用户验证邮箱
            \App\Http\Middleware\EnsureEmailIsVerified::class,

            // 记录用户最后活跃时间
            \App\Http\Middleware\RecordLastActivatedTime::class,
        ],

        // api 中间件组，应用于 routes/api.php 中的路由
        // 在 RouteServiceProvider 中设定
        'api' => [
            // \Laravel\Sanctum\Http\Middleware\EnsureFrontendRequestsAreStateful::class,

            // 使用别名来调用中间件
            // 见：https://learnku.com/docs/laravel/9.x/middleware#为路由分配中间件
            'throttle:api',
            \Illuminate\Routing\Middleware\SubstituteBindings::class,
        ],
    ];

    /**
     * The application's route middleware.
     *
     * These middleware may be assigned to groups or used individually.
     *
     * 中间件别名设置，允许你使用别名调用中间件，例如上面的 api 中间件组调用
     *
     * @var array<string, class-string|string>
     */
    protected $routeMiddleware = [
        // 只有登录用户才能访问，我们在控制器的构造方法中大量使用了这个中间件
        'auth' => \App\Http\Middleware\Authenticate::class,

        // HTTP Basic Auth 认证
        'auth.basic' => \Illuminate\Auth\Middleware\AuthenticateWithBasicAuth::class,

        'auth.session' => \Illuminate\Session\Middleware\AuthenticateSession::class,

        // 缓存标头
        'cache.headers' => \Illuminate\Http\Middleware\SetCacheHeaders::class,

        // 用户授权功能
        'can' => \Illuminate\Auth\Middleware\Authorize::class,

        // 只有游客才能访问，在 register 和 login 请求中使用，只有未登录用户才能访问这两个页面
        'guest' => \App\Http\Middleware\RedirectIfAuthenticated::class,

        'password.confirm' => \Illuminate\Auth\Middleware\RequirePassword::class,
        'signed' => \Illuminate\Routing\Middleware\ValidateSignature::class,

        // 限制请求速率
        'throttle' => \Illuminate\Routing\Middleware\ThrottleRequests::class,

        // Laravel 自带的强制用户邮箱认证的中间件，为了更加贴近我们的逻辑，已被重写
        'verified' => \Illuminate\Auth\Middleware\EnsureEmailIsVerified::class,
    ];
}
