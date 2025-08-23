<?php

namespace App\Http\Middleware;

use App\Models\User;
use App\Traits\ToastInterface;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EnsureUserIsAllowed
{
    use ToastInterface;
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $user = User::where("pin_value", "=", $request->pin_value)->first();

        if (!$user) {
            return $next($request);
        }

        else if ($user && !$user->is_allowed && $user->is_in_pending_status) {
            $this->constructToastMessage("Odobrenje vaše registracije je još uvijek u tijeku. U slučaju nedoumica, kontaktirajte administratora!", "Prijava neuspješna", "error", 7000);
            return back();
        }
        else if ($user && !$user->is_allowed && !$user->is_in_pending_status) {
            $this->constructToastMessage("Vaša registracija je odbijena. U slučaju nedoumica, kontaktirajte administratora!", "Prijava neuspješna", "error", 7000);
            return back();
        }

        return $next($request);
    }
}
