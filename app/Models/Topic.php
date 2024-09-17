<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * Class Topic
 * @property integer $id ID
 * @property string $title 标题
 * @property string $body 内容
 * @property integer $user_id 用户 ID
 * @property integer $category_id 分类 ID
 * @property integer $reply_count 回复数量
 * @property integer $view_count 查看数量
 * @property integer $last_reply_user_id 最后回复的用户 ID
 * @property integer $order 排序
 * @property string $excerpt 摘要
 * @property string $slug SEO 友好的 URI
 * @property string $created_at 创建时间
 * @property string $updated_at 更新时间
 * @property-read Category $category 分类
 * @property-read User $user 用户
 * @property-read Collection|Reply[] $replies 回复
 * @extends Model
 */
class Topic extends Model
{
    use HasFactory;

    /**
     * 定义可以批量赋值的字段
     * 允许用户直接对数据进行修改，通过表单提交 title、body、category_id、excerpt、slug 字段来新增话题
     * 在每一次开发数据模型的 CURD 功能时，都需要在模型中定义 $fillable 属性，以防止恶意修改数据。
     *
     * @var string[]
     */
    protected $fillable = ['title', 'body', 'category_id', 'excerpt', 'slug'];

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

    /**
     * 话题与回复的关联
     *
     * @return HasMany
     */
    public function replies(): HasMany
    {
        return $this->hasMany(Reply::class)->orderBy('created_at', 'desc');
    }

    /**
     * 当话题有新回复或者删除回复时
     * 我们需要更新话题的 reply_count 属性
     *
     * @return void
     */
    public function updateReplyCount(): void
    {
        $this->reply_count = $this->replies->count();
        $this->save();
    }

    /**
     * 生成话题链接
     *
     * @param array $params
     * @return string
     */
    public function link(array $params = []): string
    {
        return route('topics.show', array_merge([$this->id, $this->slug], $params));
    }
}
