<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class RejectIfAccessedExamToday
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {

        /*
        $checkAttempt = ExamAttempt::where("exam_id", $exam->id)
            ->where("user_id", Auth::id())
            ->where("created_at", ">=", Carbon::today())
            ->first();

        if ($checkAttempt) {
            $this->constructToastMessage("Već ste pristupili ovoj provjeri znanja!", "Neuspjeh", "error");
            return back();
        }
        */

        return $next($request);
    }
}
