<?php

namespace App\Http\Controllers;

use App\Http\Resources\LessonCollection;
use App\Http\Resources\LessonResource;
use App\Models\Lesson;
use Illuminate\Http\Request;

class LessonController extends Controller
{
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

        $lessons = Lesson::all();
        // https://laravel.com/docs/10.x/eloquent-resources#resource-collections
        return new LessonCollection(Lesson::paginate());
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // https://laravel.com/docs/10.x/validation#validation-error-response-format
        //dd($request);

        // TODO: Continue saving form. Lesson 007. https://blog.avenuecode.com/the-best-way-to-use-request-validation-in-laravel-rest-api
        $attributes = $request->validate([
           'title' => 'required',
           'body' => 'required',
           'active' => 'required|boolean',
        ]);

        dd($attributes);
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
