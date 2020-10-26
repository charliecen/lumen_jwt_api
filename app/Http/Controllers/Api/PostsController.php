<?php


namespace App\Http\Controllers\Api;


use App\Exceptions\Code;
use App\Exceptions\Msg;
use App\Http\Controllers\Controller;
use App\Http\Requests\PostRequest;
use App\Jobs\TestQueue;
use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use PHPUnit\Util\Test;

class PostsController extends Controller
{

    /**
     * @return \Illuminate\Http\JsonResponse
     * 文章列表
     */
    public function index()
    {
        $posts = Post::paginate(env('PAGINATE', 10));
        if ($posts) {
            return resp(Code::PostsListSuccess, Msg::PostsListSuccess, $posts);
        }
        return resp(Code::PostsListFailed, Msg::PostsListFailed);
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     * 新增文章
     */
    public function store(Request $request)
    {
        $message = [
            'title.required'    => '请输入标题',
            'title.string'      => '标题必须为字符串',
            'title.max'         => '标题最多 :max 字符',
            'content.required'  => '请输入内容',
            'content.string'    => '内容必须为字符串'
        ];
        $validator = Validator::make($request->input(), [
            'title'     => 'required|string|max:10',
            'content'   => 'required|string',
        ], $message);

        if ($validator->fails()) {
            foreach($validator->errors()->getMessages() as $error) {
                return resp(Code::CreateUserFailed, $error[0]);
            }
        }

        $attributes = $request->only('title', 'content');
        $attributes['user_id'] = 1; //auth()->user()->id;
        $post = Post::create($attributes);
        if ($post) {
            return resp(Code::CreatePostsSuccess, Msg::CreatePostsSuccess, $post);
        }
        return resp(Code::CreatePostsFailed, Msg::CreatePostsFailed);
    }


    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     * 使用队列分发
     */
    public function store_with_mq(Request $request)
    {
        $rules = [
            'title'     => 'required|max:10',
            'content'   => 'required',
        ];
//        $message = [
//            'required'  =>  ':attribute 不能为空',
//            'max'       =>  ':attribute 不能超过 :max 字符',
//        ];
        $message = [];
        $attributes = [
            'title'     =>  '标题',
            'content'   =>  '内容'
        ];
        $validator = Validator::make($request->all(), $rules, $message, $attributes);
        if ($validator->fails()) {
            foreach($validator->errors()->getMessages() as $error) {
                return resp(Code::CreateUserFailed, $error[0]);
            }
        }

        $attributes = $request->only('title', 'content');
        $attributes['user_id'] = 1; //auth()->user()->id;
        // 加入mq队列中
        $this->dispatch(new TestQueue($attributes));
//        $post = Post::create($attributes);
//        if ($post) {
            return resp(Code::CreatePostsSuccess, Msg::CreatePostsSuccess);
//        }
//        return resp(Code::CreatePostsFailed, Msg::CreatePostsFailed);
    }

}
