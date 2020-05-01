<?php

namespace App;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Kyslik\ColumnSortable\Sortable;

class User extends Authenticatable
{
    use Notifiable;
    use Sortable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];



    public $sortable = [
        'name',
    ];

    public function questions()
    {
        return $this->hasMany(Question::class);
    }


    public function roles()
    {
        return $this->belongsToMany(Role::class, 'role_user', 'user_id', 'role_id');
    }

    /**
     * This method will return all answered Answers
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function answeredAnswers()
    {
        return $this->belongsToMany(Answer::class, 'answer_user', 'user_id', 'answer_id')
            ->withTimestamps();
//            ->withPivot(['user_id', 'answer_id', 'answered', 'created_at', 'updated_at']);
    }


    public function hasAccess(array $permissions) : bool
    {
        foreach ($this->roles as $role) {
            if ($role->hasAccess($permissions)) {
                return true;
            }
        }
        return false;
    }

    public function inRole(string $roleSlug)
    {
        return $this->roles()->where('slug', $roleSlug)->count() == 1;
    }


    public function hello()
    {
        return "hello $this->name";
    }

    public function isAdmin()
    {
        return true;
    }


    /**
     * get asnwered question's ids
     *
     * @param $query
     * @return array
     */
    /*public function scopeAnsweredQuestions($query)
    {
        $user = $query->with('answered')->where('id', auth()->id())->first();

        $answered_questions = [];

        if (isset($user)) {
            foreach ($user->answered as $answer) {
//            echo $answer->answeredBy;
                $id = $answer->question_id;
                if (!in_array($id, $answered_questions)) {
                    $answered_questions[] = $id;
                }
            }
        }

        return $answered_questions;
    }*/


    /**
     * get what user answered
     *
     * @param $query
     * @return array
     */
    /*public function scopeAnsweredData($query)
    {
        $question_ids = User::answeredQuestions();

        $userAnswered = $query->with('answered')->where('id', auth()->id())->first();

        $questions = [];

        foreach ($question_ids as $id) {
            foreach ($userAnswered->answered as $answer) {
                if ($id === $answer->question_id) {
                    $questions[$id][$answer->id] = $answer->pivot->answered;
                }
            }
        }

        return $questions;
    }*/

}
