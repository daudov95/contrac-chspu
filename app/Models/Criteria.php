<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Criteria extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'short_name', 'semester_id'];

    public function questions()
    {
        return $this->hasMany(CriteriaQuestion::class)->with(['curator', 'questionUser', 'documents']);
    }
    
    public function semester()
    {
        return $this->hasOne(Semester::class, 'id', 'semester_id');
    }

    public function users()
    {
        return $this->hasMany(SemesterUser::class, 'criteria_id', 'id');
    }
}
