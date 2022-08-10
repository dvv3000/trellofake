<?php

namespace App\Http\Controllers;

use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {   
        return view('dashboard');
    }

    public function show()
    {   
        $user = User::find(session()->get('id'));
        return view('profile.index', [
            'user' => $user,
        ]);
    }



    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, User $user)
    {   

        $request->validate([
            'name' => ['bail', 'required', 'max:255'],
            'password' => ['required'],
            'avatar' => ['image', 'nullable'],
        ]);


        if($user->password !== md5($request->password)){
            return redirect()->route('profile', [
                'user' => $user->id,
            ])->with('alert', 'Wrong password!');
        }

        $image = $request->file('avatar');
        if($image){
            $path = $image->store('images');
            $user->avatar = $path;
            session()->put('avatar', $path);
        }
        $user->name = $request->name;            
        $user->save();
    
    
        session()->put('name', $request->name);
        

        return redirect()->route('profile', [
            'user' => $user->id,
        ])->with('alert', 'Your profile has been updated!');

    }

    public function notifications()
    {   
        return view('profile.notifications');
    }

    public function getNotifs() {
        $user = User::find(session()->get('id'));
        $notifications = $user->notifications->sortByDesc('created_at');
        
        $data = $notifications->map(function ($item, $key) {
            return collect([
                'id' => $item->id,
                'type' => $item->type,
                'notifiable_type' => $item->notifiable_type,
                'notifiable_id' => $item->notifiable_id,
                'data' => $item->data,
                'read_at' => $item->read_at,
                'created_at' => Carbon::parse($item->created_at)->format('H:i | Y-m-d'),
            ]);
        });

        return $data;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function destroy(User $user)
    {
        //
    }
}
