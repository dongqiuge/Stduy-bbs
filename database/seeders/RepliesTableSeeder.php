<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Reply;

class RepliesTableSeeder extends Seeder
{
    // 引入 WithoutModelEvents Trait 来关闭模型事件, 以加快数据填充的速度
    // 在此处关闭主要是因为会涉及到回复后的邮件通知，如果不关闭，会导致填充数据的速度变慢
    use WithoutModelEvents;

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(): void
    {
        Reply::factory()->count(1220)->create();
    }
}

