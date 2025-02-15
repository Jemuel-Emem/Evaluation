<?php
namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\Category;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // \App\Models\User::factory(10)->create();

        \App\Models\User::factory()->create([
            'name'     => 'Test admin',
            'email'    => 'admin@gmail.com',
            'password' => 'password',
            'is_admin' => 1,

        ]);

        \App\Models\User::factory()->create([
            'name'     => 'Test ',
            'email'    => 'tes@gmail.com',
            'password' => 'password',
            'is_admin' => 0,

        ]);

        Category::create([
            'name' => 'Program Activities',
        ]);
        Category::create([
            'name' => 'Venue',
        ]);
        Category::create([
            'name' => 'Accommodations',
        ]);
        Category::create([
            'name' => 'Speakers',
        ]);

    }
}
