<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Conversation;


class ConversationController extends Controller
{
    public function getApiConversationsSupervisor(Request $request){
        $supervisor_id = $request->supervisor_id;
        $conversations = Conversation::with('messages')->where('supervisor_id',$supervisor_id)->paginate(20);
        return $conversations;
    }//.getApiConversationsSupervisor()

    public function getApiConversationsAgent(Request $request){
        $agent_id = $request->agent_id;
        $conversations = Conversation::with('supervisor')->with('messages')->where('agent_id',$agent_id)->paginate(20);
        return $conversations;
    }//.getApiConversationsAgent()
}
