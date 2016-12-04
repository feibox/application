<?php
namespace App\Http\Middleware;

use Closure;

class AfterMiddleWare extends CacheMiddleware
{

    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \Closure                 $next
     *
     * @return mixed
     */
    public function handle($request, Closure $next, $prefix = null)
    {
        $response = $next($request);

        $key = $this->keygen($request, $prefix);

        if ( ! $this->cache->has($key)) {
            $this->cache->put($key, $response->getContent(), 30);
        }

        return $response;
    }
}