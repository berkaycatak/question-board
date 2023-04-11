<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Event extends Model
{
    use HasFactory;
    protected $table = 'events';

    public function creator_user()
    {
        return $this->hasOne(User::class, "id", "created_user_id");
    }

    public function questions()
    {
        return $this->hasMany(Question::class, "event_id", "id");
    }

}
