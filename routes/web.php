<?php

use App\Http\Controllers\UsersController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', 'TopicsController@index')->name('root');

// 用户身份验证相关的路由
Route::get('login', 'Auth\LoginController@showLoginForm')->name('login');
Route::post('login', 'Auth\LoginController@login');
Route::post('logout', 'Auth\LoginController@logout')->name('logout');

// 用户注册相关路由
Route::get('register', 'Auth\RegisterController@showRegistrationForm')->name('register');
Route::post('register', 'Auth\RegisterController@register');

// 密码重置相关路由
Route::get('password/reset', 'Auth\ForgotPasswordController@showLinkRequestForm')->name('password.request');
Route::post('password/email', 'Auth\ForgotPasswordController@sendResetLinkEmail')->name('password.email');
Route::get('password/reset/{token}', 'Auth\ResetPasswordController@showResetForm')->name('password.reset');
Route::post('password/reset', 'Auth\ResetPasswordController@reset')->name('password.update');

// 再次确认密码（重要操作前提示）
Route::get('password/confirm', 'Auth\ConfirmPasswordController@showConfirmForm')->name('password.confirm');
Route::post('password/confirm', 'Auth\ConfirmPasswordController@confirm');

// Email 认证相关路由
Route::get('email/verify', 'Auth\VerificationController@show')->name('verification.notice');
Route::get('email/verify/{id}/{hash}', 'Auth\VerificationController@verify')->name('verification.verify');
Route::post('email/resend', 'Auth\VerificationController@resend')->name('verification.resend');

// 个人页面
Route::resource('users', 'UsersController', ['only' => ['show', 'update', 'edit']]);
// 相当于
// Route::get('/users/{user}', 'UsersController@show')->name('users.show');
// Route::get('/users/{user}/edit', 'UsersController@edit')->name('users.edit');
// Route::patch('/users/{user}', 'UsersController@update')->name('users.update');

Route::resource('topics', 'TopicsController', ['only' => ['index', 'create', 'store', 'update', 'edit', 'destroy']]);
// GET|HEAD        topics ....................... topics.index › TopicsController@index // 显示所有话题列表
// POST            topics ....................... topics.store › TopicsController@store // 创建话题
// GET|HEAD        topics/create .............. topics.create › TopicsController@create // 创建话题的页面
// GET|HEAD        topics/{topic} ................. topics.show › TopicsController@show // 显示单个话题 （修改过后不包含这个路由了）
// PUT|PATCH       topics/{topic} ............. topics.update › TopicsController@update // 编辑话题
// DELETE          topics/{topic} ........... topics.destroy › TopicsController@destroy // 删除话题
// GET|HEAD        topics/{topic}/edit ............ topics.edit › TopicsController@edit // 编辑话题的页面
Route::get('topics/{topic}/{slug?}', 'TopicsController@show')->name('topics.show');

Route::resource('categories', 'CategoriesController', ['only' => ['show']]);

// 话题表单中的图片上传
Route::post('upload_image', 'TopicsController@uploadImage')->name('topics.upload_image');

// 话题回复
Route::resource('replies', 'RepliesController', ['only' => ['store', 'destroy']]);

// 通知列表
Route::resource('notifications', 'NotificationsController', ['only' => ['index']]);

// 模拟登录，用来测试 RBAC
Route::get('/impersonate/{id}', [UsersController::class, 'impersonateUser'])->name('impersonate');
Route::get('/stop-impersonating', [UsersController::class, 'stopImpersonating'])->name('stopImpersonating');

// 权限不足页面
Route::get('permission-denied', 'PagesController@permissionDenied')->name('permission-denied');
