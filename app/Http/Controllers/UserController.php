<?php

namespace App\Http\Controllers;

use App\Http\Requests\updateUserProfileRequest;
use App\Models\User;
use App\Traits\ToastInterface;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class UserController extends Controller
{

    use ToastInterface;
    public function getMyProfile()
    {
        $user = User::find(Auth::id());
        return view("users.profile", compact("user"));
    }

    public function editProfile(UpdateUserProfileRequest $updateUserProfileRequest)
    {
        $validated = $updateUserProfileRequest->validated();
        $user = User::find(Auth::id());

        if ($updateUserProfileRequest->hasFile('profile_picture')) {
            $file = $updateUserProfileRequest->file('profile_picture');

            if ($user['profile_picture'] && Storage::disk('public')->exists($user['profile_picture'])) {
                Storage::disk('public')->delete($user['profile_picture']);
            }

            $path = $file->store('profile_pictures', 'public');
            $validated['profile_picture'] = $path;
        }

        $user->update($validated);

        $this->constructToastMessage(message: "Profil uspješno ažuriran!", title: "Uspješno", model: "success");
        return back();
    }

    public function updatePassword()
    {
        //
    }
}
