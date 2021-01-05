<?php

namespace App;

use Carbon\Carbon;
use Illuminate\Support\Facades\Hash;
use App\Http\Controllers\Auth\LoginController;

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

    public static function getCreatedUsersLastMonth()
    {
        $timeNow = Carbon::now();

        $time = Carbon::now();
        $time->subtract('1 month');
        $time = $time->format('Y-m-d');

        return DB::select("
            select COUNT(id) as total, dateadd(DAY,0, datediff(day,0, created_at)) as created_at
            from users
            WHERE created_at > :time AND created_at < :timeNow
            group by dateadd(DAY,0, datediff(day,0, created_at))
            ORDER BY created_at ASC
            ",
            [
                "time" => $time,
                "timeNow" => $timeNow
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
     * Get the user's bids
     * @return mixed
     */
    public function getUserBids()
    {
        return DB::select("
            SELECT *
            FROM bids
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

    public static function handleIsBlocked($request) {
        if (!$request->session()->has('user')) {
            return;
        }

        $user = DB::selectOne("SELECT is_blocked FROM users WHERE id=:id", [
            "id" => $request->session()->get('user')->id
        ]);

        if ($user['is_blocked'] == 1) {
            return LoginController::logout($request, true);
        }
    }
}
