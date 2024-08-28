<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Topic extends Model
{
    use HasFactory;

    protected $fillable = ['title', 'body', 'user_id', 'category_id', 'reply_count', 'view_count', 'last_reply_user_id', 'order', 'excerpt', 'slug'];

    /**
     * 定义于 category 的关联
     *
     * @return BelongsTo
     */
    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    /**
     * 定义于 user 的关联
     *
     * @return BelongsTo
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * 话题排序
     *
     * @param $query
     * @param $order
     */
    public function scopeWithOrder($query, $order): void
    {
        // 不同的排序，使用不同的数据读取逻辑
        switch ($order) {
            case 'recent':
                $query->recent();
                break;
            default:
                $query->recentReplied();
                break;
        }
    }

    /**
     * 话题排序：最后回复时间排序
     *
     * @param $query
     * @return mixed
     */
    public function scopeRecentReplied($query): mixed
    {
        // 当话题有新回复时，我们将编写逻辑来更新话题模型的 reply_count 属性.
        // 此时会自动触发框架对数据模型的更新，更新的字段会自动同步到数据库中。
        return $query->orderBy('updated_at', 'desc');
    }

    /**
     * 话题排序：创建时间排序
     *
     * @param $query
     * @return mixed
     */
    public function scopeRecent($query): mixed
    {
        // 按照创建时间排序
        return $query->orderBy('created_at', 'desc');
    }
}
