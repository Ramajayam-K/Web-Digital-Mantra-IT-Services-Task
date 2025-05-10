<?php

use App\Http\Controllers\BlogsController;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

Route::get('/', function () {
    return Inertia::render('Welcome');
})->name('home');

Route::get('dashboard', function () {
    return Inertia::render('Dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

// Task 1 : Create a RESTful API for a Blog

// Task 2 : Implement API Rate Limiting
Route::middleware(['auth.sanctum'])->group(function(){
    Route::controller(BlogsController::class)->group(function(){
        Route::post('/showPostsComments','showPostsComments')->name('showPostsComments')->middleware('throttle:200,1');
        Route::middleware('throttle:blogs')->group(function(){
            Route::get('/blogs','index')->name('blogs');
            Route::post('/createPost','createPost')->name('createPost');
            Route::post('/createComments','createComments')->name('createComments');
            Route::put('/updatePost','updatePost')->name('updatePost');
            Route::put('/updateComments','index')->name('updateComments');
            Route::delete('/deletePost','deletePost')->name('deletePost');
            Route::delete('/deleteComments','deleteComments')->name('deleteComments'); 
        }); 
    });
});


require __DIR__.'/settings.php';
require __DIR__.'/auth.php';
