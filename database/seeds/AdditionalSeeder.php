<?php

namespace Database\Seeders;

use App\Additional;
use App\User;
use Illuminate\Database\Seeder;

class AdditionalSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Additional::create([
            'name'=> 'VAT',
            'percent' => 11,
            'type'  => true
        ]);
        Additional::create([
            'name'=> 'Art 12 Income Tax',
            'percent' => 2,
            'type'  => false
        ]);
        User::create([
            'name' => 'admin',
            'email' => 'admin@mail.com',
            'email_verified_at' => now(),
            'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', // password
            'remember_token' => \Str::random(10),
        ]);
    }
}
