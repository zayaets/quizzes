<?php

namespace App\Providers;

use App\Policies\QuestionPolicy;
use App\Question;
use App\User;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        // 'App\Model' => 'App\Policies\ModelPolicy',
        Question::class => QuestionPolicy::class,
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();

        // don't allow to answer own questions

        Gate::define('can-answer', function($user, Question $question) {
            if ($user->id === $question->user_id) {
                return false;
            }
            return true;
        });


        // allow edit only own questions
        /*
        Gate::define('can-edit', function($user, Question $question) {
//            $answers = $question->answers;

            if ($user->id === $question->user_id ) {
                return true;
            }
            return false;
        });
        */


        // if question belongs to the current user
        /*
        Gate::define('can-create-answers', function ($user, Question $question) {
            if ($user->id === $question->user_id) {
                return true;
            }
            return false;
        });
        */


    }
}
