<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;
use App\Traits\GeneralTrait;

class ChaekWriter
{
    use GeneralTrait;
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    



    public function handle($request, Closure $next)
    {
        if(Auth::user()->type === 'writer') {
            return $next($request);
        }
        else {

            return $this->returnError(400,"The is No Writer");

            // return response()->json(['error' => 'Unauthorized'], 403);
        }
    }
}



