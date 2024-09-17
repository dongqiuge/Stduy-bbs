<?php

namespace App\Models\Traits;

use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Redis;

trait LastActivatedAtHelper
{
    // 缓存相关
    protected string $hash_prefix = 'larabbs_last_activated_at_';
    protected string $field_prefix = 'user_';

    /**
     * 记录用户最后活跃时间
     *
     * @return void
     */
    public function recordLastActivatedAt(): void
    {
        // 获取今日的哈希表名称，如：larabbs_last_activated_at_2024-10-15
        $hash = $this->getHashFromDateString(Carbon::now()->toDateString());

        // 字段名称，如：user_1
        $field = $this->getHashField();

        # 测试是否可以取出数据
        // dd(Redis::hGetAll($hash));

        // 当前时间，如：2024-10-15 12:00:00
        $now = Carbon::now()->toDateTimeString();

        // 数据写入到 Redis 中，字段已经存在会被更新
        Redis::hSet($hash, $field, $now);
    }

    /**
     * 同步用户最后登录时间到数据库
     *
     * @return void
     */
    public function syncUserActivatedAt(): void
    {
        // 为了方便测试，可以将日期设置为今天 now()->toDateString()
        // $hash = $this->getHashFromDateString(Carbon::now()->toDateString());

        // 获取昨日的哈希表名称，如：larabbs_last_activated_at_2017-10-15
        $hash = $this->getHashFromDateString(Carbon::yesterday()->toDateString());

        // 从 Redis 中取出所有哈希表数据
        $dates = Redis::hGetAll($hash);

        // 遍历所有数据，将数据同步到数据库中
        foreach ($dates as $user_id => $activated_at) {
            // 会将 `user_1` 转换成 `1`
            $user_id = str_replace($this->field_prefix, '', $user_id);

            // 只有当用户存在时才更新到数据库
            if ($user = $this->find($user_id)) {
                $user->last_activated_at = $activated_at;
                $user->save();
            }
        }

        // 以数据库为中心的存储，所以同步后删除 Redis 中的数据
        Redis::del($hash);
    }

    /**
     * 获取最后活跃时间
     * 当读取 $user->last_activated_at 时，会调用该方法，并且会自动传入数据库中的值 $value
     * 例如调用 $user->name 时，会自动执行 getNameAttribute 方法，并且会自动传入数据库中的值 $value
     * __get() 魔术方法实现的
     *
     * @param $value
     * @return Carbon|string
     */
    public function getLastActivatedAtAttribute($value): Carbon|string
    {
        // 获取今日对应的 Redis 哈希表名称
        $hash = $this->getHashFromDateString(Carbon::now()->toDateString());

        // 字段名称，如：user_1
        $field = $this->getHashField();

        // 三元运算符，优先选择 Redis 中的数据，如果没有则选择数据库中的数据
        $datetime = Redis::hGet($hash, $field) ?? $value;

        // 如果存在的话，返回对应的 Carbon 实例
        if ($datetime) {
            return new Carbon($datetime);
        } else {
            // 否则返回数据库中的数据
            return $this->created_at;
        }
    }

    /**
     * 获取 Redis 哈希表的名称
     *
     * @param $date
     * @return string
     */
    public function getHashFromDateString($date): string
    {
        // Redis 哈希表的命名，如：larabbs_last_activated_at_2024-10-15
        return $this->hash_prefix . $date;
    }

    /**
     * 获取 Redis 哈希表的字段名称
     *
     * @return string
     */
    public function getHashField(): string
    {
        // 字段名称，如：user_1
        return $this->field_prefix . $this->id;
    }
}
