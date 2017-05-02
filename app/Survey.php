<?php

namespace App;
use Carbon\Carbon;

use Illuminate\Database\Eloquent\Model;

class Survey extends Model
{
    protected $fillable = [
        'name',
        'description'
    ];

    /**
     * A Survey is comprised of questions
     */
    public function questions()
    {
        return $this->hasMany('App\Question');
    }

    /**
     * Submissions are aggregated answers
     */
    public function submissions()
    {
        return $this->hasMany('App\Submission');
    }

    /**
     * Mutate to show as diff for humans
     */
    public function getCreatedAtAttribute($value)
    {
        return $this->attributes['created_at'] = Carbon::parse($value)->diffForHumans();
    }

}
