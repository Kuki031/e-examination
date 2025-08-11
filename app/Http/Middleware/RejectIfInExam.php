<?php

namespace App\Http\Middleware;

use App\Traits\ToastInterface;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class RejectIfInExam
{
    use ToastInterface;
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {

        if (Auth::user()->is_in_exam) {
            $this->constructToastMessage("Već ste u provjeri znanja!", "Neuspjeh", "error");
            return back();
        }

        return $next($request);
    }
}
