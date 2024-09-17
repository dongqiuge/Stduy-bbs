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

  ## 2024-08-28
- 运行的命令
    - [x] `composer require "mews/purifier:~3.3"` 安装 HTML 过滤器
    - [x] `php artisan vendor:publish --provider="Mews\Purifier\PurifierServiceProvider"` 发布 HTML 过滤器配置文件
    - [x] `php artisan make:scaffold Reply --schema="topic_id:integer:unsigned:default(0):index,user_id:bigInteger:unsigned:default(0):index,content:text"` 生成回复模型、控制器、视图、数据迁移文件等
    - [x] `php artisan make:scaffold Reply --schema="topic_id:integer:unsigned:default(0):index,user_id:bigInteger:unsigned:default(0):index,content:text"`
      生成回复模型、控制器、视图、数据迁移文件等
    - [x] `php artisan migrate:refresh --seed` 刷新数据库并填充数据，填充回复数据（生产环境不要使用）
- 做了些什么
    - XSS 过滤
    - 话题编辑
    - 话题删除
    - 生成回复模型、控制器、视图、数据迁移文件等
    - 生成回复数据填充文件
    - 回复列表

## 2024-08-29
- 做了些什么
    - 发表回复
    - 消息通知
    - 通知列表
    - 了解了什么是 JSON
- 运行的命令
    - [x] `php artisan notifications:table` 创建通知数据表的迁移文件
    - [x] `php artisan migrate` 执行数据迁移
    - [x] `php artisan make:migration add_notification_count_to_users_table --table=users` 添加通知数量字段到 users 表
    - [x] `php artisan migrate` 写完生成的数据迁移文件，再次执行数据迁移
    - [x] `php artisan make:notification TopicReplied` 创建话题回复通知
## 2024-09-02
- 运行的命令
    - [x] `composer require "predis/predis:~1.1"` 安装 predis
    - [x] `composer require "laravel/horizon:~5.9""` 安装 laravel horizon
    - [x] `php artisan vendor:publish --provider="Laravel\Horizon\HorizonServiceProvider"` 发布 horizon 配置文件
    - [x] `php artisan horizon` 启动 horizon 队列监控
- 今天做了些什么
    - 收到新的回复的时候使用邮件通知用户
    - 使用队列来发送邮件通知
    - 队列监控
    - 删除回复
    - 删除回复的时候去更新话题的回复数
    - 当删除话题的时候，删除话题下的所有回复
## 2024-09-03
- Role 数据模型作为角色的表现（游客、用户、管理员、站长等）
- 角色能做动作，我们称之为权限，Permission 数据模型作为权限的表现（查看、创建、编辑、删除等）
- RBAC 权限管理
    - Role-Based Access Control 基于角色的访问控制
    - 通过角色来控制用户的权限
    - 一个用户可以拥有多个角色
    - 一个角色可以拥有多个权限
    - 一个权限可以被多个角色拥有
    - 一个用户可以拥有多个权限（但是一般情况下，我们是通过角色来控制用户的权限）
- 通常的 RBAC 权限管理的表结构
    - users 用户表
    - roles 角色表（财务、人事、销售、技术、管理员等）
    - permissions 权限表（查看不同部门的数据、编辑不同部门的数据、删除不同部门的数据等），对应的是具体的操作
    - role_has_permissions 角色拥有的权限表关联关系表（例如：管理员拥有查看、编辑、删除不同部门的数据的权限）
    - model_has_roles 模型拥有的角色表（用户拥有什么角色），用户和角色的关联关系表
    - model_has_permissions 模型拥有的权限表（用户拥有什么权限），用户和权限的关联关系表，但是一般情况下我们是通过角色来控制用户的权限
- spaties/laravel-permission 是一个权限管理的包,他帮我们已经设计好了数据库表结构
    - roles 角色的模型表；
    - permissions 权限的模型表；
    - model_has_roles 模型与角色的关联表，用户拥有什么角色在这个表中定义，一个用户能拥有多个角色；
    - role_has_permissions 角色拥有的权限关联表，如管理员拥有查看后台的权限都是在次表中定义，一个角色能拥有多个权限；
    - model_has_permissions 模型与权限的关联表，一个模型能拥有多个权限；
- spaties/laravel-permission 的使用
    - 创建角色 `Role::create(['name' => 'admin'])`
    - 创建权限 `Permission::create(['name' => 'edit articles'])`
    - 给角色赋予权限 `$role->givePermissionTo('edit articles')`
    - 检查角色是否有权限 `$role->hasPermissionTo('edit articles')`
    - 检查用户是否有角色 `$user->hasRole('admin')`
    - 给用户赋予角色 `$user->assignRole('admin')` 或 `$user->syncRoles(['admin', 'writer'])`
    - 撤销用户的角色 `$user->removeRole('admin')`
    - 是否拥有任意角色 `$user->hasAnyRole(Role::all())`
    - 是否拥有所有角色 `$user->hasAllRoles(Role::all())`
    - 获取用户的所有角色 `$user->getRoleNames()`
    - 检查用户是否拥有某个权限 `$user->can('edit articles')`
