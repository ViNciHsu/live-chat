<?php

namespace App\Http\Controllers;

use App\Models\Communicationmessage;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Pusher\Pusher;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
//        $users = User::where('id', '!=', Auth::id())->get();
        $users = DB::select("select users.id, users.name, users.image, users.email, count(is_viewed) as unread
        from users LEFT JOIN communicationmessages ON users.id = communicationmessages.sender and is_viewed = 0 and communicationmessages.receiver = " . Auth::id() . "
        where users.id != " . Auth::id() . "
        group by users.id, users.name, users.image, users.email");
//        dd($users);
        return view('home',[
            'users' => $users
        ]);
    }

    public function receivemessage($user_id)
    {
//        return $user_id;
        $authuser_id = Auth::id();

        // make read all unread message
        Communicationmessage::where([
            'sender' => $user_id,
            'receiver' => $authuser_id])->update(['is_viewed' => 1]);

            //get all message from selected user
            $communicationmessages = Communicationmessage::where(function ($query)
                use ($user_id, $authuser_id){
                $query->where('sender', $user_id)->where('receiver', $authuser_id);
            })->oRwhere(function ($query) use ($user_id, $authuser_id){
                $query->where('sender', $authuser_id)->where('receiver', $user_id);
            })->get();

        return view('communicationmessages.index',[
            'communicationmessages' => $communicationmessages
        ]);

    }

    public function sendmessage(Request $request)
    {
        $sender = Auth::id();
        $receiver = $request->rec_id;

        $communicationmessage = $request->communicationmessage;

        $data = new Communicationmessage();
        $data->sender = $sender;
        $data->receiver = $receiver;
        $data->communicationmessage = $communicationmessage;
        $data->is_viewed = 0;
        $data->save();

        $options = array(
            'cluster' => 'mt1',
            'useTLS' => true
        );

        $pusher = new Pusher(
            env('PUSHER_APP_KEY'),
            env('PUSHER_APP_SECRET'),
            env('PUSHER_APP_ID'),
            $options
        );

        // sending from and to user id when pressed enter
        $data = [
            'sender' => $sender,
            'receiver' => $receiver
        ];

        $pusher->trigger('my-channel', 'my-event', $data);
    }

}
