<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserAcess
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle($request, Closure $next, $func)
    {
        if(!Auth::check()){
            return redirect('/');
        }
        else if(($func == 'comum') && ((Auth::check()) && (Auth::user()->funcao == 'cid' || Auth::user()->funcao == 'emp') && (Auth::user()->ativo))){
            return $next($request);
        }
        else if((Auth::check()) && (Auth::user()->funcao == $func) && (Auth::user()->ativo)){
            return $next($request);
        }
        else{
            return redirect('/');
        }
    }
}
