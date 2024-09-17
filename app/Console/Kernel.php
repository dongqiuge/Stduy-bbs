<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    /**
     * Define the application's command schedule.
     *
     * @param Schedule $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule): void
    {
        # * * * * * cd /Library/WebServer/Documents/cod/bbs-laravel9 && php artisan schedule:run >> /dev/null 2>&1
        // 这是写在 crontab -e 中的命令, 表示每分钟执行一次 laravel 的任务调度 php artisan schedule:run
        // 1.	* * * * *：表示任务每 分钟 都会执行一次。具体的时间字段解释如下：
        // •	第一个 *：分钟（0-59）
        // •	第二个 *：小时（0-23）
        // •	第三个 *：天（1-31）
        // •	第四个 *：月（1-12）
        // •	第五个 *：星期几（0-7，0 或 7 都表示星期天）
        // 如果你不希望丢弃所有输出，可以去掉 >> /dev/null 2>&1，这样输出信息会记录在你的 cron 日志中，方便调试和跟踪。
        // cd /Library/WebServer/Documents/cod/bbs-laravel9：该部分表示定时任务先进入项目目录 /Library/WebServer/Documents/cod/bbs-laravel9，也就是你的 Laravel 项目目录。
        // && php artisan schedule:run：在进入项目目录后，执行 php artisan schedule:run 命令，运行 Laravel 的任务调度器。
        // >> /dev/null：将标准输出重定向到 /dev/null，即丢弃所有输出，避免产生日志文件或在终端中输出结果。
        // 2>&1：将标准错误输出也重定向到标准输出，以确保任何错误信息也不会输出。

        // $schedule->command('inspire')->hourly();

        // 一小时执行一次「活跃用户」数据生成的命令
        $schedule->command('larabbs:calculate-active-user')->hourly();

        // 每日零点执行一次「同步用户活跃时间」的命令
        $schedule->command('larabbs:sync-user-activated-at')->dailyAt('00:00');
    }

    /**
     * Register the commands for the application.
     *
     * @return void
     */
    protected function commands(): void
    {
        $this->load(__DIR__ . '/Commands');

        require base_path('routes/console.php');
    }
}
