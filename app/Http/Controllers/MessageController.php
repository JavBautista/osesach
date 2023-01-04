<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Message;
use App\Models\Conversation;
use Illuminate\Support\Facades\DB;


class MessageController extends Controller
{

	public function store(Request $request){

        $conversation_id=$request->conversation_id;

        if($request->nuevo==1){
            $conversation= new Conversation();
            $conversation->person1_id = $request->person_id_remi;
            $conversation->person2_id = $request->person_id_dest;
            $conversation->save();
            $conversation_id = $conversation->id;
        }


        $msg =new Message();
        $msg->conversation_id  = $conversation_id;
        $msg->author_id        = $request->person_id_remi;
        $msg->message          = $request->message;
        $msg->read             = 0;
        $msg->save();

        if($request->nuevo==1){
            $new_conversation=Conversation::with('messages')
                                            ->with('person1')
                                            ->with('person2')
                                            ->findOrFail($conversation_id);
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

    public function getMessagesNotRead(Request $request){
        $person_id = $request->person_id;
        //obtenemos las conversaciones del usuario
        $conversations = Conversation::where('person1_id', $person_id)
                                    ->orWhere('person2_id', $person_id)
                                    ->get();

        $count_messages=0;
        //buscamos si en sus conversaciones existen msg sin leer
        //y que no sean de él
        foreach ($conversations as $data) {
            $conv_id = $data->id;
            $tmp = DB::table('messages')
                        ->where('conversation_id','=',$conv_id)
                        ->where('author_id','!=',$person_id)
                        ->where('read','=',0)
                        ->count();
            $count_messages= $count_messages+$tmp;
        }

        return response()->json([
            'ok'=>true,
            'count_messages' => $count_messages,
        ]);
    }


    public function updateMessagesToRead(Request $request){
        $person_id = $request->person_id;
        $conversation_id = $request->conversation_id;

        $messages = Message::where('conversation_id','=',$conversation_id)
                            ->where('author_id','!=',$person_id)
                            ->where('read','=',0)
                            ->get();
        foreach($messages as $data){
            $msg = Message::findOrFail($data->id);
            $msg->read = 1;
            $msg->save();
        }

        return response()->json([
            'ok'=>true
        ]);
    }


}
