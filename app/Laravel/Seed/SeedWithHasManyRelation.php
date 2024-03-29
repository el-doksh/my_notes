<?php

namespace Database\Seeders;

use App\Models\Topic\Topic;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class TopicSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Topic::factory(50)->create()->each(function ($topic){
            $topic->children()->saveMany(Topic::factory(5)->create());
        });
    }
}
