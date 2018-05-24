<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\User;

class LoginController extends Controller
{
    function index() {
        return view('login');
    }

    function login(Request $request) {
        if (Auth::attempt(['username' => $request->username, 'password' => $request->password])) {
            $user = User::where('username', $request->username)->first();
            $request->session()->put('fakultas_id', $user->id);
            $request->session()->put('fakultas', $user->fakultas);
            $request->session()->put('username', $user->username);

            return redirect()->to('assessment');
        } else {
            return redirect()->back();
        }
    }

    function logout() {
        Auth::logout();

        return redirect()->to('login');
    }
}
