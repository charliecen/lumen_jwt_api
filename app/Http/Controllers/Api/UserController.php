<?php


namespace App\Http\Controllers\Api;


use App\Exceptions\Code;
use App\Exceptions\Msg;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Validator;
use App\Http\Controllers\Controller;

class UserController extends Controller
{

    /**
     * UserController constructor.
     * 认证中间件,排除登录和注册
     */
    public function __construct()
    {
        $this->middleware('auth:api', ['except' => ['login','store']]);
    }

    /**
     * @return \Illuminate\Http\JsonResponse
     * 所有用户
     */
    public function index() {
        $users = User::paginate(env('PAGINATE', 10));
        return resp(Code::Success, Msg::Success, $users);
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     * 登录
     */
    public function login(Request $request) {
        $message = [
            'username.required' => "请输入用户名",
            'password.required' => "请输入密码",
        ];
        $validator = Validator::make($request->all(), [
            'username' => 'required',
            'password'  => 'required'
        ], $message);
        if ($validator->fails()) {
            foreach($validator->errors()->getMessages() as $error) {
                return resp(Code::LoginFailed, $error[0]);
            }
        }
        $credentials = request(['username', 'password']);
        if (! $token = auth()->attempt($credentials)) {
            return resp(Code::LoginFailed, Msg::LoginFailed);
        }
        return resp(Code::LoginSuccess, Msg::LoginSuccess, $this->responseWithToken($token));
    }

    /**
     * @param $token
     * @return array
     * 返回token信息
     */
    protected function responseWithToken($token) {
        return [
            'access_token' => $token,
            'token_type'    => 'bearer',
            'expires_in'    => auth()->factory()->getTTL() * env('JWT_TTL', 60)
        ];
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     * 创建用户
     */
    public function store(Request $request)
    {
        $message = [
            'email.required'    => '请输入邮箱',
            'email.email'       => '邮箱格式不正确',
            'email.unique'      => '邮箱已存在',
            'username.required' => '请输入用户名',
            'password.required' => '请输入密码',
            'username.min'      => '用户名至少 :min 位',
            'password.min'      => '密码至少 :min 位',
        ];
        $validator = Validator::make($request->input(), [
            'email' => 'required|email|unique:users',
            'username' => 'required|min:6',
            'password' => 'required|min:8',
        ], $message);

        if ($validator->fails()) {
            foreach($validator->errors()->getMessages() as $error) {
                return resp(Code::CreateUserFailed, $error[0]);
            }
        }
        $username = $request->get('username');
        $email = $request->get('email');
        $password = $request->get('password');

        $attributes = [
            'email' => $email,
            'username' => $username,
            'password' => app('hash')->make($password)
        ];
        $user = User::create($attributes);
        return resp(Code::CreateUserSuccess, Msg::CreateUserSuccess, $user);
    }

    /**
     * @return \Illuminate\Http\JsonResponse
     * 当前用户信息
     */
    public function me() {
        return resp(Code::UserIsMe, Msg::UserIsMe, auth()->user());
    }

    /**
     * @return \Illuminate\Http\JsonResponse
     * 退出登录
     */
    public function logout() {
        auth()->logout();
        return resp(Code::LoginOutSuccess, Msg::LoginOutSuccess);
    }

    /**
     * @return array
     * 刷新token
     */
    public function refresh(){
        return $this->responseWithToken(auth()->refresh());
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     * 切换语言
     */
    public function changeLocale(Request $request)
    {
        if ($request->has('lan')){
            $lan = $request->get('lan');
            if (in_array($lan, ['en','zh'])) {
                Cache::put('lan_' . Auth::id(), $lan);
            }
            return resp(Code::Success, Msg::Success);
        }
        return resp(Code::Failed, Msg::Failed);
    }
}
