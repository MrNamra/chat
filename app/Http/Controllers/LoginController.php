<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class LoginController extends Controller
{
    public function login(Request $request) {
        $request->validate([
            'email'=>'required|email',
            'password'=>'required|string',
        ]);
        $user = User::where('email', $request->input('email'))->where('password',Hash::make($request->input('password')))
            ->first();
        if($user){
        }
        return redirect('/')->with('err', 'Email OR Password is Wrong!');
    }
}
