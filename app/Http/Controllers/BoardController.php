<?php

namespace App\Http\Controllers;

use App\Enums\BoardUserRole;
use App\Models\Board;
use App\Models\User;
use App\Notifications\JoinBoard;
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
            ->orderBy('pivot_role')
            ->paginate(5);


        return view('boards.index', [
            'boards' => $boards,
            'search' => $search,
        ]);
    }


    public function show($boardId)
    {
        $data = Board::query()
        ->join('board_user', 'boards.id', '=', 'board_user.board_id')
        // ->join('users', 'users.id', '=', 'board_user.user_id')
        ->select('boards.*', 'board_user.role')
        // ->selectRaw( 'users.name as owner_name, users.avatar as owner_avatar')
        ->where('boards.id', $boardId)
        ->where('board_user.user_id', session()->get('id'))
        ->first();
        // $data = Board::find($boardId);
        $owner = $data->users->firstWhere('pivot.role', 0);
        return view('boards.board', [
            'board' => $data,
            'owner' => $owner,
        ]);
    }

    public function create(Request $request)
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
        return redirect()->route('board.index');
    }

    public function quit(Board $board)
    {   
        $board->users()->detach(session()->get('id'));
        $board->cards()->where('member_id', session()->get('id'))->delete();
        return redirect()->route('board.index');
    }

    public function addMember(Request $request, $boardId)
    {
        try {
            $request->validate([
                'email' => ['bail', 'required', 'max:255'],
            ]);
            $user = User::where('email', $request->get('email'))->firstOrFail();

            DB::table('board_user')->insert([
                'board_id' => $boardId,
                'user_id' => $user->id,
                'role' => BoardUserRole::MEMBER,
            ]);

            $board = Board::find($boardId);
            $user->notify(new JoinBoard($board));
            $request->session()->flash('message', $user->email . ' is added successfully!');
            return back();
        } 
        catch (Throwable $e) {
            $request->session()->flash('message', 'There are some errors!');
            return back();
        }
    }

    public function getAllMembers(Board $board)
    {
        return $board->users;
    }
}
