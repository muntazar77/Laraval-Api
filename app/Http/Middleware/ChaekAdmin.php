<?php

namespace App\Http\Middleware;
use App\User;
use Closure;

use Illuminate\Support\Facades\Auth;
use App\Traits\GeneralTrait;

class ChaekAdmin
{
    use GeneralTrait;

    // public function handle($request, Closure $next)
    // {



    //     if ( Auth()->user()->isAdmin()) {
    //         // return $this->returnError(400,"The is No Admin");
    //         return $next($request);

    //         }
    //         return redirect()->guest('/');
    // }

    public function handle($request, Closure $next)
    {
        $user = Auth::user();
        if($user->type === 'admin') {
            return $next($request);
        }
        else {

            return $this->returnError(400,"The is No Admin");

            // return response()->json(['error' => 'Unauthorized'], 403);
        }
    }
}
