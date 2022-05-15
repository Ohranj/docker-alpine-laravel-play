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
    public static function getNewestUsers()
    {
        return User::with([
            'profile' => fn ($q) => $q->select('user_id', 'avatar', 'level', 'tagline', 'tags')
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
    public static function followUser(Request $request)
    {
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
    public static function unfollowUser(Request $request)
    {
        $unfollowUser = $request->all();
        $unfollowID = $unfollowUser['id'];

        $AuthUser = User::where('id', Auth::id())->first();
        $result = $AuthUser->followings()->detach($unfollowID);

        if ($result == 0) return response()->json(['success' => false, 'message' => 'Unable to verify request']);

        return response()->json(['success' => true, 'message' => 'User unfollowed']);
    }

    /**
     * Search for users and paginate the response data
     * @param Illuminate\Http\Request $request
     * @return string json
     * @var searchTerm search term taken from the query string 
     * @var currentPage current page takwn from the query string regards to pagination
     * @var paginateBy Returns the number of users per page
     */
    public static function simpleSearchUsers(Request $response)
    {
        $searchTerm = $response->query('search');
        $paginateBy = $response->query('paginateBy');

        $matchingUsers = User::with('profile')
            ->where('firstname', 'like', '%' . $searchTerm . '%')
            ->orWhere('lastname', 'like', '%' . $searchTerm . '%')
            ->paginate($paginateBy);

        return response()->json([
            'success' => true,
            'message' => 'Matching users fetched',
            'data' => $matchingUsers,
        ]);
    }


    /**
     * Return the members view
     * @return \Illuminate\View\View
     */
    public function index()
    {
        $newestUSers = $this->getNewestUsers();
        return view('members', [
            'newestUsers' => $newestUSers
        ]);
    }
}
