<?php

use App\Http\Controllers\Auth\AuthController;
use App\Livewire\About;
use App\Livewire\Auth\Login;
use App\Livewire\Auth\Register;
use App\Livewire\Homepage;
use App\Livewire\Movies\DiscoverMovies;
use App\Livewire\Movies\MovieDetails;
use App\Livewire\Movies\MoviesByType;
use App\Livewire\Movies\SearchMovies;
use App\Livewire\UserWatchlist;
use Illuminate\Support\Facades\Route;

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

Route::get('/', Homepage::class)->name('home');
Route::prefix('movies')->name('movies.')->group(function () {
    Route::get('search', SearchMovies::class)->name('search');
    Route::get('discover', DiscoverMovies::class)->name('discover');
    Route::get('type/{type}', MoviesByType::class)->name('by-type');
    Route::get('{movie_id}', MovieDetails::class)->name('details')->where('movie_id', '[0-9]+');
});
Route::get('about', About::class)->name('about');

Route::middleware('auth')->get('watchlist', UserWatchlist::class)->name('user.watchlist');

Route::post('logout', [AuthController::class, 'logout'])->name('logout');

Route::middleware('guest')->group(function () {
    Route::get('login', Login::class)->name('login');
    Route::get('register', Register::class)->name('register');
});
