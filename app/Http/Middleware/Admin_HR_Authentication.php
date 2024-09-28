<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class Admin_HR_Authentication
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        if(Session()->has('HR__ADMIN__session')){
            return $next($request);
        }else{
            session(['show_HR__ADMIN_LoginAlert' => true]);
            return redirect()->route('login')->with('loginAlert', 'To access further pages, please login first');
        }
    }
}
