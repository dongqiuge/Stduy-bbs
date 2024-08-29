<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Topic;

class TopicPolicy extends Policy
{
    /**
     * 授权策略，只有话题作者才能创建和更新话题
     *
     * @param User $user
     * @param Topic $topic
     * @return bool
     */
    public function update(User $user, Topic $topic): bool
    {
        return $user->isAuthorOf($topic);
    }

    /**
     * 授权策略，只有话题作者才能删除话题
     *
     * @param User $user
     * @param Topic $topic
     * @return bool
     */
    public function destroy(User $user, Topic $topic): bool
    {
        return $user->isAuthorOf($topic);
    }
}
