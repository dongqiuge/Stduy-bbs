<?php

namespace App\Observers;

use App\Models\Reply;
use App\Notifications\TopicReplied;

// creating, created, updating, updated, saving,
// saved,  deleting, deleted, restoring, restored

class ReplyObserver
{

    /**
     * 事件监听：在回复创建前，过滤用户输入的内容
     *
     * @param Reply $reply
     * @return void
     */
    public function creating(Reply $reply): void
    {
        // 使用 mews/purifier 来过滤内容，防止 XSS 攻击
        // clean() 函数是由 mews/purifier 提供的辅助方法
        $reply->content = clean($reply->content, 'user_topic_body');
    }

    /**
     * 事件监听：在回复创建后，去更新话题的回复数量
     *
     * @param Reply $reply
     * @return void
     */
    public function created(Reply $reply): void
    {
        $reply->topic->reply_count = $reply->topic->replies->count();
        $reply->topic->save();

        // 通知话题作者有新的评论
        $reply->topic->user->notify(new TopicReplied($reply));
    }
}
