<?php

namespace App\Http\Middleware;

use App\Subject;
use Closure;

class CheckSubject
{
    private $subject;

    public function __construct(Subject $subject)
    {
        $this->subject = $subject;
    }

    /**
     * Handle an incoming request.
     *
     * @param \Illuminate\Http\Request $request
     * @param \Closure                 $next
     *
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $subject = $this->subject->findOrFail($request->subject_id);
        if ($subject->is_valid && $subject->is_enabled) {
            return $next($request);
        }
        abort(404);
    }
}
