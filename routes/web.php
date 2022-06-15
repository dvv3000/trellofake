<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\BoardController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CardController;
use App\Http\Controllers\LabelController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\TaskController;

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

    // Dashboard
    Route::get('/', [CardController::class, 'index'])->name('dashboard');
    Route::get('cards/api/get-all', [CardController::class, 'getAll'])->name('card.api.getAll');
    

    // Notification
    Route::get('/notifications', function () {
        return view('profile.notifications');
    })->name('notifications');
    
    # Profile
    Route::get('/profile', [UserController::class, 'show'])->name('profile');
    Route::put('/profile/update/{user}', [UserController::class, 'update'])->name('profile.update');
    
    // Board
    Route::group(['prefix' => 'boards', 'as' => 'board.'], function () {
        Route::get('/', [BoardController::class, 'index'])->name('index');
        Route::get('/{board}', [BoardController::class, 'show'])->name('show');
        Route::post('/create', [BoardController::class, 'create'])->name('create');
        Route::delete('/delete/{board}', [BoardController::class, 'delete'])->name('delete');
        Route::put('/update/{board}', [BoardController::class, 'update'])->name('update');
        Route::post('/{board}/add-member', [BoardController::class, 'addMember'])->name('addMember');
        Route::delete('/quit/{board}', [BoardController::class, 'quit'])->name('quit');
        Route::get('/{board}/get-members', [BoardController::class, 'getAllMembers'])->name('getAllMembers');
    });

    // Task
    Route::group(['prefix' => 'tasks', 'as' => 'task.'], function () {
        Route::post('/{board}/create', [TaskController::class, 'create'])->name('create');
        Route::delete('/delete/{task}', [TaskController::class, 'delete'])->name('delete');
        Route::put('/update/{task}', [TaskController::class, 'update'])->name('update');
        Route::get('/api/show/{task}', [TaskController::class, 'show'])->name('api.show');
    });

    // Card
    Route::group(['prefix' => 'cards', 'as' => 'card.'], function () {
        Route::get('/{card}', [CardController::class, 'show'])->name('show');
        Route::post('/create/{task}', [CardController::class, 'create'])->name('create');

        Route::post('/{card}', [CardController::class, 'update'])->name('update');
        Route::delete('/delete/{card}', [CardController::class, 'delete'])->name('delete');
        Route::get('/set-status/{card}', [CardController::class, 'setStatus'])->name('setStatus');
        
    });

    // Label
    Route::get('/labels/get-all', [LabelController::class, 'getAll'])->name('label.getAll');
    
});


