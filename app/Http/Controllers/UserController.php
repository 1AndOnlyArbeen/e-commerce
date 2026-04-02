<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function showregisterUser()
    {
        return view('register');
    }

    public function login()
    {
        return view('login');
    }

    public function registerUser(Request $req)
    {
        $validation = $req->validate([
            'name' => 'required',
            'email' => 'required|email|unique:users,email|lowercase',
            'password' => 'required|min:8',
            'confirm_password' => 'required|same:password',
            'phone' => 'required|numeric|digits:10',
            'address' => 'required',
            'gender' => 'required|in:male,female',
            'date_of_birth' => 'required|date',
        ]);

        $user = User::create([
            'name' => $validation['name'],
            'email' => $validation['email'],
            'password' => Hash::make($validation['password']),
            'phone' => $validation['phone'],
            'address' => $validation['address'],
            'gender' => $validation['gender'],
            'date_of_birth' => $validation['date_of_birth'],
        ]);

        return redirect('login')->with('success', 'Registration successful! Welcome '.$user->name);
    }

    public function loginUser(Request $req)
    {
        $validation = $req->validate([
            'email' => 'required|email|lowercase',
            'password' => 'required|min:8',
        ]);

        $user = User::where('email', $validation['email'])->first();

        if (! $user) {
            return back()->withErrors(['email' => 'email not found']);
        }

        if (! Hash::check($validation['password'], $user->password)) {
            return back()->withErrors(['password' => 'Incorrect password'])->withInput();
        }

        Auth::login($user);
        $req->session()->regenerate();
        
        //for flash 
        session()->flash('just_logged_in', true); 

        return redirect('/')->with('success', 'login successfully welcome');
    }

    public function logout(Request $req)
    {
        Auth::logout();
        $req->session()->regenerate();

        return redirect('/')->with('success', 'logout successfully');
    }
}
