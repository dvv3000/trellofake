<?php

namespace App\Http\Controllers;

use App\Enums\CardLabelEnum;
use App\Enums\CardStatusEnum;
use App\Models\Board;
use App\Models\Card;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Yajra\Datatables\Datatables;

class CardController extends Controller
{
    public function index()
    {
        return view ('dashboard');
    }

    public function getAll()
    {
        $c = Card::query()
        ->join('tasks', 'cards.task_id', 'tasks.id')
        ->where('cards.member_id', session()->get('id'))
        ->select('cards.*', 'tasks.board_id');


        $results = Board::query()
        ->joinSub($c, 'c', function($join) {
            $join->on('boards.id', 'c.board_id');
        })
        ->select('c.*')->selectRaw('boards.title as board_title')
        ->orderBy('c.label')
        ->get();

        // return $results;

        return DataTables::of($results)
        ->editColumn('label', function ($object){
            return CardLabelEnum::getKey($object->label);
        })
        ->editColumn('status', function ($object){
            return CardStatusEnum::getKey($object->status);
        })
        ->editColumn('created_at', function ($object){
            return $object->created_at->format('Y-m-d');
        })
        ->editColumn('updated_at', function ($object){
            return $object->created_at->format('Y-m-d');
        })
        ->editColumn('due_time', function ($object){
            return Carbon::parse($object->due_time)->format('Y-m-d');
        })
        ->make(true);
    }
}
