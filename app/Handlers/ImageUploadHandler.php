<?php

namespace App\Handlers;

use Illuminate\Support\Str;
use Imagine\Gd\Imagine;
use Imagine\Image\Box;

class ImageUploadHandler
{
    /**
     * 允许上传的图片后缀
     *
     * @var array|string[]
     */
    protected array $allowed_ext = ["png", "jpg", "gif", 'jpeg'];

    /**
     * 上传图片
     *
     * @param $file
     * @param $folder
     * @param $file_prefix
     * @param bool|int $max_width
     * @return array|bool
     */
    public function save($file, $folder, $file_prefix, bool|int $max_width = false): array|bool
    {
        // 构建存储的文件夹规则，值如：uploads/images/avatars/201709/21/
        // 文件夹切割能让查找效率更高。
        $folder_name = "uploads/images/$folder/" . date("Ym/d", time());

        // 文件具体存储的物理路径，`public_path()` 获取的是 `public` 文件夹的物理路径。
        // 值如：/home/vagrant/Code/bbs/public/uploads/images/avatars/201709/21/
        $upload_path = public_path() . '/' . $folder_name;

        // 获取文件的后缀名，因图片从剪贴板里黏贴时后缀名为空，所以此处确保后缀一直存在
        $extension = strtolower($file->getClientOriginalExtension()) ?: 'png';

        // 拼接文件名，加前缀是为了增加辨析度，前缀可以是相关数据模型的 ID
        // 值如：1_1493521050_7BVc9v9ujP.png
        $filename = $file_prefix . '_' . time() . '_' . Str::random(10) . '.' . $extension;

        // 如果上传的不是图片将终止操作
        if (!in_array($extension, $this->allowed_ext)) {
            return false;
        }

        // 将图片移动到我们的目标存储路径中
        $file->move($upload_path, $filename);

        // 如果限制了图片宽度，就进行裁剪
        if ($max_width && $extension != 'gif') {

            // 此类中封装的函数，用于裁剪图片
            $this->reduceSize($upload_path . '/' . $filename, $max_width);
        }

        return [
            'path' => config('app.url') . "/$folder_name/$filename"
        ];
    }

    /**
     * 使用 Imagine 库裁剪图片
     * composer require imagine/imagine
     *
     * @param $file_path
     * @param $max_width
     * @return void
     */
    public function reduceSize($file_path, $max_width): void
    {
        // 创建 Imagine 实例
        $imagine = new Imagine();

        // 打开图片并等比例缩放
        $imagine->open($file_path)
            ->thumbnail(new Box($max_width, $max_width))
            ->save($file_path);
    }
}
