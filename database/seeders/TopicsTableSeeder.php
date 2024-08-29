<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Topic;

class TopicsTableSeeder extends Seeder
{
    // 跳过模型事件
    use WithoutModelEvents;

    public function run(): void
    {
        Topic::factory()->count(115)->create();
    }
}

