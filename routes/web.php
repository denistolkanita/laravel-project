<?php

use App\Http\Controllers\AboutController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\MainController;
use App\Http\Controllers\Post\CreateController;
use App\Http\Controllers\Post\DestroyController;
use App\Http\Controllers\Post\EditController;
use App\Http\Controllers\Post\IndexController;
use App\Http\Controllers\Post\ShowController;
use App\Http\Controllers\Post\StoreController;
use App\Http\Controllers\Post\UpdateController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\Post\IndexController as AdminIndexController;
use App\Http\Controllers\Admin\Post\CreateController as AdminCreateController;
use App\Http\Controllers\Admin\Post\StoreController as AdminStoreController;
use App\Http\Controllers\Admin\Post\ShowController as AdminShowController;
use App\Http\Controllers\Admin\Post\DestroyController as AdminDestroyController;
use App\Http\Controllers\Admin\Post\EditController as AdminEditController;
use App\Http\Controllers\Admin\Post\UpdateController as AdminUpdateController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});


Route::get('/auth', [HomeController::class, 'index'])->name('home');

Route::group(['namespace' => 'Post'], function () {
    Route::get('/posts', [IndexController::class, '__invoke'])->name('post.index');
    Route::get('/posts/create', [CreateController::class, '__invoke'])->name('post.create');
    Route::post('/posts/create', [StoreController::class, '__invoke'])->name('post.store');
    Route::get('/posts/{post}', [ShowController::class, '__invoke'])->name('post.show');
    Route::get('/posts/{post}/edit', [EditController::class, '__invoke'])->name('post.edit');
    Route::patch('/posts/{post}', [UpdateController::class, '__invoke'])->name('post.update');
    Route::delete('/posts/{post}', [DestroyController::class, '__invoke'])->name('post.delete');
});

Route::group(['namespace' => 'App\Http\Controllers\Admin', 'prefix' => 'admin', 'middleware' => 'admin'],
    function () {
        Route::group(['namespace' => 'Post'], function () {
            Route::get('/post', [AdminIndexController::class, '__invoke'])->name('admin.post.index');
            Route::get('/post/create', [AdminCreateController::class, '__invoke'])->name('admin.post.create');
            Route::post('/post/create', [AdminStoreController::class, '__invoke'])->name('admin.post.store');
            Route::get('/post/{post}', [AdminShowController::class, '__invoke'])->name('admin.post.show');
            Route::delete('/post/{post}', [AdminDestroyController::class, '__invoke'])
                ->name('admin.post.delete');
            Route::get('/post/{post}/edit', [AdminEditController::class, '__invoke'])->name('admin.post.edit');
            Route::patch('/post/{post}', [AdminUpdateController::class, '__invoke'])->name('admin.post.update');
        });
    }
);


Route::get('/contact', [ContactController::class, 'index'])->name('contact.index');
Route::get('/about', [AboutController::class, 'index'])->name('about.index');
Route::get('/main', [MainController::class, 'index'])->name('main.index');

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
