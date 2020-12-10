<?php

namespace App\Http\Controllers;

use App\DB;
use App\Mail\SellerVerification;
use App\Mail\SendVerify;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Str;

class SellerVerificationController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('check.user.isnot.seller');
    }

    /**
     * Show the verification form
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function verificationStart()
    {
        if(Cookie::has("seller_verification"))
            return redirect()->route("verkoperworden.verifieren");
        return view("sellerverifications.create");
    }

    /**
     * Validate and handle the verification request
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function verificationPost(Request $request)
    {
        if ($request->get("creditcard_number") === null && $request->get("bank_name") === null && $request->get("bank_account_number") === null) {
            $request->session()->flash('error', 'Er zijn geen velden ingevuld!');
            return redirect()->back()->withInput($request->all());
        }
        if ($request->get("creditcard_number") !== null && ($request->get("bank_name") !== null || $request->get("bank_account_number") !== null)) {
            $request->session()->flash('error', 'U kunt niet beide een creditcardnummer en IBAN opgeven!');
            return redirect()->back()->withInput($request->all());
        }
        if (($request->get("bank_name") !== null || $request->get("bank_account_number") !== null) && ($request->get("bank_name") === null || $request->get("bank_account_number") === null)) {
            $request->session()->flash('error', 'U moet uw IBAN en de naam van uw bank opgeven!');
            return redirect()->back()->withInput($request->all());
        }
        $user = Session::get("user");
        \App\SellerVerification::deleteWhere("user_id", $user->id);
        if ($request->get("bank_account_number") !== null) {
            if (!preg_match("/^([A-Z]{2}[ '+'\\'+'-]?[0-9]{2})(?=(?:[ '+'\\'+'-]?[A-Z0-9]){9,30}$)((?:[ '+'\\'+'-]?[A-Z0-9]{3,5}){2,7})([ '+'\\'+'-]?[A-Z0-9]{1,3})?$/", $request->get("bank_account_number"))) {
                return redirect()->back()->withInput($request->all())->withErrors(["bank_account_number" => "De ingevulde IBAN code lijkt niet te kloppen"]);
            }
            $insertId = DB::selectOne("INSERT INTO seller_verifications (user_id,method,bank_name,bank_account_number) OUTPUT Inserted.user_id VALUES(:user_id,:method,:bank_name,:bank_account_number)", [
                "user_id" => $user->id,
                "method" => "Bank",
                "bank_name" => $request->get("bank_name"),
                "bank_account_number" => $request->get("bank_account_number")
            ]);
        } else {
            $ccNumber = preg_replace("/[^0-9]/", "", $request->get("creditcard_number"));
            if (!preg_match("/^(?:4[0-9]{12}(?:[0-9]{3})?|[25][1-7][0-9]{14}|6(?:011|5[0-9][0-9])[0-9]{12}|3[47][0-9]{13}|3(?:0[0-5]|[68][0-9])[0-9]{11}|(?:2131|1800|35\d{3})\d{11})$/", $ccNumber)) {
                return redirect()->back()->withInput($request->all())->withErrors(["creditcard_number" => "Het ingevulde creditcardnummer lijkt niet te kloppen"]);
            }
            $insertId = DB::selectOne("INSERT INTO seller_verifications (user_id,method,creditcard_number) OUTPUT Inserted.user_id VALUES(:user_id,:method,:creditcard_number)", [
                "user_id" => $user->id,
                "method" => "Creditcard",
                "creditcard_number" => $ccNumber
            ]);
        }

        $code = Str::random(10);
        $cookie = cookie('seller_verification', $code, 10080);

        Mail::to($user->email)->send(new SellerVerification($code));

        $request->session()->flash('success', 'Er is een e-mail gestuurd naar ' . $user->email . '!');
        return redirect()->route("verkoperworden.verifieren")->cookie($cookie);
    }

    /**
     * Show the verification
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function verificationVerify()
    {
        return view("sellerverifications.verify");
    }

    /**
     * Make the user a seller
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function verificationVerifyCheck(Request $request)
    {
        if($request->get("code") != Cookie::get("seller_verification"))
            return redirect()->back()->withInput($request->all())->withErrors(["code" => "De ingevulde code komt niet overeen"]);

        $oldUser = Session::get("user");
        DB::insertOne("UPDATE users SET is_seller=1 WHERE id=:id", ["id" => $oldUser->id]);
        $user = User::oneWhere('id', $oldUser->id);
        $request->session()->put('user', $user);

        $cookie = Cookie::forget("seller_verification");
        $request->session()->flash('success', 'U bent nu verkoper en kunt veilingen aanmaken!');
        return redirect()->route("veilingen.mijn")->withCookie($cookie);
    }
}
