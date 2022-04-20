<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class MemberController extends Controller
{
    private static $numNewUsers = 8;

    /**
     * Returns a list of the last 8 registered users
     * @return array $newUsers
     */
    public static function getNewestUsers() {
        return User::with('profile')->latest('id')->take(static::$numNewUsers)->get();
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
