<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MemeController;
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

/*Route::get('/', function () {
    return view('welcome');
});*/
Route::get('/', [MemeController::class, 'index']);
Route::post('/upload', [MemeController::class, 'upload']);
Route::post('/save-meme', [MemeController::class, 'saveMeme']);
Route::get('/meme/{filename}', [MemeController::class, 'viewMeme']);
Route::get('/memes/download/{filename}', [MemeController::class, 'download'])->name('memes.download');

