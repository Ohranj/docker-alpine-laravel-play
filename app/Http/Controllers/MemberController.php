<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class MemberController extends Controller
{
    public static function getNewestUsers() {
        $newUsers = User::latest('id')->take(8)->get();
        return $newUsers;
    }

    public function index() {
        $newestUSers = $this->getNewestUsers();
        return view('members', [
            'newestUsers' => $newestUSers
        ]);
    }
}
