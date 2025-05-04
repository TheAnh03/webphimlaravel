<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\IndexController;
use App\Http\Controllers\HomeController;
//admin controller
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\GenreController;
use App\Http\Controllers\CountryController;
use App\Http\Controllers\MovieController;
use App\Http\Controllers\LeechMovieController;
use App\Http\Controllers\ServerController;
use App\Http\Controllers\EpisodeController;
use App\Http\Controllers\DecorationController;
use App\Http\Controllers\LoginGoogleController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\UserProfileController;
use App\Http\Controllers\RatingController;
use App\Http\Controllers\ViewController;
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\AdminController;





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
// route public
Route::middleware(['trackVisitor'])->group(function () {

    Route::get('/', [IndexController::class, 'home'])->name('homepage');
    Route::get('/danh-muc/{slug}', [IndexController::class, 'category'])->name('category');
    Route::get('/the-loai/{slug}', [IndexController::class, 'genre'])->name('genre');
    Route::get('/quoc-gia/{slug}', [IndexController::class, 'country'])->name('country');
    Route::get('/phim/{slug}', [IndexController::class, 'movie'])->name('movie');
    Route::get('/xem-phim/{slug}/ep-{ep}/ser-{server}', [IndexController::class, 'watch'])->name('watch');
    Route::get('/nam/{year}', [IndexController::class, 'year'])->name('year');
    Route::get('/tags/{tag}', [IndexController::class, 'tag'])->name('tag');
    Route::get('/search', [IndexController::class, 'search'])->name('search');
    Route::get('/filter', [IndexController::class, 'filter'])->name('filter');
});
// route user 
Route::middleware(['auth', 'verified.logout'])->group(function () {
    Route::post('/userprofile_update', [UserProfileController::class, 'update_userprofile'])->name('update_profile');
    Route::post('/rating', [RatingController::class, 'store'])->name('rating.store');
    Route::delete('/comment/{id}', [RatingController::class, 'destroy'])->name('comment.destroy');
    Route::get('/history', [UserController::class, 'watchHistory'])->name('user.history');
    Route::delete('/history/{id}', [ViewController::class, 'destroy'])->name('history.destroy');
    Route::delete('/history/clear', [ViewController::class, 'clearHistory'])->name('history.clear');

    Route::get('/notification/read/{id}', [NotificationController::class, 'read'])->name('notification.read');
    Route::post('/notification/clear', [NotificationController::class, 'clear'])->name('notification.clear');



});

Route::get('/userprofile', [UserProfileController::class, 'show_userprofile'])->name('show_profile');
Route::get('/userfavoritelist', [UserController::class, 'get_favoritelist'])->name('favoritelist');
Route::delete('/deletefavoritelist/{movie}', [UserController::class, 'removeFavorite'])->name('removeFavorite');
Route::post('/addfavoritelist/{movieId}', [UserController::class, 'addToFavorite'])->name('addToFavorite');
// login by gg
Route::get('auth/google', [LoginGoogleController::class, 'redirectToGoogle'])->name('login.google');
Route::get('auth/google/callback', [LoginGoogleController::class, 'handleGoogleCallback']);



Auth::routes();
Auth::routes(['verify' => true]);

//admin route

Route::group(['middleware' => ['auth', 'role:admin']], function () {

    Route::get('/home', [HomeController::class, 'index'])->name('home');
    Route::resource('decoration', DecorationController::class);
    Route::resource('category', CategoryController::class);
    Route::resource('genre', GenreController::class);
    Route::resource('country', CountryController::class);
    Route::resource('movie', MovieController::class);
    Route::resource('server', ServerController::class);
    Route::resource('episode', EpisodeController::class);
    Route::resource('user', UserController::class);
    // ajax
    Route::post('get_movie_detail',[MovieController::class,'get_movie_detail'])->name('get_movie_detail'); 
    Route::post('get_episodes_detail',[EpisodeController::class,'get_episodes_detail'])->name('get_episodes_detail'); 

    // resort
    Route::post('resorting_category', [CategoryController::class, 'resorting'])->name('resorting_category');
    Route::post('resorting_genre', [GenreController::class, 'resorting'])->name('resorting_genre');
    Route::post('resorting_country', [CountryController::class, 'resorting'])->name('resorting_country');

    //episode
    Route::get('manage-episodes/{id}', [EpisodeController::class, 'manageEpisodes'])->name('manage-episodes');
    Route::get('/episode/create/{id}', [EpisodeController::class, 'createWithMovie'])->name('episode-create-withmovie');
    Route::post('/episodes/store_list', [EpisodeController::class, 'list_episodes_store'])->name('list_episodes_store');
    Route::get('/episodes/check', [EpisodeController::class, 'getEpisodesByMovieAndServer'])->name('episodes-check');
    Route::get('/episodes/delete-all/{movie_id}', [EpisodeController::class, 'deleteAll'])->name('episodes.deleteAll');

    Route::get('/get-episodes', [EpisodeController::class, 'getEpisodes'])->name('get-episodes');

    // profile
    Route::get('/profile', [UserProfileController::class, 'show'])->middleware('auth');
    Route::get('/stats', [AdminController::class, 'index'])->name('admin.stats');
    // leechmovie
    Route::get('/leechmovie',[LeechMovieController::class,'index'] )->name('leech-movie');
    Route::post('/get_leech_detail',[LeechMovieController::class,'show'] )->name('get_leech_detail');
    Route::post('/import_leech_movie/{slug}',[LeechMovieController::class,'import'] )->name('import_leech_movie');
    Route::get('/get_list_import',[LeechMovieController::class,'list_import'] )->name('get_list_import');
    Route::get('/leech_episodes/{slug}',[LeechMovieController::class,'leech_episodes'] )->name('leech_episodes');
    Route::post('/leech/episode/store', [LeechMovieController::class, 'storeLeechEpisodes'])->name('episode_leech_store');
   



});

