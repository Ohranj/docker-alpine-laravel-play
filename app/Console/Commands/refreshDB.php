<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\User;

class refreshDB extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'run:refreshDB';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Drop the database, run migrations and seed the database with fake data';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $numRowsToAdd = 10;

        $response = $this->confirm('Do you wish to wipe the data from the database and repopulate?');
        if ($response) {
            $this->call('db:wipe');
            $this->info('Table data has been wiped from the database');
            $this->call('migrate');
            $this->info('Database migrations have been ran');
            User::factory()->count($numRowsToAdd)->create();
            $this->info("{$numRowsToAdd} new users have been populated into the User table");
            $this->info('Command completed successfully');
        }
        $this->line($response);
    }
}
