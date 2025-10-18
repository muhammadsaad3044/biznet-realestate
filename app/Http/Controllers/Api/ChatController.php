<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\chats;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Facades\Cache;

class ChatController extends Controller
{
    public function unreadmesaages($senderId, $receiverId){
         
        $unreadMessages = chats::where('sender_id', $senderId)
                        ->where('receiver_id', $receiverId)
                        ->where('is_read', 0)
                        ->count();
                        
        return response()->json([
                'unread_messages' => $unreadMessages,
            ]);
        
    }
    
    
    
    public function markasread(Request $request){
        
        
        $validator = Validator::make($request->all(), [
            'senderId' => 'required|exists:users,id',
            'receiverId' => 'required|exists:users,id',
        ]);
        
        // Return validation errors as JSON
        if ($validator->fails()) {
            return response()->json([
                'status' => 'error',
                'errors' => $validator->errors()
            ], 422);
        }
        
         
        $updatedCount = Chats::where('sender_id', $request->senderId)
            ->where('receiver_id', $request->receiverId)
            ->where('is_read', 0)
            ->update(['is_read' => 1]);
    
        // Return the number of messages marked as read
        return response()->json([
            'marked_as_read' => $updatedCount,
            'message' => $updatedCount > 0 ? 'Messages marked as read.' : 'No unread messages found.',
        ]);
        
    }
     
     
    public function storeMessages(Request $request)
    {
        
        
        $validator = Validator::make($request->all(), [
            'senderId' => 'required|exists:users,id',
            'receiverId' => 'required|exists:users,id',
            'image.*' => 'image|mimes:jpeg,png,jpg,gif',
        ]);
        
        
        // dd("validate  data", $validator );
        // die();
        
        // Return validation errors as JSON
        if ($validator->fails()) {
            return response()->json([
                'status' => 'error',
                'errors' => $validator->errors()
            ], 422);
        }
        
        $senderId = $request->senderId;
        $receiverId = $request->receiverId;
        
        $chat = new chats();
        $chat->sender_id = $senderId;
        $chat->receiver_id = $receiverId;
        $chat->message = $request->message;
        $chat->save();
        
        return response()->json($chat);
    }
    


    public function fetchMessages($senderId, $receiverId)
    {
        // Generate a unique cache key for the sender-receiver pair
        $cacheKey = "messages_{$senderId}_{$receiverId}";
    
        // Check if the messages are available in the cache
        $messages = Cache::remember($cacheKey, 10, function () use ($senderId, $receiverId) {
            // Query the database if cache is not available
            return chats::where(function ($query) use ($senderId, $receiverId) {
                    $query->where('sender_id', $senderId)
                          ->where('receiver_id', $receiverId);
                })->orWhere(function ($query) use ($senderId, $receiverId) {
                    $query->where('sender_id', $receiverId)
                          ->where('receiver_id', $senderId);
                })->orderBy('created_at', 'asc')
                  ->take(300)
                  ->latest('id')
                  ->get();
        });
    
        // Return the messages as a JSON response
        return response()->json($messages);
    }

    
    
  
    
}
