<?php

namespace App\Http\Middleware;

use App\Models\Exam;
use App\Traits\ToastInterface;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class StopIfExamInProcess
{
    use ToastInterface;
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $examParam = $request->route('exam');

        $exam = $examParam instanceof Exam
            ? $examParam
            : Exam::findOrFail($examParam);

        if ($exam->in_process) {
            if ($request->expectsJson()) {
                return response()->json([
                    'message' => 'Provjera znanja je u tijeku. Ne možete ju ažurirati!',
                ], 403);
            }

            $this->constructToastMessage(
                "Provjera znanja je u tijeku. Ne možete ju ažurirati!",
                "Neuspjeh",
                "error"
            );
            return back();
        }

        return $next($request);
    }
}
