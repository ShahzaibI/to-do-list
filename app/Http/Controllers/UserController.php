<?php

namespace App\Http\Controllers;

use App\Http\Requests\ForgotChangeRequest;
use App\Http\Requests\ForgotPasswordRequest;
use App\Http\Requests\LoginRequest;
use App\Http\Requests\ResetPasswordRequest;
use App\Http\Requests\StoreUserRequest;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Str;
use App\Services\Config;


class UserController extends Controller
{
    public function store(StoreUserRequest $request)
    {
        $user = new User();
        $exist_email = $user->getUserByEmail($request->email);
        if(!$exist_email->isEmpty())
        {
            return back()->withInput()->withErrors(['email'=>'Email already exists']);
        }

        $userData = [];
        $userData['user_name'] = $request->user_name;
        $userData['first_name'] = $request->firstName;
        $userData['last_name'] = $request->lastName;
        $userData['gender'] = $request->gender;
        $userData['email'] = $request->email;
        $userData['password'] = Hash::make($request->password);
        $userData['phone'] = $request->phone;
        User::create($userData);
        return redirect()->route('loginUser')->with('success', 'User successfully created Please login');
    }

    public function loginPage()
    {
        return view('login');
    }

    public function register()
    {
        return view('signup');
    }

    public function login(LoginRequest $request)
    {

        $email_address = $request->email;
        $password = $request->password;
        if(Auth::attempt(['email' => $email_address, 'password' => $password]))
        {
            return redirect()->route('home')->with('success', 'Login successful');
        }
        else
        {
            return back()->withInput()->withErrors(['password'=>'Password is incorrect']);
        }
    }

    public function logout()
    {
        Auth::logout();
        return redirect()->route('loginUser')->with('success', 'Successfully logged out');

    }

    // Change Password
    public function resetPassword()
    {
        return view('reset');
    }

    public function updatePassword(ResetPasswordRequest $request)
    {
        $newPassword = Hash::make($request->newPassword);
        $user = new User();
        $user_data = $user->findUser(Auth()->user()->id);
        $result = $user_data->update([
            'password' => $newPassword,
        ]);
        Auth::logout();
        if($result)
        {
            return redirect()->route('loginUser')->with('success', 'Password successfully change');
        }
        else
        {
            return redirect()->back()->with('error', 'Password not changed');
        }
    }

    // Forgot Password
    public function forgotPassword()
    {
        return view('forgot');
    }

    public function sentForgotPasswordEmail(ForgotPasswordRequest $request)
    {
        $status = Password::sendResetLink(
            $request->only('email')
        );
        return $status === Password::RESET_LINK_SENT
                ? back()->withInput()->with(['success' => __($status)])
                : back()->withInput()->with(['error' => __($status)]);
    }

    public function resetForm($token)
    {
        return view('reset-password', ['token' => $token]);
    }

    public function changePassword(ForgotChangeRequest $request)
    {
        $status = Password::reset(
            $request->only('email', 'password', 'password_confirmation', 'token'),
            function ($user, $password) {
                $user->forceFill([
                    'password' => Hash::make($password)
                ])->setRememberToken(Str::random(60));

                $user->save();

                event(new PasswordReset($user));
            }
        );

        return $status === Password::PASSWORD_RESET
                    ? redirect()->route('loginUser')->with('success', __($status))
                    : back()->with(['error' => __($status)]);
    }
}
