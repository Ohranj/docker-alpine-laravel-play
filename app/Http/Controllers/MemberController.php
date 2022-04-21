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
