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
     *
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $key = $this->keygen($request, $request->user()->id);

        if ($this->cache->has($key)) {
            $content = $this->cache->get($key);

            return response($content);
        }

        return $next($request);
    }
}