<?php

namespace App;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Carbon;
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
     * This method will return ONLY answered Answers
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function answeredAnswers()
    {
        return $this->belongsToMany(Answer::class, 'answer_user', 'user_id', 'answer_id')
            ->withTimestamps();
//            ->withPivot(['user_id', 'answer_id', 'answered', 'created_at', 'updated_at']);
    }


    public function hasAccess($permissions)
    {
        foreach ($this->roles as $role) {
            if ($role->hasAccess($permissions)) {
                return true;
            }
        }
        return false;
    }

    public function inRole($roleSlug)
    {
        return $this->roles()->where('slug', $roleSlug)->count() == 1;
    }

    /**
     *
     * STATISTICS FOR CURRENT USER
     *
     */

    public function stat(array $params = [])
    {
        foreach ($params as $param) {
            $method = 'stat' . $param;
            if (method_exists($this, $method)) {
                 return $this->$method();
            }
        }
    }

    /**
     * How many Questions has User created and published
     *
     * @return int
     */
    private function statCreatedQuestions() : int
    {
        return Question::with(['status' => function ($q) {
            $q->where('slug', 'published');
        }])->where('user_id', auth()->id())
            ->count();
    }

    /**
     * Count Question answered by User
     *
     * @return int
     */
    private function statAnsweredQuestions() : int
    {
        $questions = Question::othersQuestions()->get();
        $count_answered = 0;
        foreach ($questions as $question) {
            if ($question->answered) {
                $count_answered++;
            }
        }

        return $count_answered;
    }

    /**
     * New Users for today
     *
     * @return int
     */
    private function statTodayNewUsers() : int
    {
        return $this->whereDate('created_at', Carbon::today())->count();
    }

    /**
     * New Users for last week
     *
     * @return int
     */
    private function statLastWeekNewUsers() : int
    {
        return $this->whereDate('created_at', '>', Carbon::now()->subWeek())->count();
    }

    /**
     * New Users for last month
     *
     * @return int
     */
    private function statLastMonthNewUsers() : int
    {
        return $this->whereDate('created_at', '>', Carbon::now()->subMonth())->count();
    }

    /**
     *
     * COMMON STATISTICS
     *
     */

    /**
     * Total published Questions
     *
     * @return int
     */
    private function statTotalQuestions() : int
    {
        $status = Status::where('slug', 'published')->first();
        return Question::where('status_id', $status->id)->count();
    }

    /**
     * Count all of the Users of the app
     *
     * @return int
     */
    private function statCountUsers() : int
    {
        return $this->all()->count();
    }

}
