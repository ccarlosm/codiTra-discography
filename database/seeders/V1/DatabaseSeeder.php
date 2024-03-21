<?php

namespace Database\Seeders\V1;

use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        User::factory()->create([
            'name' => 'Test User',
            'email' => 'test@example.com',
            'password' => bcrypt('123456'),
        ]);

        //Run the seeders
        $this->call([
            ArtistSeeder::class,
            LPSeeder::class,
            SongSeeder::class,
            SongAuthorSeeder::class,
        ]);
    }
}
