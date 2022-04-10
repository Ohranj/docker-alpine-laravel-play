<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;
use App\Models\User;
use Illuminate\Support\Facades\DB;

class PasswordResetLinkController extends Controller
{
    /**
     * Display the password reset link request view.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        return view('auth.forgot-password');
    }

    /**
     * Send a password reset link with a produced random string valule to the given email - providing it exists within the system. 
     * @param \Illuminate\Http\Request  $request
     */
    public static function send_reset_password_link(Request $request)
    {
        $request->validate([
            'email' => ['required', 'email:rfc,dns'],
        ]);

        $user = User::firstWhere('email', $request->email);

        if (!$user) {
            //return no user json
        }

        $token = Str::random(60);

        DB::table('password_resets')->insert([
            'email' => $user->email,
            'token' => $token,
            'created_at' => date('Y-m-d H:i:s')
        ]);

        //Attach to queue
        //Prevent sent event firing
        Mail::send('emails.resetPassword', ['token' => $token], function ($message) use ($user) {
            $message->to($user->email);
            $message->subject('Reset Password');
        });

        return back();
    }
}
