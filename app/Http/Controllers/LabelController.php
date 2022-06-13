<?php

namespace App\Http\Controllers;

use App\Models\Label;
use Illuminate\Http\Request;

class LabelController extends Controller
{
    public function getAll() 
    {
        $labels = Label::all();
        return $labels;
    }
}
