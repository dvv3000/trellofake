<?php

namespace App\Models;

use App\Enums\CardLabelEnum;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Card extends Model
{
    use HasFactory;
    protected $fillable = ['title', 'description', 'label_id','task_id', 'member_id', 'due_time', 'status'];

    public function task()
    {
        return $this->belongsTo(Task::class);
    }


    public function member()
    {
        return $this->belongsTo(User::class);
    }
    
    public function label()
    {
        return $this->belongsTo(Label::class);
    }

    public function getLabelNameAttribute() 
    {
        return CardLabelEnum::getKey($this->label);
    }

    public function getDueTimeAttribute($value)
    {
        return Carbon::parse($value)->format('Y-m-d');
    }
}
