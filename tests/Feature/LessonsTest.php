<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Models\Lesson;
use Tests\TestCase;

class LessonsTest extends TestCase
{
    use RefreshDatabase;

    /**
     * @test
     */
    public function it_fetches_lessons()
    {
        // Arrange
        $this->makeLessons(5);

        // Act
        $lessonCollection = $this->getJson('api/v1/lessons');

        // Assert
        $lessonCollection->assertStatus(200);
    }

    public function test_it_fetches_a_single_lesson()
    {
        $this->makeLessons(1);

        $id = Lesson::first()->id;

        $lessonResource = $this->getJson('api/v1/lessons/' . $id);

        // https://laravel.com/docs/10.x/http-tests#verifying-json-paths
        $lessonResource->assertStatus(200)
        ->assertJsonPath('data.title', fn (string $title) => ! empty($title));
    }

    public function test_it_returns_404_if_a_single_lesson_is_not_found()
    {
        $this->makeLessons(1);

        $lessonResource = $this->getJson('api/v1/lessons/x');

        $lessonResource->assertStatus(404);
    }

    private function makeLessons($count)
    {
        Lesson::factory()->count($count)->create();
    }
}
