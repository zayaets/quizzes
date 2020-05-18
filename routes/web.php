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

//Auth::routes(['register' => false]);
Auth::routes();

/**
 * User account
 */

Route::get('/home', 'HomeController@index')->name('home');

Route::group(['prefix' => 'user', 'middleware' => ['auth']], function () {
    Route::get('questions', 'HomeController@questions')
        ->name('user.questions');
    Route::get('question/{question}', 'HomeController@question')
        ->name('user.question');
});

/**
 * Question
 */

Route::resource('questions', 'QuestionController')
//    ->names([])
    ->only(['index', 'create', 'store', 'show', 'edit', 'update', 'destroy']);

Route::post('questions/publish/{question} ', 'QuestionController@publish')
    ->name('questions.publish');
Route::post('questions/unpublish/{question} ', 'QuestionController@unpublish')
    ->name('questions.unpublish');

/**
 * Answer
 */

Route::resource('answers', 'AnswerController')
    ->only(['index', 'create', 'store', 'show', 'edit', 'update', 'destroy']);

Route::post('answers/answer', 'AnswerController@answerQuestion')
    ->name('answers.answer');


/**
 * Users
 */
Route::resource('users', 'UserController');

/**
 * Admin
 */

Route::group(['prefix' => 'admin', 'middleware' => ['auth']], function() {
    Route::get('/', 'AdminController@index')
       ->name('admin.index');
    Route::get('questions', 'AdminController@questions')
        ->name('admin.questions');
    Route::get('question/{question}', 'AdminController@question')
        ->name('admin.question');
    Route::get('users', 'AdminController@users')
        ->name('admin.users');
    Route::post('question/status', 'AdminController@status')
        ->name('admin.question.status');
/*    Route::post('question/publish/{question}', 'AdminController@publish')
        ->name('question.publish');
    Route::post('question/unpublish/{question}', 'AdminController@unpublish')
        ->name('question.unpublish');*/
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
