<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Carbon;

/**
 * App\Models\Reply
 *
 * @property int $id ID
 * @property int $user_id 用户 ID
 * @property int $topic_id 话题 ID
 * @property string $content 内容
 * @property Carbon|null $created_at 创建时间
 * @property Carbon|null $updated_at 更新时间
 * @property-read Topic $topic 话题
 * @property-read User $user 用户
 */
class Reply extends Model
{
    use HasFactory;

    /**
     * @var string[] $fillable
     */
    protected $fillable = ['content'];

    /**
     * 一个回复属于一个话题
     *
     * @return BelongsTo
     */
    public function topic(): BelongsTo
    {
        return $this->belongsTo(Topic::class);
    }

    /**
     * 一个回复属于一个用户
     *
     * @return BelongsTo
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
