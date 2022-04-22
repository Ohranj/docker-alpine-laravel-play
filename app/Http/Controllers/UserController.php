<?php

namespace App\Http\Controllers;

use App\Models\User;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    /**
     * Return logged in user as jso
     * @param Illuminate\Http\Request $request
     * @return string
     */
    public static function getUserJSON() {
        try {
            $user = User::where('id', Auth::id())->with([
                'profile' => fn($q) => $q->select('user_id', 'level'), 
                'followings' => fn($q) => $q->select('id'), 
                'followers'
            ])
            ->select('id', 'firstname', 'lastname')
            ->first();
            if (!$user) throw new Exception(0);
            return response()->json(['success' => true, 'user' => $user]);
        } catch (\Throwable $e) {
            switch($e) {
                case '0':
                    return response()->json(['success' => true, 'message' => 'Unable to verify request']);
                default:
                    return response()->json(['success' => true, 'user' => $e]);
            }
        }
    }
}
