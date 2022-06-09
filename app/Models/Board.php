<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Board extends Model
{
    use HasFactory;
    protected $fillable = ['title', 'description'];

    public function users()
    {
        return $this->belongsToMany(User::class)->withPivot('role');
    }

    public function tasks()
    {
        return $this->hasMany(Task::class);
    }

    // public function getRoleNameAttribute()
    // {
    //     return $this->pivot->role ? 'Owner' : 'Member';
    // }

    public function cards()
    {
        return $this->hasManyThrough(Card::class, Task::class);
    }

}
