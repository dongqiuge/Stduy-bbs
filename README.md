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
    - 
    - 上传头像，需要去 public/uploads/images/avatars/.gitignore 文件中添加忽略规则，防止上传的头像文件被 git 管理 
    - 
