<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class User extends Model
{
    use HasFactory;

    public $timestamps = false;

    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    protected $hidden = ['password'];

    public function boards()
    {
        return $this->belongsToMany(Board::class)->withPivot('role');
    }

    public function cards()
    {
        return $this->hasMany(Board::class)->withPivot('role');
    }


}
