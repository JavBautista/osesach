<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Conversation;


class ConversationController extends Controller
{
    public function getApiConversationsSupervisor(Request $request){
        $supervisor_id = $request->supervisor_id;
        $conversations = Conversation::with('agent')->with('messages')->where('supervisor_id',$supervisor_id)->paginate(20);
        return $conversations;
    }//.getApiConversationsSupervisor()

    public function getApiConversationsAgent(Request $request){
        $agent_id = $request->agent_id;
        $conversations = Conversation::with('supervisor')->with('messages')->where('agent_id',$agent_id)->paginate(20);
        return $conversations;
    }//.getApiConversationsAgent()

    public function getApiConversations(Request $request){
        $person_id = $request->person_id;
        $conversations = Conversation::with('messages')
                                    ->with('person1')
                                    ->with('person2')
                                    ->where('person1_id', $person_id)
                                    ->orWhere('person2_id', $person_id)
                                    ->paginate(20);
        return $conversations;
    }//.getApiConversationsAgent()
}
