<?php

namespace App\Http\Requests;

use Pearl\RequestValidate\RequestAbstract;

class PostRequest extends RequestAbstract
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules(): array
    {
        return [
            'title'     => 'required|max:10',
            'content'   => 'required',
        ];
    }

    /**
     * Get custom messages for validator errors.
     *
     * @return array
     */
    public function messages(): array
    {
        return [
            'required'  =>  ':attribute 不能为空',
            'max'  =>  ':attribute 不能超过 :max 字符',

//            'title.required'    => '请输入标题',
//            'title.string'      => '标题必须为字符串',
//            'title.max'         => '标题最多 :max 字符',
//            'content.required'  => '请输入内容',
//            'content.string'    => '内容必须为字符串'
        ];
    }

    public function attributes(): array
    {
        return [
            'title'     =>  '标题',
            'content'   =>  '内容'
        ];
    }
}
