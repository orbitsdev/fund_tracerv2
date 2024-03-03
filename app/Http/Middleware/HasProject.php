<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class HasProject
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {

        $user = Auth::user();

        if ($user && $user->is_financial()) {
            if ($user->assigned_project()->exists()) {
                return redirect()->route('dashboard');
            } else {
                return redirect()->route('financial-manager.forbidden');
            }
        }
        return $next($request);
    }
}
