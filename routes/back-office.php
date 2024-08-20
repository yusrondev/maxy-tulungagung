<?php

use App\Http\Controllers\RoleController;
use App\Http\Controllers\RoomController;
use App\Http\Controllers\UserController;

Route::group(['middleware' => ['permission:room-list']], function(){
    Route::get('/room', [RoomController::class, 'index']);
    Route::get('/room/pending-chat/{id}', [RoomController::class, 'pendingchat']);
    Route::get('/room/approve-chat/{id}', [RoomController::class, 'approvechat']);
    Route::delete('/room/delete-chat/{id}', [RoomController::class, 'deletechat'])->name('chat.destroy');

    Route::group(['middleware' => ['permission:room-create']], function(){
        Route::post('/room/store', [RoomController::class, 'store']);
    });

    Route::group(['middleware' => ['permission:room-delete']], function(){
        Route::post('/room/delete/{id}', [RoomController::class, 'delete']);
    });

    Route::post('/room/reply-chat', [RoomController::class, 'replychat']);

    Route::group(['middleware' => ['permission:room-edit']], function(){
        Route::post('/room/{id}', [RoomController::class, 'update']);
    });

});

// user management
Route::resource('roles', RoleController::class);
Route::resource('users', UserController::class);
