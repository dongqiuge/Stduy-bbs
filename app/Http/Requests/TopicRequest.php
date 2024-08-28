<?php

namespace App\Http\Requests;

class TopicRequest extends Request
{
    /**
     * 自定义验证规则
     *
     * @return array|string[]
     */
    public function rules(): array
    {
        switch ($this->method()) {
            // CREATE
            case 'POST':
                // UPDATE
            case 'PUT':
            case 'PATCH':
            {
                return [
                    'title' => 'required|min:2',
                    'body' => 'required|min:3',
                    'category_id' => 'required|numeric',
                ];
            }
            case 'GET':
            case 'DELETE':
            default:
            {
                return [];
            }
        }
    }

    /**
     * 自定义错误信息
     *
     * @return string[]
     */
    public function messages(): array
    {
        return [
            'title.min' => '标题至少需要两个字符',
            'body.min' => '内容至少需要三个字符',
        ];
    }
}
