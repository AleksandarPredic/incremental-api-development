## Practicing REST API development

Tutorial used: https://laracasts.com/series/incremental-api-development

## Steps to create an API

1. sail artisan make:model Lesson -mfcsr --api - Create model, factory, controller, seeder and make it resource

2. sail artisan db:seed

3. Handling resource not found By default when a specified model is not found, Laravel will throw a ModelNotFoundException and renders a 404 page. Since we are building an API, we want to handle the exception and throw an API friendly error message.
   See: https://laravel.com/docs/10.x/errors#rendering-exceptions
```php
   // app/Exceptions/Handler.php
   // Add this method

   public function register(): void
    {
        $this->renderable(function (NotFoundHttpException $e, Request $request) {
            if ($request->is('api/*')) {
                return response()->json([
                    'message' => 'Resource not found.'
                ], 404);
            }
        });
    }
```
just update the register. Don't forget to add

```php
use Illuminate\Http\Request;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
```

4. Use laravel resource and resource collection - https://laravel.com/docs/10.x/eloquent-resources
   1. `sail artisan make:resource LessonResource`
   1. `sail artisan make:resource LessonCollection`
5. Add static Basic auth Middleware https://laravel.com/docs/10.x/middleware#introduction
    1. sail artisan make:middleware BasicAuthStatic
    2. See the created class in this project `app/Http/Middleware/BasicAuthStatic.php`
    3. Add middleware alias in `app/Http/Kernel.php`. Add this under `The application's middleware aliases.`: `'auth.basic.static' => BasicAuthStatic::class,`
    4. Use the middleware as
   ```php 
    Route::middleware('auth.basic.static')->prefix('v1')->group(function () {
      Route::resource('lessons', \App\Http\Controllers\LessonController::class, ['only' => ['store']]);
    });
   ```
    5. Add .env and .env.example values `SSO_USERNAME=` and `SSO_PASSWORD=`
    6. Register config values in `config/auth.php` as
   ```php 
     /*
      |--------------------------------------------------------------------------
      | Basic Auth Static
      |--------------------------------------------------------------------------
      |
      | Use static username and password from config
      |
      */
      'sso' => [
      'username' => env('SSO_USERNAME', 'laravel'),
      'password' => env('SSO_PASSWORD', 'password'),
      ]
   ```
6. Validating store requests
    1. Resources in files:
        1. LessonController@store
        2. app/Http/Requests/LessonPostRequest.php
    2. Resources tuts:
        1. https://laravel.com/docs/10.x/validation#form-request-validation
        2. https://blog.avenuecode.com/the-best-way-to-use-request-validation-in-laravel-rest-api
    3. Steps:
        1. Create a form request class `sail artisan make:request LessonPostRequest`
        2. Customize the class rules and add `failedValidation` method to return `json`
7. Pivot tables and seeding - lesson 008 - incremental-apis-8-seeding-reloaded
   1. Pivot tables tutorial https://ashutosh.dev/laralvel-10-pivots-secret-sauce-for-powerful-relationships/
   2. We need to create with artisan and add the relationships manually in the migration
   3. We used in this example `sail artisan make:migration create_lesson_tag_table` and `sail artisan make:seeder LessonTagSeeder`
8. Seeding error - `Cannot truncate a table referenced in a foreign key constraint`
   1. Fix: https://gist.github.com/isimmons/8202227 - add in the `DatabaseSeeder.php` 
      ```php
           Schema::disableForeignKeyConstraints();
           $this->call([
               LessonSeeder::class,
               TagSeeder::class,
               LessonTagSeeder::class
           ]);
           Schema::enableForeignKeyConstraints();
       ```
9. Subresources - 009 - incremental-api-part-8-tags-and-subresources
10. 010 - incremental-apis-10-readable-tests and lesson 11
    1. Create a new testing `Feature` or `Unit` folder.
    2. It is recommended to keep the seeding for one class only so we don't depend on seeder classes in other testing 
    classes. This means simply to see the data we need for that test class only. To achieve this we need to use the 
    `use Illuminate\Foundation\Testing\RefreshDatabase;` - see `tests/Feature/LessonsTest.php`. 
    Read more here: `https://laravel.com/docs/10.x/database-testing#resetting-the-database-after-each-test`
    3. If we don't refresh the database, we most probably need to run the migrations as when I run the test without the 
    `RefreshDatabase` trait, I got an error `SQLSTATE[42S02]: Base table or view not found: 1146 Table 'testing.lessons' doesn't exist `.
    4. See docs for testing
       1. Getting started - `https://laravel.com/docs/10.x/testing`
       2. Testing JSON APIs - `https://laravel.com/docs/10.x/http-tests#testing-json-apis`
    5. Maybe you need to setup some setup and tearDown methods
    6. See test example class for this lesson - `tests/Feature/LessonsTest.php`
    7. How to run tests: sail artisan test
    8. How to test one test class: sail artisan test --filter LessonsTest
11. Continue on lesson 11
      
