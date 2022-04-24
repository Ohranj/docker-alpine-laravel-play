<?php

namespace App\Http\Controllers;

use Exception;
use App\Models\User;
use App\Models\Message;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class MessageController extends Controller
{
    /**
     * Store a message sent to a user
     * @param Illuminate\Http\Request $request
     * @return string
     */
    public static function storeMessage(Request $request) {
        $request->validateWithBag('storeMessage', [
            'message' => ['bail', 'required'],
            'subject' => ['bail', 'required', 'max:100'],
            'recipient' => ['bail', 'required', 'integer'],
        ]);

        ['message' => $message, 'recipient' => $recipient, 'subject' => $subject] = $request;

        try {
            $recipientExists = User::where('id', $recipient)->first();
            if (!$recipientExists) throw new Exception('0');
        } catch (\Throwable $e) {
            switch($e->getMessage()) {
                case '0':
                    return response()->json(['success' => false, 'message' => 'Unable to verify request. invalid recipient']);
                default:
                    return response()->json(['success' => false, 'message' => 'Unable to verify request']);
            }
        }

        $newMessage = new Message();
            $newMessage->sender_id = Auth::id();
            $newMessage->recipient_id = $recipient;
            $newMessage->subject = $newMessage->setEncrypt('subject', $subject);
            $newMessage->message = $newMessage->setEncrypt('message', $message);
        $newMessage->save();

        return response()->json(['success' => true, 'message' => 'Message sent']);
    }

    /**
     * Retrieve a users received messages that haven't been deleted
     * @param Illuminate\Http\Request $request
     * @return string
     */
    public static function receivedMessagesJSON(Request $request) {

        $received = Message::where([
            ['recipient_id', Auth::id()],
            ['recipient_remove_inbox', '0']
        ])
        ->with([
            'senderUser' => fn($q) => $q->select('id', 'firstname', 'lastname'),
            'senderUser.profile' => fn($q) => $q->select('user_id', 'avatar')
        ])
        ->select('id', 'message', 'subject', 'recipient_id', 'sender_id', 'recipient_remove_inbox', 'created_at')
        ->orderBy('created_at', 'desc')
        ->get();

        return response()->json([
            'success' => true,
            'message' => 'Received messaged successfully returned',
            'data' => $received
        ]);
    }

    /**
     * Retrieve a users sent messages that haven't been deleted
     * @param Illuminate\Http\Request $request
     * @return string
     */
    public static function sentMessagesJSON(Request $request) {

        $sentMessages = Message::where([
            ['sender_id', Auth::id()],
            ['sender_remove_outbox', '0']
        ])
        ->with([
            'recipientUser' => fn($q) => $q->select('id', 'firstname', 'lastname'),
            'recipientUser.profile' => fn($q) => $q->select('user_id', 'avatar')
        ])
        ->select('id', 'message', 'subject', 'recipient_id', 'sender_id', 'sender_remove_outbox', 'created_at')
        ->orderBy('created_at', 'desc')
        ->get();

        return response()->json([
            'success' => true,
            'message' => 'Sent messages successfully returned',
            'data' => $sentMessages
        ]);
    }

     /**
      * Delete a message from a users inbox
      * @param \Illuminate\Http\Request $request
      * @return string
      */
      public static function deleteMessageInbox(Request $request) {
        ['id' => $id] = $request->all();
        
        try {
            $message = Message::withoutEvents((function() use ($id) {
                return Message::where([
                    ['id', $id],
                    ['recipient_id', Auth::id()]
                ])->first();
            }));
            if (!$message) throw new Exception(0);
            $message->recipient_remove_inbox = 1;
            $message->save();
        } catch (\Throwable $e) {
            Log::info("{$e->getMessage()} - Error deleting inbox message");
            switch ($e->getMessage()) {
                default:
                    return response()->json(['success' => false, 'message' => 'Unable to verify request']);
            }
        }
        return response()->json(['success' => true, 'message' => 'Message deleted']);
      }
  
    /**
     * Return the inbox view
     * @return \Illuminate\View\View
     */
    public function index() {
        return view('inbox');
    }
}
