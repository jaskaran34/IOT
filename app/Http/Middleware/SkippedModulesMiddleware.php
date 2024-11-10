<?php

namespace App\Http\Middleware;
use App\Models\SkippedModule;
use Illuminate\Support\Facades\View;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class SkippedModulesMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {

        $skippedModulesCount = SkippedModule::count();

        // Share the count with all views
        View::share('skippedModulesCount', $skippedModulesCount);

        return $next($request);
       
    }
}
