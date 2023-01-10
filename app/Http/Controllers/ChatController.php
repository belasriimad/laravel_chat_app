<?php

namespace App\Http\Controllers;

use App\Models\Message;
use Illuminate\Http\Request;
use App\Events\StoreMessageEvent;

class ChatController extends Controller
{
    //
    public function storeMessage(Request $request){
        $message = Message::create([
            'user_id' => $request->user_id,
            'text' => $request->text
        ]);
        broadcast(new StoreMessageEvent($message->load('user')));
        return $message;
    }

    public function getMessages(){
        $messages = Message::with('user')->get();
        return $messages;
    }
}
