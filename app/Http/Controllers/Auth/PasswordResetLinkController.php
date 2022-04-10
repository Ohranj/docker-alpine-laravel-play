<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Jobs\ResetPasswordMail;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use App\Models\User;
use Exception;
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

        try {
            $user = User::where('email', $request->email)->firstOrFail();
        } catch (Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Unable to verify request'
            ]);
        }

        $token = Str::random(60);

        DB::table('password_resets')->insert([
            'email' => $user->email,
            'token' => $token,
            'created_at' => date('Y-m-d H:i:s')
        ]);

        dispatch(new ResetPasswordMail($user->email, $token));

        return response()->json([
            'success' => true,
            'message' => 'Forgot password email sent'
        ]);
    }
}
