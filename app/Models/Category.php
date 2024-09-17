<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Category
 * @property integer $id ID
 * @property string $name 分类名称
 * @property string $description 分类描述
 * @property integer $post_count 文章数量
 * @property-read Collection|Topic[] $topics 该分类下的所有话题
 * @extends Model
 */
class Category extends Model
{
    use HasFactory;

    /**
     * 不自动维护时间戳
     *
     * @var array
     */
    public $timestamps = false;

    /**
     * 可以被批量赋值的属性
     *
     * @var array
     */
    protected $fillable = ['name', 'description'];
}
