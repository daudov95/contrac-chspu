<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TableQuestionUser extends Model
{
    use HasFactory;

    protected $fillable = ['user_id', 'question_id', 'table_id', 'points'];
    

    public function comments()
    {
        return $this->hasMany(Comment::class, 'question_id');
    }
}
