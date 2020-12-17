<?php

namespace App;

use Illuminate\Support\Facades\Hash;

class User extends SuperModel
{
    /**
     * Get the user's phone numbers
     * @return array
     */
    public function getPhoneNumbers()
    {
        return DB::select("
            SELECT phone_number
            FROM phone_numbers
            WHERE user_id=:id
            ",
            [
                "id" => $this->id
            ]);
    }

    /**
     * Get the user's seller verification details
     * @return mixed
     */
    public function getSellerVerification()
    {
        return DB::selectOne("
            SELECT *
            FROM seller_verifications
            WHERE user_id=:id
            ",
            [
                "id" => $this->id
            ]);
    }

    /**
     * Get the user's contry
     * @return mixed
     */
    public function getCountry()
    {
        return DB::selectOne("
            SELECT *
            FROM countries
            WHERE country_code=:cc
            ",
            [
                "cc" => $this->country_code
            ])["country"];
    }

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

    public static function getAuctionsByUser(){
        $auctions = DB::select("
        WITH acactive AS(
        SELECT users.id, COUNT(ac1.id) as Active
        FROM users
        LEFT JOIN auctions ac1
        ON ac1.user_id = users.id
        WHERE ac1.end_datetime >= GETDATE()
        GROUP BY users.id
        )
        , acall AS(
        SELECT users.id, COUNT(ac2.id) as AllCnt
        FROM users
        LEFT JOIN auctions ac2
        ON ac2.user_id = users.id
        GROUP BY users.id
        )

        SELECT users.*, acactive.Active, acall.AllCnt
        FROM users
        LEFT JOIN acactive
        ON acactive.id=users.id
        LEFT JOIN acall
        ON acall.id=users.id
        ");

        return $auctions;
    }

}
