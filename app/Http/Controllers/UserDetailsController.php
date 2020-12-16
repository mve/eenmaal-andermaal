<?php

namespace App\Http\Controllers;

use App\Country;
use App\DB;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Session;

class UserDetailsController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('check.user');
    }

    /**
     * Show the user's information.
     *
     * @param Request $request
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index(Request $request)
    {
        $user = Session::get('user');
        $data = [
            'user' => $user
        ];
        return view("auth.details")->with($data);
    }

    /**
     * Show the edit form
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function edit()
    {
        $user = Session::get('user');
        $data = [
            'user' => $user,
            'countries' => Country::allOrderBy('country')
        ];
        return view("auth.detailsedit")->with($data);
    }

    /**
     * Update the user's details
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse|string
     * @throws \Illuminate\Validation\ValidationException
     */
    public function update(Request $request)
    {
        $currentUser = Session::get('user');
        $this->validate($request, array(
            'username' => ['required', 'string', 'max:100', 'regex:/^[\pL\s\-]+$/u'],
            'first_name' => ['required', 'string', 'max:100'],
            'last_name' => ['required', 'string', 'max:100'],
            'address' => ['required', 'string', 'max:100'],
            'postal_code' => ['required', 'string','max:10'],
            'city' => ['required', 'string', 'max:100'],
            'country_code' => ['required', 'string'],
            'phone_number.*' => ['required', 'string','max:15'],
        ));

        $checkUser = User::oneWhere("username", $request->username);
        if ($checkUser !== false && $checkUser->id !== $currentUser->id) {
            return redirect()->back()->withInput($request->all())->withErrors(["username" => "De ingevulde gebruikersnaam is al in gebruik"]);
        }

        if (
            DB::selectOne("SELECT * FROM countries WHERE country_code=:country_code", [
                "country_code" => $request->country_code
            ]) === false
        ) {
            return redirect()->back()->withInput($request->all())->withErrors(["country_code" => "Er bestaat geen land in onze database met de ingevulde landcode"]);
        }

        $oldPhoneNumbers = DB::select("SELECT * FROM phone_numbers WHERE user_id=:user_id",[
            "user_id" => $currentUser->id
        ]);

        if($request->has("phone_number")){
            $notExists = [];
            for($i = 0; $i < count($request->phone_number);$i++){
                $boolExists = false;
                for($x = 0; $x < count($oldPhoneNumbers); $x++){
                    if($oldPhoneNumbers[$x]["phone_number"] == $request->phone_number[$i]){
                        $boolExists = true;
                        array_splice($oldPhoneNumbers,$x,1);
                        break;
                    }
                }
                if(!$boolExists)
                    array_push($notExists, $request->phone_number[$i]);
            }
            for($i = 0; $i < count($oldPhoneNumbers); $i++){
                DB::delete("DELETE FROM phone_numbers WHERE id=:id", [
                    'id' => $oldPhoneNumbers[$i]["id"]
                ]);
            }
            for($i = 0; $i < count($notExists); $i++){
                DB::insertOne("INSERT INTO phone_numbers (phone_number,user_id) VALUES (:phone_number,:user_id)", [
                    'phone_number' => $notExists[$i],
                    'user_id' => $currentUser->id
                ]);
            }
        }else{
            DB::delete("DELETE FROM phone_numbers WHERE user_id=:user_id", [
                'user_id' => $currentUser->id
            ]);
        }

        $latAndLon = $this->getLatAndLon($request->postal_code, $request->country_code);
        if (array_key_exists('error', $latAndLon))
        {
            return redirect()->back()->withInput($request->all())->withErrors(["postal_code" => $latAndLon['error']]);
        }

        $currentUser->username = $request->username;
        $currentUser->first_name = $request->first_name;
        $currentUser->last_name = $request->last_name;
        $currentUser->postal_code = $request->postal_code;
        $currentUser->address = $request->address;
        $currentUser->city = $request->city;
        $currentUser->country_code = $request->country_code;
        $currentUser->latitude = $latAndLon['lat'];
        $currentUser->longitude = $latAndLon['lon'];

        $currentUser->update();

        $request->session()->flash("success","Uw gegevens zijn opgeslagen!");
        return redirect()->back();
    }

    /**
     * Request new phone field HTML
     * @param $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function phoneField($id)
    {
        $data = [
            "i" => $id,
            "phoneNumber" => ""
        ];
        return view("includes.phonefield")->with($data);
    }

    function getLatAndLon($postalCode, $countryCode)
    {
        $postalCode = str_replace(' ', '', $postalCode);

        // If postal code is from CA or GB, add space 3 characters before end of postal code.
        if ($countryCode === "CA" || $countryCode === "GB") {
            $postalCode = str_replace(' ', '', $postalCode);
            $postalCode = strrev($postalCode);
            $postalCode = substr($postalCode, 0, 3) . ' ' . substr($postalCode, 3);
            $postalCode = strrev($postalCode);
        }

        $url = 'http://nominatim.openstreetmap.org/search?country=' . $countryCode . '&postalcode=' . $postalCode . '&format=json&limit=1';

        ini_set('user_agent','Mozilla/4.0 (compatible; MSIE 6.0)');

        $response = json_decode(file_get_contents($url));

        if (!count($response))
            return ['error' => 'Geen plaats gevonden met deze postcode en landcode combinatie.'];

        $lat = $response[0]->lat;
        $lon = $response[0]->lon;

        return ['lat' => $lat, 'lon' => $lon];
    }

}
