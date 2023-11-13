<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Models\Lesson;
use Illuminate\Support\Facades\Config;
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

    public function test_it_creates_a_new_lesson_given_valid_parameters()
    {
        $lessonFactoryDefinition = Lesson::factory()->definition();

        $response = $this->postRequestWithBasicAuthStatic(
            'api/v1/lessons',
            array_merge(
                $lessonFactoryDefinition,
                // Send some_bool as active as we use it for the route like that
                ['active' => $lessonFactoryDefinition['some_bool']]
            )
        );

        $response->assertStatus(201)
            ->assertJsonPath('data.id', fn (int $id) => ! empty($id));
    }

    public function test_it_throws_400_if_we_try_to_create_a_new_lesson_with_invalid_parameters()
    {
        $lessonFactoryDefinition = Lesson::factory()->definition();

        $response = $this->postRequestWithBasicAuthStatic(
            'api/v1/lessons',
            array_merge(
                $lessonFactoryDefinition,
                ['title' => null]
            )
        );

        $response->assertStatus(400)
            // Check if we have error key in the response object
            ->assertJsonPath('error', fn (array $error) => ! empty($error));;
    }

    private function postRequestWithBasicAuthStatic($route, $parameters)
    {
        // Set the basic auth credentials to use in the request
        $email = Config::get('auth.sso.username');
        $pwd = Config::get('auth.sso.password');

        return $this->postJson(
            $route,
            $parameters,
            ['Authorization' => 'Basic '.base64_encode($email.':'.$pwd),]
        );
    }

    private function makeLessons($count)
    {
        Lesson::factory()->count($count)->create();
    }
}
