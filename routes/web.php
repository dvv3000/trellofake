<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\BoardController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CardController;
use App\Http\Controllers\UserController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/
Route::get('/signin', [AuthController::class, 'signin'])->name('signin');
Route::post('/signin', [AuthController::class, 'signingIn'])->name('signingIn');


Route::get('/signup', [AuthController::class, 'signup'])->name('signup');
Route::post('/signup', [AuthController::class, 'signingUp'])->name('signingUp');

Route::get('/signout', [AuthController::class, 'signout'])->name('signout');


Route::group([
    'middleware' => 'isSignedIn',
], function() {
    Route::get('/', [CardController::class, 'index'])->name('dashboard');
    Route::get('/api/cards', [CardController::class, 'getAll'])->name('card.api.getAll');
    
    Route::get('/notifications', function () {
        return view('profile.notifications');
    })->name('notifications');
    
    # Profile
    Route::get('/profile/{user}', [UserController::class, 'show'])->name('profile');
    Route::put('/profile/update/{user}', [UserController::class, 'update'])->name('profile.update');
    
    

    
    
    Route::group(['prefix' => 'boards', 'as' => 'board.'], function () {
        Route::get('/', [BoardController::class, 'index'])->name('index');
        Route::get('/{board}', [BoardController::class, 'show'])->name('show');
        Route::post('/create', [BoardController::class, 'store'])->name('store');
        Route::delete('/delete/{board}', [BoardController::class, 'delete'])->name('delete');
        Route::put('/update/{board}', [BoardController::class, 'update'])->name('update');
        Route::post('/{board}/add-member', [BoardController::class, 'addMember'])->name('addMember');
    });

    
});


