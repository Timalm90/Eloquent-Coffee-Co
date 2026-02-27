<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(Request $request)
    {
        $credentials = $request->validate([
            'username' => 'required|string',
            'password' => 'required|string',
        ]);


        // map posted username to the actual DB column 'name'
        $authCredentials = [
            'name' => $credentials['username'],
            'password' => $credentials['password'],
        ];


        if (Auth::attempt($authCredentials)) {
            $request->session()->regenerate();
            return redirect()->intended('/dashboard');
        }


        return back()->withErrors(['error' => "Whoops! Please try to login again..."])->withInput();
    }
}
