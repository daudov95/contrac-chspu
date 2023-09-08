<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SemesterUser extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'user_id', 'semester_id', 'table_id', 'rank'];


    public function questions()
    {
        return $this->hasMany(TableQuestion::class, 'table_id', 'table_id');
    }

    public function documents()
    {
        return $this->hasMany(UserDocument::class, 'user_id', 'id');
    }

    public function table()
    {
        return $this->hasOne(Table::class, 'id', 'table_id');
    }
}
