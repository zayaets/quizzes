<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Answer extends Model
{
    protected $fillable = [
        'text', 'question_id', 'is_correct'
    ];

    protected $casts = [
        'is_correct' => 'boolean'
    ];

    public function question()
    {
        return $this->belongsTo(Question::class);
    }

    public function answeredBy()
    {
        return $this->belongsToMany(User::class, 'answer_user', 'answer_id', 'user_id')->withTimestamps();
//            ->withPivot(['user_id', 'answer_id', 'answered', 'created_at', 'updated_at']);
    }


    public function getAnsweredByExistsAttribute()
    {
        // very important to check if answered by logged in user

        return $this->answeredBy()->where('id', auth()->id())->exists();
    }

    /**
     * if Question has been once answered by someone
     *
     * @return bool
     */
    public function getAnsweredByAnyExistsAttribute()
    {
        return $this->answeredBy()->exists();
    }

    public function getAnsweredCorrectAttribute()
    {
//        return gettype($this->is_correct);
//        return gettype($this->answeredByExists);
//        return $this->answeredByExists; // is boolean
//        return $this->is_correct; // without cast is integer

        return $this->is_correct === $this->answeredByExists;
    }


    /**
     * 0 - wrong
     * 1 - right
     * 2 - unanswered
     * @return mixed
     */
    public function getAnsweredValueAttribute()
    {
//        return $this->answeredByExists;
//        return $this->is_correct;


        // answer is correct and user checked
        if ($this->is_correct === true && $this->is_correct === $this->answeredByExists) {
            return 1;
            // answer is incorrect and user didn't check
        } elseif ($this->is_correct != $this->answeredByExists) {
            return 0;
        }
        return 2;
    }

    /*public function scopeAnsweredByExists($query, $a_id)
    {
        $answer = $query->where('id', $a_id);
        return $answer->answeredBy()->exists();
    }*/

    /*public function scopeAnsweredCorrect($query)
    {
        $answer = $query->where('');
    }*/







    /**
     * 0 - wrong
     * 1 - right
     * 2 - unanswered
     *
     * @param $query
     * @param $answer_id
     * @return int
     */
    /*public function scopeIsCorrect($query, $answer_id)
    {

        $answer = $query->with(['answeredBy' => function ($q) {
            $q->where('user_id', auth()->id())->get();
        }])->where('id', $answer_id)->first();

        $answeredValue = isset($answer->answeredBy[0]->pivot->answered)
            ? $answer->answeredBy[0]->pivot->answered
            : null;

        if (!is_null($answeredValue)) {
            if ($answeredValue === $answer->is_correct) {
                return 1;
            } else {
                return 0;
            }
        }

        return 2;

    }*/

}
