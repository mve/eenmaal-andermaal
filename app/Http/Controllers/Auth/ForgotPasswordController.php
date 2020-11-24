<?php

namespace App\Http\Controllers\Auth;

use App\DB;
use App\User;
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
    public function reset_password(Request $request)
    {
        $data = $request->all();
        $user = User::oneWhere("email",$data['email']);

        if ($user && $user->security_question_id == $data['security_question_id']) {

            if ($user->security_answer == $data['security_answer'])
             {
                //send mail with succes link / password
                $msg = 'Email verstuurd als email adress en beveiligings antwoord klopt 1';

            } else if ($user->security_answer != $data['security_answer']) {
                //send mail with warnings
                $msg = 'Email verstuurd als email adress en beveiligings antwoord klopt 2';

            }

        }else if(!$user){
            //return msg success en send no mail
            $msg = 'Email verstuurd als email adress en beveiligings antwoord klopt 3';

        }

        session()->flash('msg', $msg);
        return redirect('/wachtwoordvergeten');

    }
}
