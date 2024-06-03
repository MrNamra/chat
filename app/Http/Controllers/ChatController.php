<?php

namespace App\Http\Controllers;

use App\Models\channel;
use App\Models\chats;
use App\Models\rooms;
use App\Models\User;
use Illuminate\Http\Request;

class ChatController extends Controller
{
    public function login(Request $request)
    {
        $request->validate([
            'name' => 'required|alpha',
            'room' => 'required|alpha_num',
        ]);
        $mess = null;
        $room = rooms::where('code', $request->input('room'))->first();
        if ($room) {
            $mess = 'room Join Successfully!';
        } else {
            $crea = new rooms();
            $crea->code = $request->input('room');
            $crea->save();
            $mess = 'room create Successfully!';
        }
        session(['name' => $request->input('name'), 'room' => $request->input('room')]);
        return redirect('/' . $request->input('room'))->with(['message' => $mess]);
    }

    public function index(Request $request)
    {
        $user = User::get();
        return view('chat', ['users' => $user, 'page' => '']);
        // echo ('404! Page Not Found!');
    }
    public function ajax(Request $request)
    {
        $request->validate([
            'message' => 'required|string',
            'sender' => 'required|numeric',
            // 'channel' => 'required|alpha_dash',
        ]);
        // $room = chats::select('id')->where('code', session('room'))->first();
        // if ($room) {
            $userId = auth()->user()->id;
            $otherUserId = $request->sender;
            
            $chat = new chats();
            $chat->m_from = auth()->user()->id;
            $chat->m_to = $request->sender;
            $chat->message = $request->input('message');
            $chat->status = '0';

            $chat->save();

            $user = User::select('id','name')->find($request->sender);
            event(new \App\Events\WebappfixTest($request->message, $request->channel, auth()->user()->id, $user->name, $user->id));
        // }
        return false;
    }
    public function getChat(Request $request)
    {
        $request->validate([
            'u_id' => 'required|alpha_dash',
        ]);
        $u_id = '2';
        $other_user_id = auth()->user()->id;  // assuming you get the other user's ID from the request as well

        $chats = chats::where(function ($query) use ($u_id, $other_user_id) {
                    $query->where('m_from', $u_id)
                    ->where('m_to', $other_user_id);
                })
                ->orWhere(function ($query) use ($u_id, $other_user_id) {
                    $query->where('m_from', $other_user_id)
                        ->where('m_to', $u_id);
                })->with(['sender', 'receiver'])
                ->get();
                // dd($chats);
                return response(json_encode($chats));
    }
    public function oneToOne($id){
        $resiver = User::find($id);
        $u_id = auth()->user()->id;

        $find_chnl = channel::where(function ($query) use ($u_id, $resiver) {
            $query->where('user_1', $u_id)
            ->where('user_2.', $resiver);
            })
            ->orWhere(function ($query) use ($u_id, $resiver) {
                $query->where('user_1', $resiver)
                    ->where('user_2.', $u_id);
            })->with(['sender', 'receiver'])
            ->first();

        $findchat = chats::where(function ($query) use ($u_id, $resiver) {
            $query->where('m_from', $u_id)
            ->where('m_to', $resiver);
            })
            ->orWhere(function ($query) use ($u_id, $resiver) {
                $query->where('m_from', $resiver)
                    ->where('m_to', $u_id);
            })->with(['sender', 'receiver'])
            ->get();
        $user = User::get();
        return view('chat', ['users'=>$user, 'page'=>'onetoone']);
    }
}
