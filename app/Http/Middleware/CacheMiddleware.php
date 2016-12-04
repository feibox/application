<?php

namespace App\Http\Middleware;

class CacheMiddleware {

    /**
     * @var \Illuminate\Cache\Repository
     */
    public $cache;


    public function __construct(\Illuminate\Cache\Repository $cache)
    {
        $this->cache = $cache;
    }

    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request $request
     *
     * @return string
     */
    protected function keygen(&$request, $prefix)
    {
        return $prefix.'_route_' . str_slug($request->fullUrl());
    }
}