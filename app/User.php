<?php

namespace App;

use Illuminate\Support\Facades\Hash;

class User extends SuperModel
{
    protected $attributes = [
        'id',
        'username',
        'email',
        'password'
    ];

    //moet naar de controllers
    public static function login($email_address, $password){
        $user = User::oneWhere("email",$email_address);
        if($user == null){
            return "Geen account gevonden met het ingevoerde e-mailadres";
        }
        if(!Hash::check($password, $user->password)){
            return "Wachtwoorden komen niet overeen";
        }
        return "Inloggen gelukt";
    }

    //moet naar de controllers
    public static function register($last_name, $email_address, $password){
        $user = User::oneWhere("email",$email_address);
        if($user){
            return "Er bestaat al een account met het ingevulde e-mailadres";
        }
        \App\User::insert([
            "name" => $last_name,
            "email" => $email_address,
            "password" => Hash::make($password)
        ]);
        return "Registreren gelukt";
    }
}
