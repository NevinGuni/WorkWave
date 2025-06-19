<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Message;
use App\Models\User;
use App\Models\Employee;
use Carbon\Carbon;

class ChatController extends Controller
{
    public function index()
    {
        if (!session('user_id')) {
            return redirect()->route('login');
        }
        
        return view('chat.index');
    }
    
    public function getMessages(Request $request)
    {
        if (!session('user_id')) {
            return response()->json(['error' => 'Not authenticated'], 401);
        }
        
        $perPage = 20; 
        $lastId = intval($request->input('last_id', 0));
        $direction = $request->input('direction', 'newer'); 
        
        $query = Message::with(['sender' => function($query) {
                $query->with('employee');
            }]);
            
        if ($direction === 'newer') {
            if ($lastId === 0) {
                $subQuery = Message::orderBy('message_id', 'desc')
                          ->limit($perPage);
                          
                $latestIds = $subQuery->pluck('message_id');
                
                if ($latestIds->count() > 0) {
                    $query->whereIn('message_id', $latestIds);
                }
            } else {
                $query->where('message_id', '>', $lastId);
            }
            $query->orderBy('message_id', 'asc');
        } else {
            if ($lastId > 0) {
                $query->where('message_id', '<', $lastId);
            }
            $query->orderBy('message_id', 'desc');
            $query->limit($perPage);
        }
        
        $messages = $query->get();
        
        if ($direction === 'older') {
            $messages = $messages->reverse();
        }
            
        $formattedMessages = $messages->map(function($message) {
            $senderName = $message->sender->username;
            
            if ($message->sender->employee) {
                $senderName = $message->sender->employee->first_name . ' ' . $message->sender->employee->last_name;
            }
            
            return [
                'message_id' => $message->message_id,
                'sender_id' => $message->sender_id,
                'sender_name' => $senderName,
                'message' => $message->message,
                'timestamp' => $message->timestamp,
                'is_self' => $message->sender_id == session('user_id')
            ];
        });
        
        $hasMoreOlderMessages = false;
        $oldestId = $messages->min('message_id') ?? 0;
        
        if ($oldestId > 0) {
            $hasMoreOlderMessages = Message::where('message_id', '<', $oldestId)->exists();
        }
        
        return response()->json([
            'messages' => $formattedMessages,
            'has_more' => $hasMoreOlderMessages
        ]);
    }
    
    public function sendMessage(Request $request)
    {
        if (!session('user_id')) {
            return response()->json(['error' => 'Not authenticated'], 401);
        }
        
        $message = $request->input('message');
        
        if (empty($message)) {
            return response()->json(['error' => 'Message cannot be empty'], 400);
        }
        
        $newMessage = Message::create([
            'sender_id' => session('user_id'),
            'message' => $message,
            'timestamp' => Carbon::now()
        ]);
        
        return response()->json([
            'success' => true,
            'message_id' => $newMessage->message_id
        ]);
    }
}