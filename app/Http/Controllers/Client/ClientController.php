<?php

namespace App\Http\Controllers\Client;

use App\Models\Client;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

class ClientController extends Controller
{
    public function dashboard()
    {
        return view('client.index');
    }
    public function clientLogin()
    {
        return view('client.client_login');
    }

    public function clientLoginSubmit(Request $request)
    {
        // Validate input
        $request->validate([
            'email' => 'required|email|exists:clients,email',
            'password' => 'required|string|min:8',
        ]);

        // Attempt to log the client in
        $credentials = $request->only('email', 'password');

        $notification = [
            'alert-type' => 'success',
            'message' => 'Login successful.'
        ];
        if (Auth::guard('client')->attempt($credentials)) {
            // Authentication passed
            return redirect()->route('client.dashboard')->with($notification);
        }

        // Authentication failed
        throw ValidationException::withMessages([
            'email' => 'The provided credentials do not match our records.',
        ]);

    }

    public function clientRegister()
    {
        return view('client.client_register');
    }


    public function clientRegisterSubmit(Request $request)
    {
        // Validate the input
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:clients',
            'password' => 'required|string|min:8|confirmed', // Automatically checks password_confirmation
            'phone' => 'nullable|string|max:20',
            'address' => 'nullable|string|max:255',
        ]);

        // Save the client to the database
        $client = new Client();
        $client->name = $request->name;
        $client->email = $request->email;
        $client->password = Hash::make($request->password);
        $client->phone = $request->phone;
        $client->address = $request->address;
        $client->status = '0';
        $client->save();

        $notification = [
            'alert-type' => 'success',
            'message' => 'Registration successful.',
        ];

        // Redirect to login page or dashboard
        return redirect()->route('client.login_page')->with($notification);
    }

    public function logout(Request $request)
    {
        // Log out the admin
        Auth::guard('client')->logout();

        // Invalidate the session
        $request->session()->invalidate();

        // Regenerate the CSRF token to prevent CSRF attacks
        $request->session()->regenerateToken();

        $notification = [
            'alert-type' => 'success',
            'message' => 'Logout successful.',
        ];
        // Redirect to the admin login page or any other route
        return redirect()->route('client.login_page')->with($notification);
    }
}
