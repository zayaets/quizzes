<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Auth::routes(['register' => false]);

Route::get('/home', 'HomeController@index')->name('home');

Route::resource('questions', 'QuestionController')
//    ->names([])
    ->only(['index', 'create', 'store', 'show', 'edit', 'update', 'destroy']);

Route::resource('answers', 'AnswerController')
    ->only(['index', 'create', 'store', 'show', 'edit', 'update', 'destroy']);

Route::post('answers/answer', 'AnswerController@answerQuestion')
    ->name('answers.answer');

Route::resource('users', 'UserController');

Route::group(['prefix' => 'admin'], function() {
   Route::get('/', 'AdminController@index')
       ->name('admin.index');
    Route::get('questions', 'AdminController@questions')
        ->name('admin.questions');
    Route::get('users', 'AdminController@users')
        ->name('admin.users');
    Route::post('question/publish/{question}', 'AdminController@publish')
        ->name('question.publish');
    Route::post('question/unpublish/{question}', 'AdminController@unpublish')
        ->name('question.unpublish');
});

/*Route::group(['prefix' => 'users'], function () {
    Route::get('/');
});*/
// ->except(['edit', 'store']);

/*Route::group(['prefix' => 'questions'], function () {
    Route::get('/', 'QuestionController@index')
        ->name('list_questions');
    Route::get('/{id}', 'QuestionController@show')
        ->name('show_question');
});

Route::post('answer', 'HomeController@answerQuestion')
    ->name('answer_question');*/

/*Route::group(['prefix' => 'answers'], function () {
    Route::post('')
});*/

/*Route::group(['prefix' => 'users'], function () {
    Route::get('/', 'UserController@index')
        ->name('list_users');
});*/



/*Route::get('/fakertest', function () {
    $faker = Faker\Factory::create('fr_FR');
    $faker->seed(1234);
    $limit = 10;
    for ($i = 0; $i < $limit; $i++) {
        echo nl2br('Name: ' . $faker->firstNameFemale . ', Email Address: ' . $faker->unique()->email . ', Contact No: ' . $faker->phoneNumber . "\n");
    }
});*/
