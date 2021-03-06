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

Route::get("/login/{correo}/{contrasena}",'AuthController@login');
Route::get("/refresh","AuthController@refresh_token");
Route::get("/logout",'AuthController@logout');

Route::post("/new",'AuthController@new');

Route::put("/me",'AuthController@me_update');
Route::delete("/me",'AuthController@me_del');