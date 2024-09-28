<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use App\Mail\PasswordRecoveryMail;

use App\Models\SystemUser;
use App\Models\Employee;

class PasswordRecoveryController extends Controller
{
    public function sending_mail_to_reset_password(Request $request)
    {
        $email = $request->input('email_id_of_valid_user');

        $user = SystemUser::where('email', $email)->first();
        if ($user) {
            Mail::to($email)->send(new PasswordRecoveryMail($email));
            return redirect()->route('login')->with('error', 'Email has been sent, please reset your password by that email and try to login again !');
        } else {
            return redirect()->route('forget_password')->with('error', 'Invalid User [Email address is not registered] !');
        }
    }

    public function updating_user_password(Request $request, $id)
    {

        try{
            $validatedData = $request->validate([
                'new_password' => 'required|string|min:8|max:15',
            ], 
            [
                'new_password.required' => 'Please enter password',

            ]);
        }catch (\Illuminate\Validation\ValidationException $e) {
            $errorMessages = $e->validator->getMessageBag()->all();

            return redirect()->back()->withErrors($errorMessages)->withInput();
        }

        $userToResetPassword = Employee::with('systemUser')->find($id); 
        $userToResetPassword->employee_password = bcrypt($request->input('new_password'));
        $userToResetPassword->employee_confirm_password = $request->input('new_password');
        $userToResetPassword->save();

        $userToResetPassword->systemUser->password = $userToResetPassword->employee_password;
        $userToResetPassword->systemUser->save();
        
        return redirect()->route('password_updated')->with('msg', 'Your password has been updated successfully !');
    }
}
