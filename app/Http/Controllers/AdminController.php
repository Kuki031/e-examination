<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Traits\ToastInterface;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AdminController extends Controller
{
    use ToastInterface;
    public function getAllUsers()
    {
        $users =
        User::orderByDesc("created_at")
        ->paginate(5);

        return view("admin.users", compact("users"));
    }

    public function getUserProfile(User $user)
    {
        return view("admin.users_profile", compact("user"));
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

        DB::table('sessions')->where('user_id', $user->id)->delete();

        $this->constructToastMessage("Korisniku sa {$user->pin}-om {$user->pin_value} registracija odbijena!", "Registracija odbijena", "warning", 4000);
        return back();
    }

    public function assignRole(User $user, Request $request)
    {

        if ($request->role === 'teacher')
        {
            $user->update([
                "role" => $request->role,
                "registration_type" => "teacher"
            ]);
        } else if ($request->role === 'student') {
            $user->update([
                "role" => $request->role,
                "registration_type" => "student"
            ]);
        } else {
            $this->constructToastMessage(message: "Odaberite ulogu nastavnik ili student!", title: "Neuspjela dodjela uloge", model: "error");
            return back();
        }

        $this->constructToastMessage(message: "Uloga korisniku #{$user->id} uspješno dodjeljena.", title: "Uloga", model: "success");
        return back();
    }

    public function deleteUser(User $user)
    {
        $user->delete();
        $this->constructToastMessage("Korisnik #{$user->id} uspješno izbrisan.", "Brisanje korisnika", "success");
        return to_route("admin.new_users_list");
    }
}
