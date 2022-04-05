<?php

use Illuminate\Support\Facades\Route;
use App\Models\Category;
use App\Models\User;
use App\Models\Post;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ArticleController;
use App\Http\Controllers\FormController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\PostController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

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

Route::get('/', function () {
    return view('welcome');
});

Route::get('/formulir', [FormController::class, 'form']);
Route::post('/proses', [FormController::class, 'proses']);

Route::get("/article", [ArticleController::class, 'index']);

Route::get('/article/{article:slug}', [ArticleController::class, 'content']);

Route::get('/categories', function(){
    return view('article.categories', [
        'title' => 'Categories',
        'categories' => Category::all()
    ]);
});

Route::get('/categories/{category:slug}', function(Category $category){
    return view('article.article',[
        'title' => "Article By Category : $category->name",
        'articles' => $category->articles,
        'name' => $category->name
    ]);
});

Route::get('/authors/{author:username}', function(User $author){
    return view('article.article',[
        'title' => 'Article by Author',
        'name' => $author->name,
        'articles' => $author->articles,
    ]);
});
require __DIR__.'/auth.php';

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', [AuthController::class, 'retrieve']) 
    ->middleware(['auth'])->name('dashboard');

Route::get('/check', [AuthController::class, 'check'])->name('check');

// HTTP AUTHENTICATION
Route::get('/profile', function() {
    return view('profile');
})->middleware('auth.basic')->name('profile');

Route::get('/article', [ArticleController::class, 'index']) 
    ->middleware(['auth'])->name('article');

Route::get('/settings', function(){
    return view('settings');
})->middleware(['password.confirm'])->name('settings');

// password confirmation form
Route::get('/confirm-password', function () {
    return view('auth.confirm-password');
})->middleware('auth')->name('password.confirm');

Route::get('/private', [HomeController::class, 'private'])->name('private');
Route::get('/response', [HomeController::class, 'response'])->name('response');

Route::get('/post', [PostController::class, 'index']);
Route::get('/post/create', [PostController::class, 'create']);
Route::get('/post/edit/{id}', [PostController::class, 'edit']);

Route::get('/post/delete/{post}', [PostController::class, 'destroy'])->middleware('can:delete,post');