<?php

namespace Database\Seeders\V1;

use App\Models\V1\Author;
use Illuminate\Database\Seeder;

class AuthorSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //Create 15 authors
        Author::withoutEvents(function () {
            Author::factory()->count(21)->create();
        });
    }
}
