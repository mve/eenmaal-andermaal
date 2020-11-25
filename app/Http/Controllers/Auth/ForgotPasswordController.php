<?php

namespace App\Http\Controllers\Auth;

use App\DB;
use Illuminate\Support\Facades\Mail;
use App\Mail\ResetPassword;
use App\User;
use Illuminate\Support\Str;
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
                $request->token = Str::random(64);;

                DB::selectOne("UPDATE users SET reset_token=:reset_token WHERE id=:id",[
                    "id" => $user->id,
                    "reset_token" => $request->token
                ]);

            } else if ($user->security_answer != $data['security_answer']) {
                //send mail with warnings

                $request->type = '2';


            }

            Mail::to($user->email)->send(new ResetPassword($request));

        }

        session()->flash('msg', 'Email verstuurd als email adress en beveiligings antwoord klopt');
        return redirect('/wachtwoordvergeten');

    }

    public function reset_password(Request $request, $token)
    {
        dd($token);

    }
}
