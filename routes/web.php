<?php

use Illuminate\Support\Facades\Route;
use Laravel\Socialite\Facades\Socialite;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

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

Route::get('/google-auth/redirect', function () {
    return Socialite::driver('google')->redirect();
});

Route::get('/google-auth/callback', function () {
    $user_obtenido = Socialite::driver('google')->stateless()->user();

    $user = User::updateOrCreate([
        'google_id' => $user_obtenido->id,
    ], [
        'name' => $user_obtenido->name,
        'email' => $user_obtenido->email
    ]);

    Auth::login($user);

    return redirect('/dashboard');
});

Route::get('/facebook-auth/redirect', function () {
    return Socialite::driver('facebook')->redirect();
});

Route::get('/facebook-auth/callback', function () {
    $user_obtenido = Socialite::driver('facebook')->stateless()->user();

    $user = User::updateOrCreate([
        'facebook_id' => $user_obtenido->id,
    ], [
        'name' => $user_obtenido->name,
        'email' => $user_obtenido->email
    ]);

    Auth::login($user);

    return redirect('/dashboard');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth'])->name('dashboard');

require __DIR__ . '/auth.php';
