<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\BookmarkController;
use App\Http\Controllers\ApiController;
use App\Http\Controllers\CountController;

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

// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });

Route::post('login', [ApiController::class, 'authenticate']);
Route::post('register', [ApiController::class, 'register']);
Route::get('countPlatform', [CountController::class, 'countPlatform']);

Route::group(['middleware' => ['jwt.verify']], function() {
    Route::get('logout', [ApiController::class, 'logout']);
    Route::get('get_user', [ApiController::class, 'get_user']);
    Route::get('bookmarks', [BookmarkController::class, 'index']);
    Route::get('bookmarks/{bookmark}', [BookmarkController::class, 'show']);
    Route::post('create', [BookmarkController::class, 'store']);
    Route::put('update/{bookmark}',  [BookmarkController::class, 'update']);
    Route::delete('delete/{bookmark}',  [BookmarkController::class, 'destroy']);  
});