<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Cache;

class ChangeLanguage
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if ($user = auth()->user()) {
            $key = 'lan_' . $user->id;
            if (Cache::has($key) && in_array(Cache::get($key), ['en', 'zh'])) {
                App::setLocale(Cache::get($key));
            } else {
                App::setLocale('zh');
            }
        } else {
            App::setLocale('zh');
        }
        return $next($request);
    }
}
