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
        User::create([
            'firstname' => 'Master',
            'lastname' => 'Account',
            'email' => 'ajdorrington@hotmail.co.uk',
            'email_verified_at' => Carbon::now()->toDateTimeString(),
            'password' => Hash::make('Orange18'),
            'state' => 1,
            'agenda' => 3
        ]);
    }
}
