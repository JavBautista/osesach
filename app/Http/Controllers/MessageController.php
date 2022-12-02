<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Message;
use App\Models\Conversation;


class MessageController extends Controller
{

	public function store(Request $request){

        $conversation_id=$request->conversation_id;
        if($request->nuevo==1){
            $conversation= new Conversation();
            $conversation->agent_id = $request->person_id_remi;
            $conversation->supervisor_id = $request->person_id_dest;
            $conversation->save();
            $conversation_id = $conversation->id;
        }


        $msg =new Message();
        $msg->conversation_id  = $conversation_id;
        $msg->author_id        = $request->person_id_remi;
        $msg->message          = $request->message;
        $msg->save();

        if($request->nuevo==1){
            $new_conversation=Conversation::with('supervisor')->with('messages')->findOrFail($conversation_id);
            return response()->json([
                'ok'=>true,
                'conversation'=>$new_conversation,
            ]);
        }
        return response()->json([
            'ok'=>true,
            'message' => $msg,
        ]);
	}


}
