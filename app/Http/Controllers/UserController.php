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
    // publci function logout(){

    // }

    // registering the user by taking the incoming post request and validating it and then inserting it into the database

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

        // inserting the incoming post into the db by creating : creat method ,

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

    // login user by taking the incoming post request and validating it and then checking if the email exists in the database and then checking if the password is correct and then redirecting to the home page

    public function loginUser(Request $req)
    {

        // first get the email and pasword form the user and validate it
        // then check if the email exists in the database
        // then has the password given by the user and compared tht hased pssord save in the db
        // if the user passowrd match the redirect him to the welocme page otherwise redirect back to the login page with error message;
        $validation = $req->validate([
            'email' => 'required |email|lowercase',
            'password' => 'required|min:8',
        ]);

        // find the user by email
        $user = User::where('email', $validation['email'])->first();

        // check if the user exist
        if (! $user) {
            return back()->withErrors(['email' => 'email not found']);
        }

        // check the password and comapre
        if (! Hash::check($validation['password'], $user->password)) {
            return back()->withErrors(['password' => 'Incorrect password'])->withInput();
        }

        Auth::login($user);
        $req->session()->regenerate();

        return redirect('/')->with('success', 'login successfully welcome ');
    }

    // creating the logout function to lo it the user :
    // setp 1: i will check the auth user and just delete the session and redirect him to the login

    public function logout(Request $req)
    {
        Auth::logout();
        $req->session()->regenerate();

        return redirect('/login')->with('success', 'logout successfully');

    }
}
