<?php

namespace App\Observers;

use App\Models\User;

// creating, created, updating, updated, saving,
// saved,  deleting, deleted, restoring, restored

class UserObserver
{
    /**
     * 新注册用户默认头像
     *
     * @param User $user
     * @return void
     */
    public function saving(User $user): void
    {
        if (empty($user->avatar)) {
            $user->avatar = config('app.url') . '/uploads/images/default-avatar.png';
        }
    }
}