- 执行的命令
    - [x] `composer require "spatie/laravel-permission:~5.5"` 安装 spatie/laravel-permission
    - [x] `php artisan vendor:publish --provider="Spatie\Permission\PermissionServiceProvider"` 发布
      spatie/laravel-permission 配置文件
    - [x] `php artisan migrate` 执行数据迁移
    - [x] `php artisan make:migration seed_roles_and_permissions_data` 创建填充 roles 和 permissions 表数据的数据迁移文件
    - [x] `php artisan migrate:refresh --seed` 刷新数据库并填充数据（在执行这条命令的时候需要跳过 Replies
      模型的事件监听器），生产环境不要使用
    - [x] `composer require lab404/laravel-impersonate` 安装 lab404/laravel-impersonate 包，用于登录为其他用户
    - [x] `php artisan vendor:publish` 发布 lab404/laravel-impersonate 配置文件，选择发布 Provider:
      Lab404\Impersonate\ImpersonateServiceProvider
## 2024-09-04
- 执行的命令
    - [x] `composer require "summerblue/administrator:9.*"` 安装 summerblue/administrator
    - [x] `php artisan vendor:publish --provider="Frozennode\Administrator\AdministratorServiceProvider"` 发布
      summerblue/administrator 配置文件
    - [x] `mkdir -p config/administrator/settings` 创建配置文件夹
    - [x] `touch config/administrator/settings/.gitkeep` 创建 .gitkeep 文件, 在空文件夹中放置 .gitkeep 保证了 Git
      会将此文件夹纳入版本控制器中。
- 今天做了些什么
    - 解决了昨天切换当前登录的用户的问题
    - 使用 summerblue/administrator 来管理用户、话题、回复、分类、角色、权限等
    - 管理后台用户管理
## 2024-09-05
- 今天做了些什么
    - 管理后台话题管理
    - 管理后台回复管理
    - 管理后台分类管理
    - 管理后台站点设置
    - 管理后台权限管理
    - 访问后台权限控制
## 2024-09-06
- 今天做了些什么
    - 侧边栏活跃用户
        - 活跃用户算法：<b>每个小时</b> ** <b>计算一次</b>，<b>统计</b> ** <b>最近 7 天</b> 所有用户的 <b>帖子数</b>
          和 <b>评论数</b>，用户每发一个帖子则得 4 分，每发一个回复得 1 分，计算出所有人的得分后再倒序，取前 8 个用户
        - 假设用户 A 在 7 天发了 10 篇帖子，发了 5 条评论，则其得分为 `10 * 4 + 5 * 1 = 45` 分
    - 修改 .env 文件中的 `CACHE_DRIVER=file` 为 `CACHE_DRIVER=redis`，使用 redis 作为缓存驱动
- 执行的命令
    - [x] `php artisan make:command CalculateActiveUser --command=larabbs:calculate-active-user` 创建计算活跃用户的命令
    - [x] `php artisan larabbs:calculate-active-user` 执行计算活跃用户的命令
    - [x] `php artisan cache:clear` 清除缓存
    - [x] `php artisan schedule:run` 执行计划任务
    - [x] `php artisan make:model Link -m` 创建 Link 模型和数据迁移文件
    - [x] `php artisan migrate` 执行数据迁移
    - [x] `php artisan make:factory LinkFactory` 创建 LinkFactory 工厂
    - [x] `php artisan make:seeder LinksTableSeeder` 创建 LinksTableSeeder 填充 links 表数据
    - [x] `php artisan migrate:refresh --seed` 执行数据填充
- 在 Mac 下，可以使用 `crontab -e`
  编辑计划任务，然后添加 `* * * * * cd /你的项目的绝对路径 && php artisan schedule:run >> /dev/null 2>&1`，每分钟执行一次计划任务
## 2024-09-09
- 添加外键约束，避免坏数据
    - 当用户被删除时，删除该用户发布的话题
    - 当用户被删除时，删除该用户发布的回复
    - 当话题被删除时，删除该话题下的回复
- 用户最后活跃时间，每次用户请求的时候，更新用户最后活跃时间，但是因为这样会频繁更新数据库，影响性能，所以我们可以使用缓存来解决这个问题
    - 记录 - 通过中间件过滤用户所有请求，记录用户访问时间到 Redis 按日期区分的哈希表
    - 同步 - 新建命令，计划任务每天运行一次此命令，将昨日哈希表里的数据同步到数据库中，并删除昨日哈希表
    - 读取 - 优先读取当日哈希表里 Redis 里的数据，无数据则使用数据库里的值
- 执行的命令
    - [x] `php artisan make:migration add_references` 创建添加外键约束的数据迁移文件
    - [x] `php artisan migrate` 执行数据迁移
    - [x] `php artisan make:middleware RecordLastActivedTime` 创建记录用户最后活跃时间的中间件
    - [x] `php artisan make:migration add_last_activated_at_users_table --table=users` 添加用户最后活跃时间字段到 users 表
    - [x] `php artisan make:migration add_last_activated_at_users_table --table=users` 添加用户最后活跃时间字段到 users
      表
    - [x] `php artisan migrate` 执行数据迁移
    - [x] `php artisan make:command SyncUserActivated --command=larabbs:sync-user-activated-at` 创建同步用户最后活跃时间的命令
    - [x] `php artisan larabbs:sync-user-activated-at` 执行同步用户最后活跃时间的命令

## 2024-09-10

- 今天做了些什么
    - 站点首页显示为话题列表页面
    - 用户默认头像
- 章节总结
    - 使用 Traits 来为数据模型瘦身
    - 使用缓存系统来加快数据读取
    - 自定义 Artisan 命令来完成一些特殊的任务
    - 使用 Laravel 的任务调度系统来执行计划任务
    - 了解数据损坏的风险，使用外键约束来避免坏数据
    - 自定义中间件来统计用户最后活跃时间
    - 使用 Redis 的哈希表来缓解数据库压力
