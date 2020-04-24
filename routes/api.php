<?php

use Illuminate\Http\Request;
use App\Http\Controllers;

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

Route::get('/pizzas', 'Pizza@list');
Route::get('/pizzas/{pizza}', 'Pizza@show');

Route::post('/cart', 'Cart@generate');
Route::get('/cart/{id}', 'Cart@get');
Route::delete('/cart/{cart}', 'Cart@get');
Route::post('/cart/{id}/checkout', 'Cart@checkout');
Route::post('/cart/{id}/items', 'Cart@add');
Route::patch('/cart/{id}/items/{item}', 'Cart@update');
Route::delete('/cart/{id}/items/{item}', 'Cart@remove');
