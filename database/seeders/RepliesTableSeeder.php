<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Reply;

class RepliesTableSeeder extends Seeder
{
    public function run(): void
    {
        Reply::factory()->count(1220)->create();
    }
}

