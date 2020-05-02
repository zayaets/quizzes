<?php

namespace App\Providers;

use App\Answer;
use App\Policies\AnswerPolicy;
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
//        Answer::class => AnswerPolicy::class,
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();

        $this->registerQuestionPolicies();
        $this->registerAnswerPolicies();
        $this->registerAdminPolicies();


        /*Gate::define('create-question', function ($user) {
            return $user->hasAcces();
        });

        Gate::define('update-question', function ($user, Question $question) {
            return false;
//            return $user->id === $question->user_id;
        });

        Gate::define('delete-question', function ($user, Question $question) {
            return false;
//            return $user->id === $question->user_id;
        });*/

        // don't allow to answer own questions

        /*Gate::define('can-answer', function($user, Question $question) {
            if ($user->id === $question->user_id) {
                return false;
            }
            return true;
        });*/


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

    public function registerQuestionPolicies()
    {
        Gate::define('answer', function ($user, Question $question) {
            return $user->id != $question->user_id;
        });
    }

    public function registerAnswerPolicies()
    {


        Gate::define('view-answers', function ($user, Question $question) {
//            return true;
            return auth()->id() === $user->id
                && $user->id === $question->user_id;
        });

        Gate::define('create-answers', function ($user, Question $question) {
//            return $user->hasAccess(['create-answers']);
            return $question->user_id === $user->id
                && $user->hasAccess(['create-answers'])
                && !$question->hasBeenAnswered();
        });

        Gate::define('edit-answers', function ($user, Answer $answer) {
            return $user->hasAccess(['edit-answers'])
                && $answer->question->user_id === $user->id
                && !$answer->answeredByAnyExists;
//            return $answer->question->user_id === auth()->id() && !$answer->answeredByAnyExists;
        });


        Gate::define('delete-answer', function ($user, Answer $answer) {
            return $user->hasAccess(['delete-answers'])
                && $answer->question->user_id === $user->id
                && !$answer->answeredByAnyExists;
//            return $answer->question->user_id === auth()->id() && !$answer->answeredByAnyExists;
        });


    }

    public function registerAdminPolicies()
    {
        Gate::define('isAdmin', function ($user) {
            return $user->inRole('admin');
        });
    }
}
