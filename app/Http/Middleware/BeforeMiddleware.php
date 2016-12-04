<?php

namespace App\Http\Middleware;

use Closure;

class BeforeMiddleWare extends CacheMiddleware
{

    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \Closure                 $next
     *
     * @param null                      $prefix
     *
     * @return mixed
     */
    public function handle($request, Closure $next, $prefix = null)
    {
        $key = $this->keygen($request, $prefix);

        if ($this->cache->has($key)) {
            $content = $this->cache->get($key);

            return response($content);
        }

        return $next($request);
    }
}