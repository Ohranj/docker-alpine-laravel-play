<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Providers\RouteServiceProvider;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;

class RegisteredUserController extends Controller
{
    /**
     * Display the registration view.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        return view('auth.register');
    }

    /**
     * Handle an incoming registration request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request)
    {
        $request->validate([
            'firstname' => ['required', 'string', 'max:255'],
            'surname' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
            'tagline' => ['required'],
            'tags' => ['required'],
            'level' => ['required']
        ]);

        [
            'firstname' => $firstname, 'surname' => $surname, 'email' => $email, 'password' => $password,
            'tagline' => $tagline, 'tags' => $tags, 'level' => $level
        ] = $request;


        $user = User::create([
            'firstname' => $firstname,
            'lastname' => $surname,
            'email' => $email,
            'password' => Hash::make($password)
        ])->profile()->create([
            'tagline' => $tagline,
            'tags' => $tags,
            'level' => $level
        ]);

        // event(new Registered($user));

        // Auth::login($user);

        // return redirect(RouteServiceProvider::HOME);
        return response()->json([
            'success' => true,
            'message' => 'user registered'
        ]);
    }
}
