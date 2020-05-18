<?php

namespace App\Providers;

use App\Answer;
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

    private $allowed_statuses = [
        'draft', 'rejected',
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
    }

    public function registerQuestionPolicies()
    {

        // User can view one Question if he is an owner, because there are right Answers displayed
        Gate::define('view-dashboard-question', function ($user, Question $question) {
            return $user->id === $question->user_id;
        });

        Gate::define('publish', function ($user, Question $question) {
            return $user->id === $question->user_id
                && $question->isValid()
                && in_array($question->status->slug, $this->allowed_statuses);
        });

        Gate::define('unpublish', function ($user, Question $question) {
            return $user->id === $question->user_id
                && $question->status->slug === 'published';
        });

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
                && !$question->hasBeenAnswered()
                && in_array($question->status->slug, $this->allowed_statuses);
        });

        Gate::define('update-answers', function ($user, Question $question, Answer $answer) {
            return $user->hasAccess(['update-answers'])
                && $answer->question->user_id === $user->id
                && !$answer->answeredByAnyExists
                && $question->id === $answer->question_id
                && in_array($question->status->slug, $this->allowed_statuses);
        });


        Gate::define('delete-answer', function ($user, Question $question, Answer $answer) {
            return $user->hasAccess(['delete-answers'])
                && $answer->question->user_id === $user->id
                && !$answer->answeredByAnyExists
                && $question->id === $answer->question_id
                && in_array($question->status->slug, $this->allowed_statuses);
        });


    }

    public function registerAdminPolicies()
    {
        Gate::define('isAdmin', function ($user) {
            return $user->inRole('admin');
        });
    }
}
