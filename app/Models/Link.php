<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;

class Link extends Model
{
    use HasFactory;

    /**
     * 可填充字段
     *
     * @var string[]
     */
    protected $fillable = ['title', 'link'];

    /**
     * 缓存键名
     *
     * @var string
     */
    public string $cache_key = 'larabbs_links';

    /**
     * 缓存过期时间
     *
     * @var int|float
     */
    protected int|float $cache_expire_in_minutes = 1440 * 60;

    /**
     * 获取所有链接
     *
     * @return mixed
     */
    public function getAllCached(): mixed
    {
        // 从缓存中取出 cache_key 对应的数据，如果存在则直接返回。
        // 否则运行闭包中的代码来取得 links 表中所有的数据，返回的同时做了缓存。
        return Cache::remember($this->cache_key, $this->cache_expire_in_minutes, function () {
            return $this->all();
        });
    }
}
