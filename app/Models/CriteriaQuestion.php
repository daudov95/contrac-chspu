<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Facades\Auth;

use function PHPUnit\Framework\matches;

class CriteriaQuestion extends Model
{
    use HasFactory;

    protected $fillable = ['text', 'options', 'curator_id', 'type', 'order', 'criteria_id'];

    public function curator(): BelongsTo
    {
        return $this->belongsTo(Curator::class)->withDefault();
    }

    public function criteria(): BelongsTo
    {
        return $this->belongsTo(Criteria::class);
    }

    public function questionUser()
    {
        return $this->hasMany(CriteriaQuestionUser::class, 'question_id', 'id');
    }

    public function getPointsAttribute()
    {
        return $this->questionUser->points ?? "-";
    }


    public function documents()
    {
        return $this->hasMany(UserDocument::class, 'question_id', 'id');
    }

    public function getTypeLabelAttribute()
    {
        $label = match ($this->type) {
            '1' => 'Научно-исследовательская и инновационная деятельность',
            '2' => 'Образовательная деятельность',
            '3' => 'Организационно-воспитательная и иная деятельность',
        };

        return $label;
    }


}
