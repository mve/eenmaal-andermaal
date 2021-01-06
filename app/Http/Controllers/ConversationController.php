<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Conversation;
use App\Message;
use App\DB;

class ConversationController extends Controller
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

    public function list(Request $request) {
        return view('messages');
    }

    public function send(Request $request) {
        $this->validate($request, array(
            'message' => ['required', 'string', 'max:250'],
        ));

        $auctionId = $request->auctionId;
        $userId = $request->session()->get('user')->id;

        $conv = Conversation::getOrCreate($auctionId, $userId);

        $message = DB::insertOne(
            "INSERT INTO auction_messages (auction_conversation_id, user_id, message)
            VALUES (".$conv->id.", ".$userId.", '".$request->message."')");

        if (!$message) {
            return redirect()->back()->withInput($request->all())->withErrors(["message" => "Bericht is niet verzonden!"]);
        }
        return redirect()->route("messages")->with('message', 'Uw bericht is verzonden!');
    }
}