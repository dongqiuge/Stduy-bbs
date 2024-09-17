<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(): void
    {
        // 生成数据集合
        User::factory()->count(13)->create();

        // 处理第一个用户的数据
        $user = User::find(1);
        $user->name = 'LuStormstout';
        $user->email = 'lustormstout@gmail.com';
        $user->password = bcrypt('11111111');
        $user->avatar = 'http://localhost:8000/uploads/images/avatars/202409/05/200.jpg';
        $user->save();

        // 初始化用户角色，将 ID 为 1 的用户指派为「站长」
        $user->assignRole('Founder');

        // 将 ID 为 2 的用户指派为「管理员」
        $user = User::find(2);
        $user->assignRole('Maintainer');
    }
}
