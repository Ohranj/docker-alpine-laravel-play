<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $user = User::create([
            'firstname' => 'Master',
            'lastname' => 'Account',
            'email' =>  env('APP_MASTER_EMAIL'),
            'email_verified_at' => Carbon::now()->toDateTimeString(),
            'password' =>  Hash::make(env('APP_MASTER_PASSWORD')),
            'state' => 1,
            'agenda' => 3
        ])->profile()->create([
            'tagline' => 'This is some sample text',
            'tags' => 'Admin, Account, Card, Text',
            'level' => 1
        ]);
    }
}
