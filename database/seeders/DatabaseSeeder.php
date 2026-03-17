<?php

namespace Database\Seeders;

use App\Models\Book;
use App\Models\review;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;


    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

       /* User::factory()->create([
            'name' => 'Test User',
            'email' => 'test@example.com',
        ]);*/

          // Create some users first
    $users = User::factory(10)->create();

    Book::factory(30)->create()->each(function ($book) use ($users) {
        $numReviews = random_int(4, 30);
        // Mix of good and bad reviews, each assigned to a random user
        review::factory(intval($numReviews / 2))
            ->for($book)
            ->goodReview()
            ->create(['user_id' => $users->random()->id]);

        review::factory(intval($numReviews / 2))
            ->for($book)
            ->badReview()
            ->create(['user_id' => $users->random()->id]);
    });




    }

}