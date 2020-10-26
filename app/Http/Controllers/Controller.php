<?php

namespace App\Http\Controllers;

use App\Exceptions\Code;
use Illuminate\Support\Facades\Validator;
use Laravel\Lumen\Routing\Controller as BaseController;

class Controller extends BaseController
{

    /**
     * 检测表单
     *
     * @param $args 必须参数
     * @param $data 表单请求参数
     * @return mixed|void
     */
    protected function checkRequest($args, $data)
    {
        $rules = $attributes = $message = [];
        foreach($args as $k){
            $rules[$k] = config('rules')[$k];
            if (env('APP_LOCALE') == 'zh')
                $attributes[$k] = config('attributes')[$k];
        }
        $validator = Validator::make($data, $rules, $message, $attributes);
        if ($validator->fails()) {
            foreach($validator->errors()->getMessages() as $error) {
                return $error[0];
            }
        }
        return;
    }
}
