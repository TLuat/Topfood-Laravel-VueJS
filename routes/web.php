<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\TestController;
use App\Http\Controllers\WeatherController;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\RatingController;
use App\Http\Controllers\ReservationController;
use App\Http\Controllers\ToppingController;
use App\Http\Controllers\TableController;
use App\Http\Controllers\MenuController;
use App\Http\Controllers\SuccessController;
use App\Http\Controllers\ChatController;
use App\Http\Controllers\TestChatController;

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
    return Inertia::render('index', [
        'canLogin' => Route::has('login'),
        'canRegister' => Route::has('register'),
        'laravelVersion' => Application::VERSION,
        'phpVersion' => PHP_VERSION,
    ]);
});
Route::match(['get', 'post'], '/botman', 'BotManController@handle');

Route::resource('product', ProductController::class)->middleware(['auth', 'verified']);
Route::resource('category', CategoryController::class)->middleware(['auth', 'verified']);
Route::resource('cart', CartController::class)->middleware(['auth', 'verified']);
Route::resource('order', OrderController::class)->middleware(['auth', 'verified']);
Route::resource('admin', AdminController::class)->middleware(['auth', 'verified']);
Route::resource('comment', CommentController::class)->middleware(['auth', 'verified']);
Route::resource('rating', RatingController::class)->middleware(['auth', 'verified']);
Route::resource('reservation', ReservationController::class)->middleware(['auth', 'verified']);
Route::resource('topping', ToppingController::class)->middleware(['auth', 'verified']);
Route::resource('table', TableController::class)->middleware(['auth', 'verified']);
Route::resource('menu', MenuController::class)->middleware(['auth', 'verified']);
Route::resource('weather', WeatherController::class);
Route::resource('chat', TestChatController::class);
Route::resource('successpayment', SuccessController::class);
Route::resource('test', TestController::class);
Route::post('/api/chat', [ChatController::class, 'sendMessage']);
// Route::get('product/{id}', [ProductController::class, 'show'])->middleware(['auth', 'verified']);
// Route::get('/cart', [ProductController::class, 'index'])->name('index');
// Route::resource('/', ProductControlleRoute::delete('users/{id}', function ($id) {
// }););


Route::get('/dashboard', function () {
    return Inertia::render('Dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');



Route::get('payment', function () {
    return Inertia::render('Payment');});

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
