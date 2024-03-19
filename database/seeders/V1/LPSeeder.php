<?php

namespace Database\Seeders\V1;

use App\Models\V1\LP;
use Illuminate\Database\Seeder;

class LPSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //Create 20 LPs
        LP::withoutEvents(function () {
            LP::factory()->count(10)->create();
        });
    }
}
