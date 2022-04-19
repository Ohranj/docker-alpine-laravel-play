<?php

namespace App\Http\Controllers\Auth;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Validation\Rules;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Auth\Events\Registered;
use App\Providers\RouteServiceProvider;
use Illuminate\Support\Facades\Storage;

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
            'firstname' => ['bail', 'required', 'string', 'max:255'],
            'surname' => ['bail', 'required', 'string', 'max:255'],
            'email' => ['bail', 'required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['bail', 'required', 'confirmed', Rules\Password::defaults()],
            'tagline' => ['bail', 'required', 'max:40'],
            'tags' => ['bail', 'required'],
            'level' => ['bail', 'required']
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
        ]);

        $file = $request->file('avatarBlob');

        if ($file) {
            $filePath = "{$user->id}" . ceil(microtime(true)) . '.png';
            Storage::disk('local')->put("public/{$filePath}", file_get_contents($file));
        }

        $user->profile()->create([
            'tagline' => $tagline,
            'tags' => $tags,
            'level' => $level,
            'avatar' => [
                'defaultPath' => '/img/gravatars/iv219dqg2ef71.jpg',
                'customPath' => $file ? $filePath : null
            ]
        ]);

        event(new Registered($user));

        return response()->json([
            'success' => true,
            'message' => 'user registered'
        ]);
    }
}