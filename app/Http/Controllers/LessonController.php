<?php

namespace App\Http\Controllers;

use App\Http\Requests\LessonPostRequest;
use App\Http\Resources\LessonCollection;
use App\Http\Resources\LessonResource;
use App\Http\Resources\TagCollection;
use App\Http\Traits\RestApiResponseTrait;
use App\Models\Lesson;
use Illuminate\Http\Request;

class LessonController extends Controller
{
    use RestApiResponseTrait;

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // awful practice for using Lesson::all();
        // 1. No pagination - All is bad
        // 2. No way to attach meta data
        // 3. Linking DB structure to the API output
        // 4. No way to signal headers/response code
        // $lessons = Lesson::all();

        // https://laravel.com/docs/10.x/eloquent-resources#resource-collections
        return new LessonCollection(Lesson::paginate());
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(LessonPostRequest $request)
    {
        // https://laravel.com/docs/10.x/validation#validation-error-response-format

        // The incoming request is valid...

        // Retrieve a portion of the validated input data...
        $validated = $request->safe()->only(['title', 'body', 'active']);

        $lesson = Lesson::create([
            'title' => $validated['title'],
            'body' => $validated['body'],
            'some_bool' => $validated['active'],
        ]);

        return $this->respondCreated($lesson->id);
    }

    /**
     * Display the specified resource.
     */
    public function show(Lesson $lesson)
    {
        // https://laravel.com/docs/10.x/eloquent-resources#concept-overview
        return new LessonResource($lesson);
    }

    /**
     * Display the specified Tag resource.
     */
    public function showTags(Lesson $lesson)
    {
        $tags = $lesson->tags()->get()->sort();

        // TODO: Maybe in the future return not found exception
        return new TagCollection($tags);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Lesson $lesson)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Lesson $lesson)
    {
        //
    }
}
