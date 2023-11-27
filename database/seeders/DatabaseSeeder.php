<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\Admin;
use App\Models\Job;
use App\Models\Question;
use App\Models\User;
use File;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // \App\Models\User::factory(10)->create();

        $admins = json_decode(File::get("database/data/admins.json"));
        foreach ($admins as $key => $value) {
            Admin::create([
                "username" => $value->username,
                "name" => $value->name,
                "password" => bcrypt('admin'),
            ]);
        }

        $users = json_decode(File::get("database/data/users.json"));
        foreach ($users as $key => $value) {
            User::create([
                "username" => $value->username,
                "name" => $value->name,
                "password" => bcrypt(123456),
            ]);
        }

        $jobs = json_decode(File::get("database/data/jobs.json"));
        foreach ($jobs as $key => $value) {
            Job::create([
                "name" => $value->name,
                "tags" => $value->tags,
            ]);
        }

        $questions = json_decode(File::get("database/data/questions.json"));
        foreach ($questions as $key => $value) {
            Question::create([
                "code" => $value->code,
                "name" => $value->name,
                "y" => $value->y,
                "n" => $value->n,
            ]);
        }
    }
}
