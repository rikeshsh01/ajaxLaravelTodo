<?php

use App\Http\Controllers\ListController;
use Illuminate\Support\Facades\Route;

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

Route::get('/list',[ListController::class,'index']);

Route::post('/add',[ListController::class,'create'])->name('addItem');
Route::post('/delete',[ListController::class,'delete'])->name('delete');
Route::post('/update',[ListController::class,'update'])->name('update');
Route::get('/search',[ListController::class,'search'])->name('search');