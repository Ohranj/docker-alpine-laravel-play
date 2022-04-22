<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MemberController extends Controller
{
    private static $numNewUsers = 8;

    /**
     * Returns a list of the last x registered users
     * @param int static::$numNewUsers
     * @return array $newUsers
     */
    public static function getNewestUsers() {
        return User::with([
            'profile' => fn($q) => $q->select('user_id', 'avatar', 'level', 'tagline', 'tags')
            ])
            ->latest('id')
            ->take(static::$numNewUsers)
            ->select('id', 'firstname', 'lastname')
            ->get();
    }

    /**
     * Follow a user
     * @param Illuminate\Http\Request $request
     * @return string
     */
    public static function followUser(Request $request) {
        $followUser = $request->all();

        $followID = $followUser['id'];

        $AuthUser = User::where('id', Auth::id())->first();

        $AuthUser->followings()->attach($followID);

        return response()->json(['success' => true, 'message' => 'User followed']);
    }

    /**
     * Unfollow a user
     * @param Illuminate\Http\Request $request
     * @return string
     */
    public static function unfollowUser(Request $request) {
        $unfollowUser = $request->all();

        $unfollowID = $unfollowUser['id'];

        $AuthUser = User::where('id', Auth::id())->first();

        $result = $AuthUser->followings()->detach($unfollowID);

        if ($result == 0) return response()->json(['success' => false, 'message' => 'Unable to verify request']);

        return response()->json(['success' => true, 'message' => 'User unfollowed']);
    }

    /**
     * Return the members view
     * @return \Illuminate\View\View
     */
    public function index() {
        $newestUSers = $this->getNewestUsers();
        return view('members', [
            'newestUsers' => $newestUSers
        ]);
    }
}
