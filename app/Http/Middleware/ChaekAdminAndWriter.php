<?php

namespace App\Http\Middleware;
use Illuminate\Support\Facades\Auth;

use App\Traits\GeneralTrait;
use Closure;

class ChaekAdminAndWriter
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
        if(Auth::user()->type === 'admin'||Auth::user()->type === 'writer') {
            return $next($request);
        }
        else {

            return $this->returnError(400,"The is No Admin and No Writer ");

            // return response()->json(['error' => 'Unauthorized'], 403);
        }
    }
}
