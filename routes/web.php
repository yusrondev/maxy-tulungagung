<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\CMSController;
use App\Http\Controllers\FrontendController;
use App\Http\Controllers\RoomController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect('dashboard');
});

Route::get('/enter-name', [RoomController::class, 'enterName']);
Route::post('/set-name', [RoomController::class, 'setName']);
Route::get('/chat_room', [RoomController::class, 'ChatRoom']);
Route::post('/broadcast', [RoomController::class, 'broadcast']);
Route::post('/receive', [RoomController::class, 'receive']);

// chat
Route::post('/api/send-msg', [FrontendController::class, 'sendmsg']);
Route::post('/api/get-msg', [FrontendController::class, 'getmsg']);

// cms & chat_contents data
Route::get('/api/get-cms', [FrontendController::class, 'getcms']);

// room chat
Route::get('/room/chat/{code}', [RoomController::class, 'roomchat']);

//upload photo
Route::post('/api/send-file', [FrontendController::class, 'sendFile']);

// Route::get('/dashboard', function () {
//     return view('dashboard');
// })->middleware(['auth', 'verified'])->name('dashboard');

Route::group(['middleware' => ['auth']], function() {
    // dashboard
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    //setting
    Route::get('/settings', [CMSController::class, 'setting'])->name('settings');
    Route::get('/api/users', [CMSController::class, 'getUsers']);
    Route::post('/api/add', [CMSController::class, 'store']);
    Route::put('/api/editUser/{id}', [CMSController::class, 'updateUser']);
    Route::delete('/api/deleteUser/{id}', [CMSController::class, 'destroy']);

    //profile
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    //back office
    include __DIR__.'/back-office.php';
});

Route::group(['middleware' => ['permission:cms-list']], function(){
    // cms
    Route::get('/cms', [CMSController::class, 'index'])->name('cms');
    Route::group(['middleware' => ['permission:cms-update']], function(){
        Route::put('/cms/{id}', [CMSController::class, 'update'])->name('cms.update');
        Route::delete('/cms/{id}/image', [CMSController::class, 'image_destroy'])->name('cms.destroyImage');
    });
    Route::put('/cms/chat_content/{id}', [CMSController::class, 'chatContent_update'])->name('chat_content.update');
});

require __DIR__.'/auth.php';
