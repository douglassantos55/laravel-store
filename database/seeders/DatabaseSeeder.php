<?php

namespace Database\Seeders;

use App\Models\Author;
use App\Models\Book;
use App\Models\Category;
use App\Models\Publisher;
use App\Models\User;
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
        User::factory()->create();
        Category::factory()->count(5)->create();
        Publisher::factory()->count(5)->create();
        Author::factory()->count(5)->create();

        Book::factory()
            ->count(20)
            ->for(Category::all()->random())
            ->for(Publisher::all()->random())
            ->for(Author::all()->random())
            ->create();
    }
}
