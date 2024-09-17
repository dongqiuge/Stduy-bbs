<?php

namespace App\Console\Commands;

use App\Models\User;
use Illuminate\Console\Command;

class CalculateActiveUser extends Command
{
    /**
     * The name and signature of the console command.
     * 供我们调用的命令
     *
     * @var string
     */
    protected $signature = 'larabbs:calculate-active-user';

    /**
     * The console command description.
     * 命令的描述
     *
     * @var string
     */
    protected $description = '生成活跃用户';


    /**
     * Execute the console command.
     * 最终执行的方法
     *
     * @param User $user
     * @return void
     */
    public function handle(User $user): void
    {
        $this->info("开始计算活跃用户...");

        $user->calculateAndCacheActiveUsers();

        $this->info("成功生成！");
    }
}
