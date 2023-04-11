<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Question extends Model
{
    use HasFactory;
    protected $table = 'questions';

    public function user()
    {
        return $this->hasOne(User::class, "id", "created_user_id");
    }

    public function event()
    {
        return $this->hasOne(Event::class, "id", "event_id");
    }

    public function votes()
    {
        return $this->hasMany(Vote::class, "question_id", "id");
    }

    public function votesCount()
    {
        return $this->hasMany(Vote::class, "question_id", "id")->count();
    }

}
