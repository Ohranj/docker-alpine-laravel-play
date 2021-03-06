<?php

namespace Database\Seeders;

use App\Models\Exercise;
use Carbon\Carbon;
use App\Models\User;
use App\Models\Message;
use Illuminate\Database\Seeder;
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
        ]);


        $user->profile()->create([
            'tagline' => 'This is some sample text',
            'tags' => 'Admin, Account, Card, Text',
            'level' => 1,
            'avatar' => [
                'defaultPath' => '/img/gravatars/iv219dqg2ef71.jpg',
                'customPath' => null
            ]
        ]);


        $user->followings()->attach(['following_id' => 11]);

        $messageInsert = new Message();
        $messageInsert->recipient_id = $user->id;
        $messageInsert->sender_id = 11;
        $messageInsert->subject = $messageInsert->setEncrypt('subject', 'Welcome to the site!');
        $messageInsert->message = $messageInsert->setEncrypt('message', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed at leo non augue tempus pulvinar at vitae enim. Donec ullamcorper varius orci, ut accumsan libero pretium et. Donec ultrices mollis massa nec volutpat. Nunc in nulla in nunc facilisis egestas. Sed dignissim ipsum dolor, at maximus nisl tincidunt at. Sed quis fermentum nulla. Morbi hendrerit lectus quis massa viverra aliquam.');
        $messageInsert->save();

        $messageInsert = new Message();
        $messageInsert->sender_id = $user->id;
        $messageInsert->recipient_id = 11;
        $messageInsert->subject = $messageInsert->setEncrypt('subject', 'Just saying Hello and testing my subject length');
        $messageInsert->message = $messageInsert->setEncrypt('message', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed at leo non augue tempus pulvinar at vitae enim. Donec ullamcorper varius orci, ut accumsan libero pretium et. Donec ultrices mollis massa nec volutpat. Nunc in nulla in nunc facilisis egestas. Sed dignissim ipsum dolor, at maximus nisl tincidunt at. Sed quis fermentum nulla. Morbi hendrerit lectus quis massa viverra aliquam.');
        $messageInsert->save();

        //Insert the exercise data
        $exercisesData = json_decode(file_get_contents(storage_path('/app/public/exercises.json')), true);
        $exerciseInserts = [];
        foreach ($exercisesData['exercises'] as $key => $val) {
            array_push($exerciseInserts, [
                'exercise' => $val['name'],
                'data' => json_encode([
                    'force' => $val['force'],
                    'secondary_muscles' => $val['secondaryMuscles'],
                    'instructions' => $val['instructions']
                ]),
                'category' => $val['category'],
                'primary_muscle' => $val['primaryMuscles'][0],
                'level' => $val['level'],
                'equipment' => $val['equipment'],
                'movement' => $val['mechanic']
            ]);
        }
        Exercise::insert($exerciseInserts);
    }
}
