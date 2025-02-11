<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Redirector;
use Illuminate\Support\Facades\Auth;

class CustomAuthController extends Controller
{
    public function showLoginForm(): Factory|View|Application
    {
        return view('auth.login');
    }

    public function login(Request $request): Redirector|RedirectResponse|Application
    {
        // Validate the request
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        // Attempt to log the user in
        if (!Auth::attempt(['email' => $request->email, 'password' => $request->password], $request->remember)) {
            return back()->withErrors([
                'email' => __('The provided credentials do not match our records.'),
            ])->onlyInput('email');
        }

        // Check if the logged-in user is an admin
        if (!Auth::user()->role || Auth::user()->role->name != 'admin') {
            Auth::logout();

            return redirect('/admin/login')->withErrors([
                'email' => __('Only admin users can log in.'),
            ])->onlyInput('email');
        }

        // Redirect to the intended route or the named route for the dashboard
        return redirect()->intended(route('admin.dashboard'));

    }

    public function logout(Request $request): Redirector|Application|RedirectResponse
    {
        Auth::logout(); // Log the user out

        $request->session()->invalidate(); // Invalidate the session

        $request->session()->regenerateToken(); // Regenerate CSRF token

        return redirect(route('admin.login'));
        //->with('status', 'Successfully logged out.'); // Redirect to login with a message
    }
}
