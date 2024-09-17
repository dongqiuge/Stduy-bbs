<?php

namespace App\Observers;

use App\Models\Link;
use Illuminate\Support\Facades\Cache;

class LinkObserver
{
    /**
     * 监听 Link 的 saved 事件
     * 当 Link 的内容被新建或者修改时，清除缓存
     * 写完 Observer 后，还需要在 AppServiceProvider 中的 boot 方法中注册 Observer
     * \App\Models\Link::observe(\App\Observers\LinkObserver::class);
     *
     * @param Link $link
     */
    public function saved(Link $link): void
    {
        # Link $link 是通过依赖注入实现的，Laravel 会自动解析 Link::class，然后实例化 Link 类，然后传递给 saved 方法
        # Link $link 是指定的 Link 实例，相当于 $link = Link::find($id);
        # 如果没有指定 $link 的 id，那么 $link 就是一个新的 Link 实例，相当于 $link = new Link();
        # $link 是一个对象，可以调用对象的方法，比如 $link->find($id)，可以调用对象的属性，比如 $link->id

        // 清除缓存
        Cache::forget($link->cache_key);
    }
}
