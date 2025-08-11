<?php

namespace App\Http\Middleware;

use App\Models\Exam;
use App\Traits\ToastInterface;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EnsureExamIsInProcess
{
    use ToastInterface;
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $exam = $request->route("exam");
        if (!$exam->in_process) {
            $this->constructToastMessage("Tražena provjera znanja nije u tijeku!", "Neuspjeh", "error");
            return to_route("exams.list");
        }

        return $next($request);
    }
}
