<?php

use App\Http\Controllers\BlogsController;
use App\Http\Controllers\CityController;
use App\Http\Controllers\CountryController;
use App\Http\Controllers\StateController;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

Route::get('/', function () {
    return Inertia::render('auth.login');
});

Route::get('dashboard', function () {
    return Inertia::render('blogs');
})->middleware(['auth', 'verified'])->name('blogs');

// Task 2 :
// Create a RESTful API for a Blog

// Implement API Rate Limiting

// ]Add API Token Authentication


// Build CRUD API with Eloquent Relationships 

// Paginate API Responses

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


// Task 1:

Route::resource('countries', CountryController::class);
Route::resource('states', StateController::class);
Route::resource('cities', CityController::class);



require __DIR__.'/settings.php';
require __DIR__.'/auth.php';
