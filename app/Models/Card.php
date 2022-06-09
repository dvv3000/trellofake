<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Card extends Model
{
    use HasFactory;

    public function task()
    {
        return $this->belongsTo(Task::class);
    }

    // public function getDateTimeAttribute()
    // {
    //     return $this->created_at->format('Y-m-d');
    // }

    public function member()
    {
        return $this->belongsTo(User::class);
    }
}
