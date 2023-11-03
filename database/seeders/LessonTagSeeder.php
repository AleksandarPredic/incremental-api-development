<?php

namespace Database\Seeders;

use App\Models\Lesson;
use App\Models\Tag;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class LessonTagSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $lessonIds = Lesson::pluck('id');
        $tagIds = Tag::pluck('id');

        foreach ($lessonIds as $id) {
            DB::table('lesson_tag')->insert([
                'lesson_id' => fake()->randomElement($lessonIds),
                'tag_id' => fake()->randomElement($tagIds)
            ]);
        }
    }
}
