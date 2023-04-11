<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Vote extends Model
{
    use HasFactory;
    protected $table = 'votes';

    public function user()
    {
        return $this->hasOne(User::class, "id", "user_id");
    }

    public function event()
    {
        return $this->hasOne(Event::class, "id", "event_id");
    }

    public function question()
    {
        return $this->hasOne(Question::class, "id", "question_id");
    }

}
