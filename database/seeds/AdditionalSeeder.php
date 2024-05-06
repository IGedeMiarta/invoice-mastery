<?php

namespace Database\Seeders;

use App\Additional;
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
    }
}
