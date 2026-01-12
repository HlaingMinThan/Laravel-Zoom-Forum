<?php

namespace Database\Seeders;

use App\Models\Answer;
use App\Models\Question;
use App\Models\Tag;
use App\Models\User;
use App\Models\Vote;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        User::factory(5)->create();
        // total 5 questions and each question should have 5 answers
        
        $tags = [
            [
                'name' => 'PHP',
                'slug' => 'php'
            ],
            [
                'name' => 'JS',
                'slug' => 'js'
            ],
            [
                'name' => 'Vue',
                'slug' => 'vue'
            ],
            [
                'name' => 'Inertia',
                'slug' => 'inertia'
            ],
            [
                'name' => 'Laravel',
                'slug' => 'laravel'
            ],

        ];
        foreach ($tags as $tag) {
            Tag::factory()->create(
                [
                    'name'=>$tag['name'],
                    'slug'=>$tag['slug']
                ]
            );
        }
        Question::factory(5)
        ->has(Answer::factory()->count(5))
        ->create()
        ->each(function($q){
            $q->tags()->attach(Tag::inRandomOrder()->take(rand(1,3))->pluck('id'));
        });
    }
}
