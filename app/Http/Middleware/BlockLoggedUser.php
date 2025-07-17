<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class BlockLoggedUser
{
    public function handle(Request $request, Closure $next)
    {
        if (Auth::guard('adotante')->check()) {
            return redirect()->route('home')->with('info', 'Você já está logado como adotante.');
        }

        if (Auth::guard('ong')->check()) {
            return redirect()->route('home')->with('info', 'Você já está logado como ONG.');
        }

        return $next($request);
    }
}
