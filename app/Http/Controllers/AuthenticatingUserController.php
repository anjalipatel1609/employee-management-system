<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Hash;

use App\Models\SystemUser;

class AuthenticatingUserController extends Controller
{
    public function authenticating_user(Request $request)
    {
        $email = $request->input('email');
        $password = $request->input('password');

        $user = SystemUser::where('email', $email)->first();
        if ($user) {
            if (Hash::check($password, $user->password)){
                // echo "<br>Password match...";

                if($user->user_type == "Employee")
                {
                    Session::put('employee_session', $user);
                }

                if($user->user_type == "HR" || $user->user_type == "ADMIN")
                {
                    Session::put('HR__ADMIN__session', $user);
                }

                return redirect()->route('home');

            } else {
                return redirect()->route('login')->with('error', 'Incorrect Password !');
            }
        } else {
            return redirect()->route('login')->with('error', 'Invalid User !');
        }
    }
}
