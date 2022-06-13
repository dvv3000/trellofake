<?php

namespace App\Http\Controllers;

use App\Models\Board;
use App\Models\Task;
use Illuminate\Http\Request;
use Throwable;

class TaskController extends Controller
{
    public function update(Request $request, Task $task)
    {   
        try{
            $request->validate([
                'title' => ['bail', 'required', 'max:255'],
            ]);
            $task->update([
                'title' => $request->get('title'),
                'description' => $request->get('description'),
            ]);
            $request->session()->flash('message', 'Task is updated successfully!');
            return back();
        } 
        catch(Throwable $e){
            $request->session()->flash('message', 'There are some errors!');
            return back();
        }

    }

    public function show(Task $task)
    {
        return $task;
    }

    public function create(Request $request, Board $board) 
    {
        try{
            
            $request->validate([
                'title' => ['bail', 'required', 'max:255'],
            ]);

            $board->tasks()->create([
                'title' => $request->get('title'),
                'description' => $request->get('description'),
            ]);
            // dd($request->get('description'));
            $request->session()->flash('message', 'Task is created successfully!');
            return back();
        } 
        catch(Throwable $e){
            $request->session()->flash('message', 'There are some errors!');
            return back();
        }
    }
    public function delete(Task $task) 
    {   
        $task->delete();
        session()->flash('message', 'Task is created successfully!');
        return back();
    }

}
