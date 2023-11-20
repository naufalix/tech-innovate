<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\Admin;
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
    }
}
