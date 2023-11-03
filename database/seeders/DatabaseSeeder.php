<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\Lesson;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Schema;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // \App\Models\User::factory(10)->create();

        // \App\Models\User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);

        // laravel Cannot truncate a table referenced in a foreign key constraint fix
        // https://gist.github.com/isimmons/8202227
        Schema::disableForeignKeyConstraints();

        $this->call([
            LessonSeeder::class,
            TagSeeder::class,
            LessonTagSeeder::class
        ]);

        Schema::enableForeignKeyConstraints();
    }
}
