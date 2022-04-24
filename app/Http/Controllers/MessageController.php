<?php

namespace App\Http\Controllers;

use Exception;
use App\Models\User;
use App\Models\Message;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

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

        // $received = User::where('id', Auth::id())
        //     ->whereHas('received_messages', fn($q) => $q->where('recipient_remove_inbox', '=', '0'))
        //     ->with([
        //         'received_messages' => fn($q) => $q->select('id', 'message', 'subject', 'recipient_id', 'sender_id', 'recipient_remove_inbox')
        //         ])
        //     ->select('id')
        //     ->get();

        $received = Message::where([
            ['recipient_id', Auth::id()],
            ['recipient_remove_inbox', '0']
        ])
        ->select('id', 'message', 'subject', 'recipient_id', 'sender_id', 'recipient_remove_inbox', 'created_at')
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

    /**
     * Return the inbox view
     * @return \Illuminate\View\View
     */
    public function index() {
        return view('inbox');
    }
}
