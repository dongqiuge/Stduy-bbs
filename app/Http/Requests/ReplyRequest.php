<?php

namespace App\Http\Requests;

/**
 * @property mixed content
 * @property mixed topic_id
 */
class ReplyRequest extends Request
{
    /**
     * 验证规则
     *
     * @return string[]
     */
    public function rules(): array
    {
        return [
            'content' => 'required|min:2',
        ];
    }

    /**
     * 自定义错误消息
     *
     * @return string[]
     */
    public function messages(): array
    {
        return [
            'content.required' => '内容不能为空',
            'content.min' => '内容至少两个字符',
        ];
    }
}
