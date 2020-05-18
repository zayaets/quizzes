<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Status extends Model
{

    public function questions()
    {
        return $this->hasMany(Question::class, 'status_id', 'id');
    }

    public function scopeStatusBySlug($query, $slug)
    {
        return $query->where('slug', $slug)->first();
    }
}
