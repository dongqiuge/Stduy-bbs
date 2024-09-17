<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Reply;

class ReplyPolicy extends Policy
{
    /**
     * 判断用户是否有权限删除回复
     * 只有「回复的作者」或者「话题的作者」才有权限删除回复
     *
     * @param  User  $user
     * @param  Reply  $reply
     * @return bool
     */
    public function destroy(User $user, Reply $reply): bool
    {
        return $user->isAuthorOf($reply) || $user->isAuthorOf($reply->topic);
    }
}
