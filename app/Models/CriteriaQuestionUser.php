<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CriteriaQuestionUser extends Model
{
    use HasFactory;

    protected $fillable = ['user_id', 'question_id', 'criteria_id', 'points'];
    

    public function comments()
    {
        return $this->hasMany(Comment::class, 'question_id');
    }

}
