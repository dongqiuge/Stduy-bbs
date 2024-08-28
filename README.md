# bbs-laravel9

---

## 项目简介
基于 laravel 9.1.* 开发的 BBS 论坛系统

## 2024-08-20 干了什么
- 运行的命令
  - [x] `touch app/helpers.php` 创建 helpers.php 文件
  - [x] composer.json autoload 配置, 加载 helpers.php, `composer dump-autoload`
  - [x] `php artisan make:controller PagesController` 创建 PagesController 控制器
  - [x] `rm resources/views/welcome.blade.php` 删除默认视图文件
  - [x] `composer require laravel/ui:3.4.5 --dev` 安装 laravel/ui
  - [x] `php artisan ui bootstrap` 安装 bootstrap
  - [x] `yarn add resolve-url-loader@^5.0.0 --dev` 安装 resolve-url-loader
  - [x] `yarn run watch-poll` 编译前端资源
  - [x] `yarn cache clean` 清除 yarn 缓存，解决 yarn add @fortawesome/fontawesome-free 安装失败问题
  - [x] `yarn add @fortawesome/fontawesome-free --dev` 安装 fontawesome
  - [x] `php artisan ui:auth` 安装 laravel auth
  - [x] 删除 Laravel auth 生成的我们不需要的文件
      - [x] `rm app/Http/Controllers/HomeController.php`
      - [x] `rm resources/views/home.blade.php`
  - [x] `composer require "overtrue/laravel-lang:~6.0"` 安装 Laravel 语言包
  - [x] `php artisan lang:publish zh_CN` 发布 Laravel 语言包
 

  ## 2024-08-21

- 运行的命令
  - [x] `php artisan migrate` 执行数据迁移文件
  - [x] `composer require "mews/captcha:~3.0"` 安装验证码包
  - [x] `php artisan vendor:publish --provider="Mews\Captcha\CaptchaServiceProvider"` 发布验证码配置文件
  - [x] `php artisan make:middleware EnsureEmailIsVerified` 创建邮箱认证中间件
  - [x] `php artisan event:generate` 生成监听器
- 完成的任务
  - 用户注册
  - 用户注册验证码
  - 邮箱认证
  - 强制用户认证
  - 认证成功提示
  - 密码重置以及重置成功后的提示

## 2024-08-22
- 运行的命令
    - [x] `php artisan make:controller UsersController` 创建 UsersController 控制器
    - [x] `php artisan make:migration add_avatar_and_introduction_to_users_table --table=users` 添加头像和个人简介字段到 users 表
- 完成的任务
    - 编辑个人资料
    - 显示个人资料
    - 上传头像，需要去 public/uploads/images/avatars/.gitignore 文件中添加忽略规则，防止上传的头像文件被 git 管理 


## 2024-08-23
- 运行的命令
    - [x] `composer require imagine/imagine` 安装 imagine/imagine 图片处理库，用于裁切图片
    - [x] `php artisan make:model Category -m` 创建 Category 模型和数据迁移文件，-m 选项表示同时创建数据迁移文件
    - [x] `php artisan make:migration seed_categories_data` 创建填充 categories 表数据的数据迁移文件
    - [x] `php artisan migrate` 执行数据迁移文件
    - [x] `composer require "summerblue/generator:9.*" --dev` 安装 laravel 代码生成器
    - [x] `php artisan make:scaffold Topic --schema="title:string:index,body:text,user_id:bigInteger:unsigned:index,category_id:integer:unsigned:index,reply_count:integer:unsigned:default(0),view_count:integer:unsigned:default(0),last_reply_user_id:integer:unsigned:default(0),order:integer:unsigned:default(0),excerpt:text:nullable,slug:string:nullable""`
    - [x] `php artisan make:scaffold Topic --schema="title:string:index,body:text,user_id:bigInteger:unsigned:index,category_id:integer:unsigned:index,reply_count:integer:unsigned:default(0),view_count:integer:unsigned:default(0),last_reply_user_id:integer:unsigned:default(0),order:integer:unsigned:default(0),excerpt:text:nullable,slug:string:nullable"`
      用 generator 生成 Topic 的模型、控制器、视图、数据迁移文件等
    - [x] `php artisan make:seed UsersTableSeeder` 创建填充 users 表数据的数据迁移文件
    - [x] `php artisan db:seed` 执行数据填充
    - [x] `php artisan migrate:refresh --seed` 刷新数据库并填充数据，在生产环境中不要使用

- 完成的任务
    - 裁切头像
    - 创建分类数据模型并且填充数据
    - 使用 laravel 代码生成器生成 Topic 的模型、控制器、视图、数据迁移文件等
    - 用户数据填充
    - 话题数据填充
    - 话题列表页

- 在 Windows 下 PhpStorm 中 shift + control + o 打开某个文件，在 Mac 下是 shift + command + o

