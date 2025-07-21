<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;


class AdminController extends Controller
{
    public function getNewlyRegisteredUsers()
    {
        $unconfirmedUsers =
        User::where("is_in_pending_status", "=", 1)
        ->where("is_allowed", "=", 0)
        ->paginate(5);

        return view("admin.requests", compact("unconfirmedUsers"));

    }

    public function approveRegistration()
    {
        //
    }

    public function rejectRegistration()
    {
        //
    }
}
