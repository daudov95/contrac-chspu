<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Curator extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'user_id'];

    public function tableQuestions(): HasMany
    {
        return $this->hasMany(TableQuestion::class);
    }

    public function user()
    {
        return $this->hasOne(User::class, 'id', 'user_id');
    }
}
