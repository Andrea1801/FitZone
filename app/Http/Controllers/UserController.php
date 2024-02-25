<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;


class UserController extends Controller
{
    public function registerUser(Request $request){

        $data = $request -> validate([
            'firstName' => 'required',
            'lastName' => 'required',
            'email' => 'required|email',
            'password' => 'required'
        ],
        [
            'firstName.required' => 'Ime je obavezno',
            'lastName.required' => 'Prezime je obavezno',
            'email.required' => 'Email je obavezan',
            'email.email' => 'Email nije validan',
            'password.required' => 'Lozinka je obavezna'
        ]
        );

        $data['password'] = Hash::make($data['password']);
        $data['role'] = 'korisnik'; //default role
        $user = new User();
        $user->create($data);
        return response()->json(['message' => 'Uspjesna registracija'], 201);
    }

    public function loginUser(Request $request)
    {
        $data = $request->validate(
            [
                'email' => 'required',
                'password' => 'required',

            ],
            [

                'email.required' => 'Niste unijeli vas email',
                'password.required' => 'Niste unijeli vasu lozinku'
            ]
        );


        if (Auth::attempt($data)) {
            $user = Auth::user();
            return response()->json(['message' => 'Uspjesna prijava', 'user' => $user]);
        } else {
            return response()->json(['message' => 'Neuspjesna prijava']);
        }
    }

    public function isLogged()
    {

        $user = Auth::user();
        if ($user) {
            return response()->json($user);
        } else {
            return response()->json(null);
        }
    }

    public function logout(){
        Auth::logout();
        return response()->json(['redirect' => '/login']);
    }

    public function getUserData(){
        $user = Auth::user();
        return response()->json($user);
    }

    public function getUsers(){
        $users = User::get();
        return response()->json(['users' => $users]);
    }

    public function deleteUser($id){
        $user = User::findorFail($id);
        $user->delete();
        return response()->json(['message' => 'Korisnik izbrisan']);
    }

    public function adminUser($id){
        $user = User::findorFail($id);
        $user->role = 'administrator';
        $user->save();
        return response()->json(['message' => 'Korisnik postavljen za admina']);
    }
}
