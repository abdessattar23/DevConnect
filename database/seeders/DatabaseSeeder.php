<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Skill;
use App\Models\Project;
use App\Models\Post;
use App\Models\JobOffer;
use App\Models\Message;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // Create base users
        $users = User::factory(50)->create();

        // Create skills and attach them to users
        $skills = Skill::factory(30)->create();
        $users->each(function ($user) use ($skills) {
            $user->skills()->attach(
                $skills->random(rand(3, 8))->pluck('id')->toArray()
            );
        });

        // Create projects for users
        $users->each(function ($user) {
            Project::factory(rand(1, 4))->create([
                'user_id' => $user->id
            ]);
        });

        // Create posts
        Post::factory(100)->create([
            'user_id' => fn() => $users->random()->id
        ]);

        // Create job offers
        JobOffer::factory(30)->create();

        // Create messages between users
        $users->each(function ($user) use ($users) {
            $recipients = $users->except($user->id)->random(rand(3, 8));
            foreach ($recipients as $recipient) {
                Message::factory(rand(1, 5))->create([
                    'sender_id' => $user->id,
                    'receiver_id' => $recipient->id
                ]);
            }
        });
    }
}
