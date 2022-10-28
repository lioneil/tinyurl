<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\Destination;
use App\Models\Tag;
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
        $tags = Tag::factory(100)->create();
        $destinations = Destination::factory(500)->create();
        $destinations->each(function ($destination) use ($tags) {
            $tags->random(rand(1, 10))->each(fn($tag) => $destination->tags()->attach($tag->id));
        });
        $destinations->random(100)->each(fn($destination) => $destination->delete());
    }
}
