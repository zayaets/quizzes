<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Answer extends Model
{

    use SoftDeletes;

    protected $fillable = [
        'text', 'is_correct',
    ];

    protected $casts = [
        'is_correct' => 'boolean'
    ];

    /**
     * the Question that the Answer is belongs to
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function question()
    {
        return $this->belongsTo(Question::class);
    }

    /**
     * All Users that have chosen this Answer
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function answeredBy()
    {
        return $this->belongsToMany(User::class, 'answer_user', 'answer_id', 'user_id')->withTimestamps();
//            ->withPivot(['user_id', 'answer_id', 'answered', 'created_at', 'updated_at']);
    }

    /**
     * Check if current user has chosen the Answer
     *
     * @return bool
     */
    public function getAnsweredByExistsAttribute()
    {
        // very important to check if answered by logged in user

        return $this->answeredBy()->where('id', auth()->id())->exists();
    }

    /**
     * if Answer has been at least once chosen by anyone at all
     *
     * @return bool
     */
    public function getAnsweredByAnyExistsAttribute()
    {
        return $this->answeredBy()->exists();
    }

    /**
     * If User has chosen the Answer which is correct
     *
     * @return bool
     */
    public function getAnsweredCorrectAttribute()
    {
//        return gettype($this->is_correct);
//        return gettype($this->answeredByExists);
//        return $this->answeredByExists; // is boolean
//        return $this->is_correct; // without cast is integer

        return $this->is_correct === $this->answeredByExists;
    }


    /**
     * To show where User made a mistake
     *
     * 0 - wrong
     * 1 - Answer is correct by itself
     * 2 - unanswered
     * @return mixed
     */
    public function getAnsweredValueAttribute()
    {
//        return $this->answeredByExists;
//        return $this->is_correct;


        // answer is correct
//        if ($this->is_correct === true && $this->is_correct === $this->answeredByExists) {
        if ($this->is_correct === true) {
            return 1;
            // answer is incorrect and user didn't check
        } elseif ($this->is_correct != $this->answeredByExists) {
            return 0;
        }
        return 2;
    }

}
