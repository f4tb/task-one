<?php

namespace App\Http\Middleware;

use App\Helpers\ApiHelper;
use Closure;
use Illuminate\Http\Request;

class AdminRole
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        if ($request->user()->role != "admin"){
            if ($request->wantsJson()){
                return response()->json(ApiHelper::std_response_format([
                    'success' => true,
                    'error' => array('message' => 'Forbidden!'),
                    'errors' => [],
                    'data' => []
                ]), 403);
            } else {
                return abort(403);
            }
        }
        return $next($request);
    }
}
