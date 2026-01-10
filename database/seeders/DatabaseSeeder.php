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
        // Create tags
        $tags = Tag::factory(10)->create();

        // Create some voters (users who will vote on answers)
        $voters = User::factory(30)->create();

        // Create test users with specific credentials and badges
        $minThant = User::factory()->create([
            'name' => 'min thant',
            'email' => 'minthant@gmail.com',
            'password' => Hash::make('minthant1234'),
        ]);

        $marry = User::factory()->create([
            'name' => 'marry',
            'email' => 'marry@gmail.com',
            'password' => Hash::make('marry1234'),
        ]);

        $jack = User::factory()->create([
            'name' => 'jack',
            'email' => 'jack@gmail.com',
            'password' => Hash::make('jack1234'),
        ]);

        // Create questions for test users with tags attached (question_tag table)
        $minThantQuestions = Question::factory(3)->create(['user_id' => $minThant->id]);
        $marryQuestions = Question::factory(3)->create(['user_id' => $marry->id]);
        $jackQuestions = Question::factory(3)->create(['user_id' => $jack->id]);

        // Attach tags to questions (populate question_tag table)
        foreach ($minThantQuestions as $question) {
            $question->tags()->attach($tags->random(rand(1, 3)));
        }
        foreach ($marryQuestions as $question) {
            $question->tags()->attach($tags->random(rand(1, 3)));
        }
        foreach ($jackQuestions as $question) {
            $question->tags()->attach($tags->random(rand(1, 3)));
        }

        // Create answers for min thant (Newbie: 2 points = 2 upvotes)
        $minThantAnswers = collect();
        foreach ($minThantQuestions as $question) {
            $minThantAnswers = $minThantAnswers->merge(
                Answer::factory(2)->create([
                    'user_id' => $minThant->id,
                    'question_id' => $question->id,
                ])
            );
        }
        // Create 2 upvotes on min thant's answers
        $usedVoters = collect();
        $voteCount = 0;
        foreach ($minThantAnswers->take(2) as $answer) {
            if ($voteCount >= 2) {
                break;
            }
            $availableVoters = $voters->diff($usedVoters);
            if ($availableVoters->isEmpty()) {
                $usedVoters = collect();
                $availableVoters = $voters;
            }
            $voter = $availableVoters->random();
            $usedVoters->push($voter);
            Vote::factory()->upvote()->create([
                'user_id' => $voter->id,
                'votable_type' => Answer::class,
                'votable_id' => $answer->id,
            ]);
            $voteCount++;
        }

        // Create answers for marry (Helper: 10 points = 10 upvotes)
        $marryAnswers = collect();
        foreach ($marryQuestions as $question) {
            $marryAnswers = $marryAnswers->merge(
                Answer::factory(4)->create([
                    'user_id' => $marry->id,
                    'question_id' => $question->id,
                ])
            );
        }
        // Create 10 upvotes on marry's answers
        $usedVoters = collect();
        $voteCount = 0;
        foreach ($marryAnswers->take(10) as $answer) {
            if ($voteCount >= 10) {
                break;
            }
            $availableVoters = $voters->diff($usedVoters);
            if ($availableVoters->isEmpty()) {
                $usedVoters = collect();
                $availableVoters = $voters;
            }
            $voter = $availableVoters->random();
            $usedVoters->push($voter);
            Vote::factory()->upvote()->create([
                'user_id' => $voter->id,
                'votable_type' => Answer::class,
                'votable_id' => $answer->id,
            ]);
            $voteCount++;
        }

        // Create answers for jack (Expert: 25 points = 25 upvotes)
        $jackAnswers = collect();
        foreach ($jackQuestions as $question) {
            $jackAnswers = $jackAnswers->merge(
                Answer::factory(5)->create([
                    'user_id' => $jack->id,
                    'question_id' => $question->id,
                ])
            );
        }
        // Create 25 upvotes on jack's answers (some answers get multiple upvotes)
        $usedVoters = collect();
        $voteCount = 0;
        foreach ($jackAnswers as $answer) {
            if ($voteCount >= 25) {
                break;
            }
            $votesPerAnswer = min(3, 25 - $voteCount); // Max 3 votes per answer
            for ($i = 0; $i < $votesPerAnswer; $i++) {
                if ($voteCount >= 25) {
                    break 2;
                }
                $availableVoters = $voters->diff($usedVoters);
                if ($availableVoters->isEmpty()) {
                    $usedVoters = collect();
                    $availableVoters = $voters;
                }
                $voter = $availableVoters->random();
                $usedVoters->push($voter);
                Vote::factory()->upvote()->create([
                    'user_id' => $voter->id,
                    'votable_type' => Answer::class,
                    'votable_id' => $answer->id,
                ]);
                $voteCount++;
            }
            // Reset used voters for next answer to allow same voter to vote on different answers
            $usedVoters = collect();
        }

        // Create additional questions and answers with tags for general data
        Question::factory(5)
            ->has(Answer::factory()->count(5))
            ->create()
            ->each(function ($question) use ($tags) {
                $question->tags()->attach($tags->random(rand(1, 3)));
            });
    }
}
