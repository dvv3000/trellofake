<?php

namespace App\Http\Controllers;


use App\Enums\CardStatusEnum;
use App\Models\Board;
use App\Models\Card;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Throwable;
use Yajra\Datatables\Datatables;

class CardController extends Controller
{
    public function index()
    {
        return view ('dashboard');
    }

    
    public function create(Request $request, $taskId)
    {
        $request->validate([
            'title' => ['bail', 'required', 'max:255'],
        ]);

        Card::create([
            'title' => $request->get('title'),
            'description' => $request->get('description'),
            'task_id' => $taskId,
            'due_time' => $request->get('due-time'),
            'label_id' => $request->get('label-id'),
            'member_id' => $request->get('member-id'),
        ]);
        $request->session()->flash('message', 'New card is created successfully!');
        return back();
    }

    public function update(Request $request, Card $card) 
    {
        try {
            $request->validate([
                'title' => ['bail', 'required', 'max:255'],
            ]);
            $card->update([
                'title' => $request->get('title'),
                'description' => $request->get('description'),
                'due_time' => $request->get('due-time'),
                'label_id' => $request->get('label-id'),
                'member_id' => $request->get('member-id'),
            ]);


            $request->session()->flash('message', 'Card is updated successfully!');
            return back();
        }
        catch(Throwable $e){
            $request->session()->flash('message', 'There are some errors!');
            return back();
        }
    }

    public function delete(Card $card) 
    {
        $card->delete();
        session()->flash('message', 'Card deleted successfully!');
        return back();
    }


    
    public function show(Card $card) 
    {
        return $card;
    }

    public function getAll()
    {
        $c = Card::query()
        ->join('tasks', 'cards.task_id', 'tasks.id')
        ->where('cards.member_id', session()->get('id'))
        ->join('labels', 'cards.label_id', 'labels.id')
        ->select('cards.*', 'tasks.board_id')
        ->selectRaw('labels.color as label_color, labels.name as label_name');

        $data = Board::query()
        ->joinSub($c, 'c', function($join) {
            $join->on('boards.id', '=', 'c.board_id');
        })
        ->select('c.*')
        ->selectRaw('boards.title as board_title')
        ->get();


        return DataTables::of($data)
        ->editColumn('status', function ($object){
            return CardStatusEnum::getKey($object->status);
        })
        ->editColumn('label', function ($object){
            return $object->label_name;
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

    public function setStatus(Card $card) 
    {
        $status = $card->status ? 0 : 1;

        $card->update([
            'status' => $status,
        ]);
        
        return $status;
    }
}
