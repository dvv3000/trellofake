<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Throwable;

class AuthController extends Controller
{
    public function signin()
    {
        return view('auth/signin');
    }

    public function signup()
    {
        return view('auth/signup');
    }

    public function signingIn(Request $request)
    {   
        $request->validate([
            'email' => [
                'bail',
                'required',
                // 'email:rfc',
            ],
            'password' => ['required'],
        ]);

        // $password = Hash::make($request->get('password'));
        // dd($password, $request->get('password'));
        try{
            $user = User::query()
            ->where('email', $request->get('email'))
            ->where('password', md5($request->get('password')))
            ->firstOrFail();

            session()->put('id', $user->id);
            session()->put('name', $user->name);
            session()->put('avatar', $user->avatar);

            
            return redirect()->route('dashboard');
        }
        catch(Throwable $e){
            return back()->with('error','Email or password is incorrect!');
        }
        
    }

    public function signingUp(Request $request)
    {   
        $request->validate([
            'email' => [
                'bail',
                'required',
                // 'email:rfc',
                'unique:users',
            ],
            'name' => ['required'],
            'password' => ['required'],
        ]);

        $user = User::create([
            'name' => $request->get('name'),
            'email' => $request->get('email'),
            'password' => md5($request->get('password')),
        ]);
        session()->put('id', $user->id);
        session()->put('name', $user->name);
        session()->put('avatar', $user->avatar);

        return redirect()->route('dashboard');
        
    }

    public function signout() 
    {
        session()->flush();


        return redirect()->route('signin');
    }
}
