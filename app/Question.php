<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Kyslik\ColumnSortable\Sortable;

class Question extends Model
{

    use SoftDeletes;
    use Sortable;

    protected $fillable = [
        'title', 'text', 'published'
    ];

    protected $casts = [
        'published' => 'boolean',
    ];


    public $sortable = [
        'id', 'title', 'text', 'user_id', 'created_at', 'updated_at',
    ];
    public function owner()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    public function answers()
    {
        return $this->hasMany(Answer::class);
    }

    /**
     * what Status the Question has
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function status()
    {
        return $this->belongsTo(Status::class, 'status_id', 'id');
    }

    /**
     * only own Questions
     *
     * @param $query
     * @return mixed
     */
    public function scopeOwnQuestions($query)
    {
        return $query->where('user_id', auth()->id());
    }

    /**
     * Other User's Questions that are displaying for current User
     *
     * @param $query
     * @return mixed
     */
    public function scopeOthersQuestions($query)
    {
        $status = Status::where('slug', 'published')->first();

        return $query->where([
            ['user_id', '!=', auth()->id()],
            ['status_id', $status->id]
            ]);
    }


    /**
     * what Statuses the Question can be changed to
     *
     * @return mixed
     */
    public function availableStatuses()
    {
        $statuses = Status::where('id', '!=', $this->status_id)->get();
        return $statuses;
    }

/*    public function scopePublished($query)
    {
        // todo statuses
        return $query->where('published', 1);
    }*/


    /*public function getPublishedAttribute()
    {
        return $this->published;
    }*/

    /**
     * if Question has Answers
     *
     * @return bool
     */
    public function getAnswersExistAttribute()
    {
        return $this->answers()->exists();
    }

    /**
     * for User - checks if Question is valid/suitable for publishing
     * if it has:
     * 0) at least 2 Answers
     * 1) at least one Answer is correct
     *
     * @return bool
     */
    public function isValid()
    {
        // count Answers
        $answers_count = $this->loadCount('answers')->answers_count; //

        $answers = $this->answers->map(function ($answer) {
            if ($answer->is_correct === true) {
                return [
                    'is_correct' => 1
                ];
            }
        });

        $has_correct = 0;

        foreach ($answers as $answer) {
            if ($answer['is_correct'] === 1) {
                $has_correct = 1;
                break;
            }
        }

        return ($answers_count >= 2) && $has_correct;

    }

    /**
     * Checks if User has answered the Question
     *
     * @return bool
     */
    public function getAnsweredAttribute()
    {
        $answers = $this->answers->map(function ($answer) {
            if ($answer->answeredByExists) {
                return [
//                'id' => $answer->id,
                    'answered' => $answer->answeredByExists,
                ];
            }
        });

        foreach ($answers as $answer) {
            if ($answer['answered'] === true) {
                return true;
            }
        }
        return false;
    }

    /**
     * if the Question has been answered correct
     *
     * @return bool
     */
    public function getAnsweredCorrectAttribute()
    {
        $answers = $this->answers->map(function ($answer) {
            return [
//                'id' => $answer->id,
                'correct' => $answer->answeredCorrect,
            ];
        });

        foreach ($answers as $answer) {
            if (!$answer['correct']) {
                return false;
            }
        }
        return true;
    }

    /**
     * Question at least once has been answered by someone and cannot be edited or deleted
     *
     * @return bool
     */
    public function hasBeenAnswered()
    {
        $answers = $this->answers->map(function($answer) {
            if  ($answer->answeredBy()->exists()) {
                return [
                    'answeredBy' => true,
                ];
            }
        });

        foreach ($answers as $answer) {
            if ($answer['answeredBy']) {
                return true;
            }
        }

        return false;
    }

}
