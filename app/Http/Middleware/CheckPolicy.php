<?php

namespace App\Http\Middleware;

use Closure;
use App\Event;

class CheckPolicy
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next){
        if(intval($request->creator_id) === intval($request->user()->id) ){
            return $next($request);
        }
        return response()->json('Forbiden' , 403);
    }
}
