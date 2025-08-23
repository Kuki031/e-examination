<?php

namespace App\Http\Middleware;

use App\Traits\ToastInterface;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class EnsureUserIsTeacherOrAdmin
{
    use ToastInterface;
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $allowedRoles = ["admin", "teacher"];

        if (!in_array(Auth::user()->role, $allowedRoles))
        {
            $this->constructToastMessage(message: "Nemate pravo pristupa ovoj lokaciji!", title: "Zabranjen pristup", model: "error");
            return back();
        }

        return $next($request);
    }
}
