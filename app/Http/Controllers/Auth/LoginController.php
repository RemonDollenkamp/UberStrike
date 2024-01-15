<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;


class LoginController extends Controller
{

    public function Login(request $request)
    {
        $credentials = $request->only('user-name', 'password');

        if (Auth::attempt($credentials)) {
            // Authentication passed...
            return redirect()->intended('/dashboard');
        } else {
            throw ValidationException::withMessages([
                'user-name' => [__('De combinatie van het ingevulde emailadres en wachtwoord is incorrect.')],
            ])->redirectTo('/login');
        }
    }
}
