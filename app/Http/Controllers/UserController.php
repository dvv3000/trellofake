<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

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

    public function show(User $user)
    {
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

            // $user->update([
            //     'name' => $request->name,
            //     'avatar' => $path,
            // ]);
            $user->name = $request->name;
            $user->avatar = $path;
            $user->save();


            session()->put('name', $request->name);
            session()->put('avatar', $path);

            return redirect()->route('profile', [
                'user' => $user->id,
            ])->with('alert', 'Your profile has been updated!');
        }
        
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
