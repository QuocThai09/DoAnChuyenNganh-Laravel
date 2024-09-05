<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\RedirectResponse;
use \Illuminate\Support\Facades\Cookie;

class CheckLogIn
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if(!isset($_SESSION)) session_start();
        if(isset($_SESSION['user'])){
            return $next($request);
        }else{
            return redirect('/login');
        }
    }
}
