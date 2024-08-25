<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

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
