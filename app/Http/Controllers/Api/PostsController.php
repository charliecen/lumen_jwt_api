<?php


namespace App\Http\Controllers\Api;


use App\Exceptions\Code;
use App\Exceptions\Msg;
use App\Http\Controllers\Controller;
use App\Jobs\TestQueue;
use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

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
            return resp(Code::PostsListSuccess, trans('msg.posts_list_success'), $posts);
        }
        return resp(Code::PostsListFailed, trans('msg.posts_list_success'));
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     * 新增文章
     */
    public function store(Request $request)
    {
        $args = ['title', 'content'];
        $data = $request->only($args);
        $error = $this->checkRequest($args, $data);
        if (!empty($error)) return resp(Code::Failed, $error);
        $data['user_id'] = Auth::id();
        $post = Post::create($data);
        if ($post) {
            return resp(Code::CreatePostsSuccess, trans('msg.create_post_success'), $post);
        }
        return resp(Code::CreatePostsFailed, trans('msg.create_post_failed'));
    }


    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     * 使用队列分发
     */
    public function store_with_mq(Request $request)
    {
        $args = ['title', 'content', 'phone'];
        $data = $request->only($args);
        $error = $this->checkRequest($args, $data);
        if (!empty($error)) return resp(Code::Failed, $error);
        $data['user_id'] = 1; //auth()->user()->id;
        // 加入mq队列中
        $this->dispatch(new TestQueue($data));
//        $post = Post::create($attributes);
//        if ($post) {
            return resp(Code::CreatePostsSuccess, Msg::CreatePostsSuccess);
//        }
//        return resp(Code::CreatePostsFailed, Msg::CreatePostsFailed);
    }

}
