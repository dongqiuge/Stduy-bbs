<?php

namespace App\Providers;

use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use Laravel\Horizon\Horizon;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The model to policy mappings for the application.
     *
     * @var array<class-string, class-string>
     */
    protected $policies = [
        \App\Models\Reply::class => \App\Policies\ReplyPolicy::class,
        \App\Models\Topic::class => \App\Policies\TopicPolicy::class,
        // 'App\Models\Model' => 'App\Policies\ModelPolicy',
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot(): void
    {
        $this->registerPolicies();

        // 修改策略自动发现的逻辑
        Gate::guessPolicyNamesUsing(function ($modelClass) {
            // 动态返回模型对应的策略名称，如：// 'App\Model\User' => 'App\Policies\UserPolicy'
            return 'App\Policies\\' . class_basename($modelClass) . 'Policy';
        });

        // 限制只有 Founder（站长） 才可以访问 Horizon 控制面板
        Horizon::auth(function ($request) {
            // return true / false;
            return Auth::user()->hasRole('Founder');
        });
    }
}
