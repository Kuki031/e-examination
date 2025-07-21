<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Traits\ToastInterface;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;


class AdminController extends Controller
{
    use ToastInterface;
    public function getNewlyRegisteredUsers()
    {
        $unconfirmedUsers =
        User::where("is_in_pending_status", "=", 1)
        ->where("is_allowed", "=", 0)
        ->paginate(5);

        return view("admin.requests", compact("unconfirmedUsers"));

    }

    public function countRequests()
    {
        $users = User::where("is_in_pending_status", "=", 1)
        ->where("is_allowed", "=", 0)
        ->count();
        return response()->json(['count' => $users]);
    }

    public function approveRegistration(User $user)
    {
        $user->update([
            "is_allowed" => true,
            "is_in_pending_status" => false
        ]);

        $this->constructToastMessage("Korisniku sa {$user->pin}-om {$user->pin_value} registracija odobrena!", "Registracija odobrena", "success", 4000);
        return back();

    }

    public function rejectRegistration(User $user)
    {
        $user->update([
            "is_allowed" => false,
            "is_in_pending_status" => false
        ]);

        $this->constructToastMessage("Korisniku sa {$user->pin}-om {$user->pin_value} registracija odbijena!", "Registracija odbijena", "warning", 4000);
        return back();
    }
}
