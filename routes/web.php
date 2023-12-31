<?php

use App\Http\Controllers\BookCreateController;
use App\Http\Controllers\BookEditController;
use App\Http\Controllers\BookPutController;
use App\Http\Controllers\BookStoreController;
use App\Http\Controllers\FeedIndexController;
use App\Http\Controllers\FriendDestroyController;
use App\Http\Controllers\FriendIndexController;
use App\Http\Controllers\FriendPatchController;
use App\Http\Controllers\FriendStoreController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\RegisterIndexController;
use Illuminate\Support\Facades\Route;

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

Route::get('/', HomeController::class);

Route::get('/auth/register', RegisterIndexController::class);
Route::get('/auth/login', LoginController::class);

Route::post('/books', BookStoreController::class);
Route::get('/books/create', BookCreateController::class);
Route::get('/books/{book}/edit', BookEditController::class);
Route::put('/books/{book}', BookPutController::class);

Route::get('/friends', FriendIndexController::class);
Route::post('/friends', FriendStoreController::class);
Route::patch('/friends/{friend}', FriendPatchController::class);
Route::delete('/friends/{friend}', FriendDestroyController::class);

Route::get('/feed', FeedIndexController::class);