- 创建 topics 表
    - `title:string:index` 标题 string 需要索引
    - `body:text` 内容 text
    - `user_id:bigInteger:unsigned:index` 用户 int unsigned index
    - `category_id:integer:unsigned:index` 分类 int unsigned index
    - `reply_count:integer:unsigned:default(0)` 回复数 int 默认 0
    - `view_count:integer:unsigned:default(0)` 查看数 int 默认 0
    - `last_reply_user_id:integer:unsigned:default(0)` 最后回复用户 int 默认 0
    - `order:integer:unsigned:default(0)` 排序 int 默认 0
    - `excerpt:text:nullable` 摘要 text 可为空
    - `slug:string:nullable` slug string 可为空

- 执行命令 `php artisan make:scaffold Topic --schema="title:string......` 后自动创建的文件
    - ----------- scaffolding: Topic -----------
    -
    - \+ ./database/migrations/2024_08_23_104426_create_topics_table.php // 创建 topics 表
    - \+ ./database/factories/TopicFactory.php // 创建 TopicFactory 工厂
    - \+ ./database/seeders/TopicsTableSeeder.php // 创建 TopicsTableSeeder 填充 topics 表数据
    - \+ ./database/seeders/DatabaseSeeder.php (Updated) // 更新 DatabaseSeeder 文件
    - \+ ./app/Models/Model.php (Updated) // 更新 Model 文件
    - \+ ./app/Models/Topic.php // 创建 Topic 模型
    - \+ ./app/Http/Controllers/TopicsController.php // 创建 TopicsController 控制器
    - \+ ./app/Http/Requests/Request.php // 创建 Request 请求类
    - \+ ./app/Http/Requests/TopicRequest.php // 创建 TopicRequest 请求类
    - \+ ./app/Observers/UserObserver.php (Skipped) // 创建 UserObserver 观察者, 跳过
    - \+ ./app/Observers/TopicObserver.php // 创建 TopicObserver 观察者
    - \+ ./app/Providers/AppServiceProvider.php (Updated) // 更新 AppServiceProvider 文件
    - \+ ./app/Policies/Policy.php // 创建 Policy 策略
    - \+ ./app/Policies/TopicPolicy.php // 创建 TopicPolicy 策略
    - \+ ./app/Providers/AuthServiceProvider.php (Updated) // 更新 AuthServiceProvider 文件
    - \+ ./routes/web.php (Updated) // 更新 web.php 路由文件
    -
     - --- Views ---
    - \+ create_and_edit.blade.php // 创建和编辑视图
    - \+ index.blade.php // 列表视图
    - \+ show.blade.php // 详情视图
    - x ./resources/views/layouts/app.blade.php (Skipped) // 跳过 layouts/app.blade.php
    - \+ ./resources/views/common/error.blade.php // 创建 common/error.blade.php
    - INFO Running migrations. // 执行数据迁移
    -
    - 2024_08_23_104426_create_topics_table .................................... 44ms DONE // 创建 topics 表

 ## 2024-08-26
- 运行的命令
    - [x] `composer require "barryvdh/laravel-debugbar:~3.6" --dev` 安装调试工具
    - [x] `php artisan vendor:publish --provider="Barryvdh\Debugbar\ServiceProvider"` 发布调试工具配置文件
    - [x] `php artisan make:controller CategoriesController` 创建 CategoriesController 控制器
    - [x] `composer require "summerblue/laravel-active:9.*"` 安装 laravel-active

- 完成的任务
    - 性能优化
    - 分类下的话题列表
    - 话题列表排序

## 2024-08-27
- 安装 simditor
    - 下载 [simditor](https://github.com/mycolorway/simditor/releases/download/v2.3.6/simditor-2.3.6.zip)
    - 将 styles/simditor.css 放在 resources/css 目录下
    - 将 scripts/module.js, scripts/hotkeys.js, scripts/uploader.js, scripts/simditor.js 放在 resources/js 目录下
    - `yarn add jquery` 安装 jquery, 安装完成后在 resources/js/bootstrap.js 中引入
    - `yarn run watch-poll` 编译前端资源
- 今天做了些什么
    - 在用户个人页面，展示用户创建的话题
    - 用户创建话题
    - 在创建话题的时候通过 Eloquence ORM 触发的事件，自动生成话题摘要
    - 话题详情页
    - 引入了 simditor 所见即所得编辑器
    - 处理 simditor 上传图片
- Eloquence ORM 触发的事件
    - creating, 创建的时候触发
    - created, 创建完成后触发
    - updating, 更新的时候触发
    - updated, 更新完成后触发
    - saving, 保存的时候触发
    - saved, 保存完成后触发
    - deleting, 删除的时候触发
    - deleted, 删除完成后触发
    - restoring, 恢复的时候触发
    - restored 恢复完成后触发
