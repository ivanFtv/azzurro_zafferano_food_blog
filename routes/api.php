<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::get('/recipes/cat/{category}', [App\Http\Controllers\RecipeApiController::class, 'getByCat']);
Route::get('/recipes/suggested/{key}', [App\Http\Controllers\RecipeApiController::class, 'getSuggested']);
Route::get('/recipes/all', [App\Http\Controllers\RecipeApiController::class, 'getAllRecipes']);
Route::delete('/delete/recipe/{id}', [App\Http\Controllers\RecipeApiController::class, 'destroy']);
Route::post('/recipes/create', [App\Http\Controllers\RecipeApiController::class, 'store']);
Route::put('/recipes/edit/{id}', [App\Http\Controllers\RecipeApiController::class, 'update']);
Route::resource('recipes', App\Http\Controllers\RecipeApiController::class);


Route::post('/rates/new', [App\Http\Controllers\RateApiController::class, 'handleRates']);
Route::get('/rates/{user_id}/{recipe_id}', [App\Http\Controllers\RateApiController::class, 'getRatesByUser']);
Route::get('/rates/{recipe_id}', [App\Http\Controllers\RateApiController::class, 'index']);
Route::get('/rate/avg/{recipe_id}', [App\Http\Controllers\RateApiController::class, 'getRecipeAverageRates']);
Route::get('/lasts/rates', [App\Http\Controllers\RateApiController::class, 'getLastsRates']);
Route::get('/allrates/all', [App\Http\Controllers\RateApiController::class, 'getAllRates']);
Route::delete('/rates/del/{id}', [App\Http\Controllers\RateApiController::class, 'destroy']);


Route::resource('favorites', App\Http\Controllers\FavoriteApiController::class);
Route::get('/favorites/user/{user_id}', [App\Http\Controllers\FavoriteApiController::class, 'getByUser']);
Route::post('/favorites', [App\Http\Controllers\FavoriteApiController::class, 'handleFavorites']);


Route::get('/user/fav/{id}', [App\Http\Controllers\UserApiController::class, 'getFavorites']);
Route::get('/user/comments/{id}', [App\Http\Controllers\UserApiController::class, 'getComments']);
Route::get('/user/{id}', [App\Http\Controllers\UserApiController::class, 'getUserName']);
Route::get('/users/lasts', [App\Http\Controllers\UserApiController::class, 'getLastsUsers']);
Route::delete('/delete/user/{id}', [App\Http\Controllers\UserApiController::class, 'destroy']);
Route::post('/users/updateAvatar/{id}', [App\Http\Controllers\UserApiController::class, 'updateAvatar']);
Route::resource('users', App\Http\Controllers\UserApiController::class);