<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Kyslik\ColumnSortable\Sortable;

class Question extends Model
{

    use Sortable;

    protected $fillable = [
        'text', 'published'
    ];

    protected $casts = [
        'published' => 'boolean',
    ];


    public $sortable = [
        'id', 'text', 'user_id', 'created_at', 'updated_at',
    ];
    public function owner()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    public function answers()
    {
        return $this->hasMany(Answer::class);
    }

    public function scopeOwnQuestions($query)
    {
        return $query->where('user_id', auth()->id());
    }

    public function scopeOthersQuestions($query)
    {
        return $query->where('user_id', '!=', auth()->id());
    }

    public function scopePublished($query)
    {
        return $query->where('published', 1);
    }


    /*public function getPublishedAttribute()
    {
        return $this->published;
    }*/

    public function getAnswersExistAttribute()
    {
        return $this->answers()->exists();
    }

    public function getHasAnswersAttribute()
    {
        $answers_count = $this->loadCount('answers')->answers_count;

        $answers = $this->answers->map(function ($answer) {
            if ($answer->is_right === true) {
                return [
                    'is_right' => 1
                ];
            }
        });

        $has_right = 0;

        foreach ($answers as $answer) {
            if ($answer['is_right'] === 1) {
                $has_right = 1;
                break;
            }
        }

//        return $has_right;

        return ($answers_count >= 2) && $has_right;

    }

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

    public function getBeenAnsweredAttribute()
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

/*    public function scopeAnswered($query, $q_id)
    {
        $question = $query->where('id', $q_id);

        $answered = [];
        foreach ($question->answers as $answer) {
            $answered[$answer->id] = $answer->answeredByExists($answer->id);
        }

        return $answered;
    }*/





    /**
     * if one of the answers is wrong the whole question is incorrect
     *
     * 0 - wrong
     * 1 - correct
     * 2 - unanswered
     *
     * @param $query
     * @param $question_id
     * @return mixed
     */
    /*public function scopeIsCorrect($query, $question_id)
    {
        $answers = $query->find($question_id)->answers;

        if (count($answers)) {
            foreach ($answers as $answer) {
                if (0 === Answer::isCorrect($answer->id)) {
//                    echo 'wrong';
//                    break;
                    return 0;
                }
            }
            return 1;
        }
        return 2;
    }*/
}
