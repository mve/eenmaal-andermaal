<?php

namespace App\Http\Controllers\Auth;

use App\DB;
use Illuminate\Support\Facades\Mail;
use App\Mail\ResetPassword;
use App\User;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Foundation\Auth\SendsPasswordResetEmails;

class ForgotPasswordController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Password Reset Controller
    |--------------------------------------------------------------------------
    |
    | This controller is responsible for handling password reset emails and
    | includes a trait which assists in sending these notifications from
    | your application to your users. Feel free to explore this trait.
    |
    */

    use SendsPasswordResetEmails;

    public function index()
    {
        $data = [
            'securityQuestions' => DB::select("SELECT * FROM security_questions")
        ];

        return view('auth.passwords.email')->with($data);
    }

     /**
     * send password reset email.
     *
     * @param Request $request
     * @return void
     */
    public function reset_mail(Request $request)
    {
        $data = $request->all();
        $user = User::oneWhere("email",$data['email']);



        if ($user && $user->security_question_id == $data['security_question_id']) {



            if ($user->security_answer == $data['security_answer']) {

                $request->type = '1';
                $request->token = Str::random(64);

                DB::insertOne("UPDATE users SET reset_token=:reset_token WHERE id=:id",[
                    "id" => $user->id,
                    "reset_token" => $request->token
                ]);

            } else if ($user->security_answer != $data['security_answer']) {
                //send mail with warnings

                $request->type = '2';


            }

            Mail::to($user->email)->send(new ResetPassword($request));

        }

        session()->flash('msg', 'E-mail verstuurd als e-mailadres en beveiligingsantwoord juist zijn');
        return redirect('/wachtwoordvergeten');

    }

    public function reset_password(Request $request, $token)
    {
        $user = User::oneWhere("reset_token",$token);

        if($user) {
            $data = [
                'securityQuestions' => DB::select("SELECT * FROM security_questions")
            ];

            return view('auth.passwords.reset', ['token' => $token])->with($data);
        } else if (!$user) {

            return abort(404);
        }

    }

    public function update_password(Request $request)
    {
        $data = $request->all();
        $user = User::oneWhere("reset_token",$data['token']);

        if ($user->email == $data['email']) {

            $this->validate($request, array(
                'password' => ['required', 'string', 'min:7', 'confirmed', 'regex:/^.*(?=.{3,})(?=.*[A-Z])(?=.*[a-z])(?=.*[0-9])(?=.*[\d\x]).*$/'],
            ));

            DB::insertOne("UPDATE users SET password=:password, reset_token=:reset_token WHERE id=:id",[
                "id" => $user->id,
                "password" => Hash::make($request->password),
                "reset_token" => null
            ]);

            $request->type = '3';
            Mail::to($user->email)->send(new ResetPassword($request));

            session()->flash('msg', 'Wachtwoord succesvol gewijzigd');
            return redirect('/wachtwoordvergeten');

        }else if ($user->email != $data['email']) {

            session()->flash('msg', 'Verkeerd e-mailadres opgegeven');
            return redirect(url()->previous());

        }



    }
}
