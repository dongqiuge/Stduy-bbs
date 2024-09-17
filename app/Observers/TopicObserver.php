<?php

namespace App\Observers;

use App\Models\Topic;
use Illuminate\Support\Facades\DB;

// creating, created, updating, updated, saving,
// saved,  deleting, deleted, restoring, restored

class TopicObserver
{
    /**
     * 事件监听：在保存前生成话题摘要
     *
     * @param Topic $topic
     * @return void
     */
    public function saving(Topic $topic): void
    {
        // 使用 mews/purifier 来过滤内容，防止 XSS 攻击
        $topic->body = clean($topic->body, 'user_topic_body');

        $topic->excerpt = make_excerpt($topic->body);
    }

    /**
     * 事件监听：在话题被删除后，删除话题的所有回复
     *
     * @param Topic $topic
     * @return void
     */
    public function deleted(Topic $topic): void
    {
        DB::table('replies')->where('topic_id', $topic->id)->delete();
    }
}
