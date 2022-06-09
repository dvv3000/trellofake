<?php

namespace App\Http\Controllers;

use App\Enums\BoardUserRole;
use App\Models\Board;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Throwable;

class BoardController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->get('q');
        $user = User::find(session()->get('id'));
        $boards = $user->boards()
            ->where('title', 'like', '%' . $search . '%')
            ->orderBy('created_at')
            ->paginate(5);


        return view('boards.index', [
            'boards' => $boards,
            'search' => $search,
        ]);
    }


    public function show(Request $request,  $boardId)
    {

        // $board = Board::query()
        //     ->join('board_user', 'boards.id', 'board_user.board_id')
        //     ->where('boards.id', $boardId)
        //     ->where('board_user.user_id', session()->get('id'))
        //     ->select('boards.*', 'board_user.role')
        //     ->first();

        $user = User::find(session()->get('id'));
        $board = $user->boards->filter(function ($item) use ($boardId) {
            return $item->id == $boardId;
        })->first();

        return $board->tasks()->first()->cards;
        return view('boards.board', [
            'board' => $board,
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => ['bail', 'required', 'max:255']
        ]);
        $user = User::find(session()->get('id'));

        $user->boards()->create([
            'title' => $request->get('title'),
            'description' => $request->get('description'),
        ], ['role' => BoardUserRole::OWNER]);



        return back()->with('success', 'You have created a new board, check it out!');
    }

    public function update(Request $request, Board $board)
    {
        $request->validate([
            'title' => ['bail', 'required', 'max:255']
        ]);

        $board->update([
            'title' => $request->get('title'),
            'description' => $request->get('description'),
        ]);

        return back();
    }

    public function delete(Board $board)
    {
        $board->delete();
        // return $board;
        return redirect()->route('board.index');
    }

    public function addMember(Request $request, $boardId)
    {
        $request->validate([
            'email' => ['bail', 'required', 'max:255'],
        ]);
        
        try {
            $user = User::where('email', $request->get('email'))->firstOrFail();

            DB::table('board_user')->insert([
                'board_id' => $boardId,
                'user_id' => $user->id,
                'role' => BoardUserRole::MEMBER,
            ]);
            $request->session()->flash('message', $user->email . 'is added successfully!');
            return back();
        } 
        catch (Throwable $e) {
            $request->session()->flash('message', 'There are some errors!');
            return back();
        }
    }
}
