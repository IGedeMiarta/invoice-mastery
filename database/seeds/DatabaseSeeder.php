<?php

use App\User;
use Database\Seeders\AdditionalSeeder;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call(AdditionalSeeder::class);
    }
}
