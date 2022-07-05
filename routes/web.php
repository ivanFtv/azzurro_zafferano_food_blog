<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;



Route::get('/', function () {
    return view('welcome');
})->name('welcome');

Route::middleware('auth')->get('/dash/{vue_capture?}', function () {
    return view('dashboard');
    })->where('vue_capture', '[\/\w\.-]*')->name('profile');


Route::middleware('admin')->get('/admin/{vue_capture?}', function () {
    return view('admin.index');
    })->where('vue_capture', '[\/\w\.-]*')->name('admin');


Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::resource('recipes', App\Http\Controllers\RecipeController::class);
Route::get('/recipes/filter/{key}', [App\Http\Controllers\RecipeController::class, 'getByFilter'])->name('showByFilter');
Route::get('/recipes/search/{key}', [App\Http\Controllers\RecipeController::class, 'getBySearch'])->name('getBySearch');

Route::get('auth/facebook', [App\Http\Controllers\SocialController::class, 'redirectFacebook']);
Route::get('auth/facebook/callback', [App\Http\Controllers\SocialController::class, 'callbackFacebook']);


