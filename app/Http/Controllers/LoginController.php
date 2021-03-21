<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    /**
     * Login page
     *
     * @return \Illuminate\Contracts\Support\Responsable
     */
    public function show()
    {
        return inertia('login', [
            'title' => 'Admin Panel Login',
        ]);
    }

    /**
     * Handle an authentication attempt.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function authenticate(Request $request)
    {
        $credentials = $request->only('name', 'password');

        if (Auth::attempt($credentials, $request->input('remember') === 'on')) {
            $request->session()->regenerate();

            return redirect()->intended('admin');
        }

        return back()->withErrors([
            'login' => 'The name or password is incorrect.',
        ]);
    }

    /**
     * Logout
     *
     * @return \Illuminate\Contracts\Support\Responsable
     */
    public function logout()
    {
        Auth::logout();

        return redirect('login');
    }
}
