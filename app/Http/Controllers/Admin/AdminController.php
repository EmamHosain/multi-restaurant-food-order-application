<?php

namespace App\Http\Controllers\Admin;

use App\Models\Admin;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Mail\AdminResetPasswordMail;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Validation\ValidationException;

class AdminController extends Controller
{
    public function login()
    {
        return view('admin.login');
    }
    public function dashboard()
    {
        return view('admin.index');
    }

    public function loginSubmit(Request $request)
    {
        // Validate the request data
        $validatedData = $request->validate([
            'email' => 'required|email',
            'password' => 'required|min:6',
        ]);

        if (Auth::guard('admin')->attempt($validatedData)) {
            // Authentication passed...
            return redirect()->route('admin.dashboard_index')->with('success', 'Login successful');
        }

        // Authentication failed...
        throw ValidationException::withMessages([
            'email' => ['The provided credentials do not match our records.'],
        ]);
    }


    public function logout(Request $request)
    {
        // Log out the admin
        Auth::guard('admin')->logout();

        // Invalidate the session
        $request->session()->invalidate();

        // Regenerate the CSRF token to prevent CSRF attacks
        $request->session()->regenerateToken();

        // Redirect to the admin login page or any other route
        return redirect()->route('admin.login_create');
    }


    public function forgotPassword()
    {
        return view('admin.forget_password');
    }


    public function sendEmailForgotPassword(Request $request)
    {
        $request->validate([
            'email' => 'required|email|exists:admins,email'
        ]);

        $admin = Admin::where('email', $request->email)->first();
        if ($admin) {
            $token = hash('sha256', time());
            $admin->update(['token' => $token]);

            $reset_link = url(route('admin.reset_password', $token) . '?email=' . $admin->email);
            Mail::to($admin->email)->send(new AdminResetPasswordMail($admin->name, $reset_link));
            return redirect()->back()->with('success', 'Reset password link sent to your email.');
        }

        throw ValidationException::withMessages([
            'email' => 'Invalid email',
        ]);
    }



    public function resetPassword(Request $request, $token)
    {
        $email = $request->query('email');
        $is_admin = Admin::where('email', $email)->where('token', $token)->first();
        if ($is_admin) {
            return view('admin.reset_password', compact('token', 'email'));
        } else {
            return redirect()->route('admin.login_create')->with('error', 'Invalid token and email');
        }
    }

    public function resetPasswordSubmit(Request $request)
    {
        // Validate the incoming request
        $request->validate([
            'email' => 'required|email|exists:admins,email',
            'token' => 'required|exists:admins,token',
            'password' => 'required|min:8',
            'password_confirmation' => 'required|same:password'
        ]);


        // Find the admin using the provided email and token
        $admin = Admin::where('email', $request->email)
            ->where('token', $request->token)
            ->first();

        if (!$admin) {
            return redirect()->back()->withErrors(['token' => 'Invalid token or email.']);
        }

        // Update the password and invalidate the token
        $admin->update([
            'password' => Hash::make($request->password),
            'token' => null, // Invalidate the token after the password is reset
        ]);

        // Redirect with a success message
        return redirect()->route('admin.login_create')->with('success', 'Your password has been successfully reset. You can now log in with your new password.');
    }


}
