<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ImageController;

Route::get('/',[ImageController::class,'index']);
Route::get('/showimages',[ImageController::class,'showimages']);
Route::post('/upload',[ImageController::class,'store']);
