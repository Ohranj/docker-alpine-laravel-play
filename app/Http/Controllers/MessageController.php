<?php

namespace App\Http\Controllers;

use Exception;
use Carbon\Carbon;
use App\Models\User;
use App\Models\Message;
use App\Models\MessageReply;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;

class MessageController extends Controller
{
    /**
     * Store a message sent to a user
     * @param Illuminate\Http\Request $request
     * @return string
     */
    public static function storeMessage(Request $request)
    {
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
            switch ($e->getMessage()) {
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
    public static function receivedMessagesJSON(Request $request)
    {

        $received = Message::where([
            ['recipient_id', Auth::id()],
            ['recipient_remove_inbox', '0']
        ])
            ->with([
                'senderUser' => fn ($q) => $q->select('id', 'firstname', 'lastname'),
                'senderUser.profile' => fn ($q) => $q->select('user_id', 'avatar'),
                'replies' => fn ($q) => $q->select('reply_trail', 'message_id')
            ])
            ->select('id', 'message', 'subject', 'recipient_id', 'sender_id', 'recipient_remove_inbox', 'recipient_has_read', 'created_at')
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
    public static function sentMessagesJSON(Request $request)
    {

        $sentMessages = Message::where([
            ['sender_id', Auth::id()],
            ['sender_remove_outbox', '0']
        ])
            ->with([
                'recipientUser' => fn ($q) => $q->select('id', 'firstname', 'lastname'),
                'recipientUser.profile' => fn ($q) => $q->select('user_id', 'avatar'),
                'replies' => fn ($q) => $q->select('reply_trail', 'message_id')
            ])
            ->select('id', 'message', 'subject', 'recipient_id', 'sender_id', 'sender_remove_outbox', 'sender_has_read', 'created_at')
            ->orderBy('created_at', 'desc')
            ->get();

        return response()->json([
            'success' => true,
            'message' => 'Sent messages successfully returned',
            'data' => $sentMessages
        ]);
    }

    /**
     * Set an inbox message to has read
     * @param Illuminate\Http\Request $request
     * @return string
     */
    public static function setMessageRead(Request $request)
    {
        ['id' => $id] = $request->all();

        try {
            $message = Message::withoutEvents((function () use ($id) {
                return Message::where([
                    ['id', $id],
                    ['recipient_id', Auth::id()]
                ])->first();
            }));
            if (!$message) throw new Exception(0);
            $message->recipient_has_read = 1;
            $message->save();
        } catch (\Throwable $e) {
            switch ($e->getMessage()) {
                default:
                    return response()->json(['success' => false, 'message' => 'Unable to verify request']);
            }
        }
        return response()->json(['success' => true, 'message' => 'Message acknowledged as read']);
    }

    /**
     * Set an outbox message to has read
     * @param Illuminate\Http\Request $request
     * @return string
     */
    public static function setOutboxMessageRead(Request $request)
    {
        ['id' => $id] = $request->all();

        try {
            $message = Message::withoutEvents((function () use ($id) {
                return Message::where([
                    ['id', $id],
                    ['sender_id', Auth::id()]
                ])->first();
            }));
            if (!$message) throw new Exception(0);
            $message->sender_has_read = 1;
            $message->save();
        } catch (\Throwable $e) {
            switch ($e->getMessage()) {
                default:
                    return response()->json(['success' => false, 'message' => 'Unable to verify request']);
            }
        }
        return response()->json(['success' => true, 'message' => 'Message acknowledged as read']);
    }

    /**
     * Delete a message from a users inbox
     * @param \Illuminate\Http\Request $request
     * @return string
     */
    public static function deleteMessageInbox(Request $request)
    {
        ['id' => $id] = $request->all();

        try {
            $message = Message::withoutEvents((function () use ($id) {
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
     * Delete a message from a users outbox
     * @param \Illuminate\Http\Request $request
     * @return string
     */
    public static function deleteMessageOutbox(Request $request)
    {
        ['id' => $id] = $request->all();

        try {
            $message = Message::withoutEvents((function () use ($id) {
                return Message::where([
                    ['id', $id],
                    ['sender_id', Auth::id()]
                ])->first();
            }));
            if (!$message) throw new Exception(0);
            $message->sender_remove_outbox = 1;
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
     * Store a reply to a message
     * @param \Illuminate\Htpp\Request $request
     * @return string
     */
    public static function storeMessageReply(Request $request)
    {
        $request->validate([
            'setSenderUnread' => ['required'],
            'messageContent' => ['required'],
            'messageParent' => ['required', function ($attribute, $value, $fail) {
                $messageParent = Message::where('id', $value['id'])->first();
                if (!$messageParent) $fail("The {$attribute} is not valid");
            }]
        ]);

        ['messageContent' => $message, 'messageParent' => $parent, 'setSenderUnread' => $setSenderUnreadBool] = $request->all();

        $appendMessage = MessageReply::where('message_id', $parent['id'])->first();

        $jsonInsert = [
            'message' => $message,
            'sender_id' => Auth::id(),
            'recipient_id' => $parent['sender_id'],
            'created_at' => date('Y-m-d H:i:s'),
            'human_created_at' => Carbon::parse(date('Y-m-d H:i:s'))->toFormattedDateString(),
            'human_created_at_time' => Carbon::parse(date('Y-m-d H:i:s'))->format('H:i')
        ];

        if ($appendMessage) {
            $trail = $appendMessage->reply_trail;
            array_push($trail, $jsonInsert);
            $appendMessage->reply_trail = $trail;
        } else {
            $appendMessage = new MessageReply();
            $appendMessage->message_id = $parent['id'];
            $appendMessage->reply_trail = [$jsonInsert];
            $appendMessage->save();
        }
        $appendMessage->save();

        self::resetMessageRead($parent, $setSenderUnreadBool);

        return response()->json(['success' => true, 'message' => 'Reply sent', 'reply' => $jsonInsert]);
    }

    /**
     * Resetting of the message unread property for the inital chain message - Used when a reply is submitted. Validation done on current initial storeMessageReply function
     * @param object opening message in chain
     * @return void;
     */
    public static function resetMessageRead($openingMessage, $setSenderUnreadBool)
    {
        if ($setSenderUnreadBool) {
            Message::where([
                ['id', $openingMessage['id']],
                ['recipient_id', $openingMessage['recipient_id']]
            ])->update(['sender_has_read' => 0]);
            return;
        }

        Message::where([
            ['id', $openingMessage['id']],
            ['sender_id', Auth::id()]
        ])->update(['recipient_has_read' => 0]);
    }

    /**
     * Returns the number of unread messages for the user for both recieved and sent started chains
     * @param void
     * @return integer Count of a users total unread messages
     */
    public static function count_unread_messages()
    {
        return Message::where([
            ['recipient_id', Auth::id()],
            ['recipient_has_read', 0],
            ['recipient_remove_inbox', 0]
        ])
            ->orWhere(
                fn ($q) => $q->where([
                    ['sender_id', Auth::id()],
                    ['sender_has_read', 0],
                    ['sender_remove_outbox', 0]
                ])
            )
            ->count();
    }

    /**
     * Return the inbox view
     * @return \Illuminate\View\View
     */
    public function index()
    {
        return view('inbox');
    }
}
