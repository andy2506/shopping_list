<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\ShoppingListController;
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

// Route::get('/', function () {
//     return view('welcome');
// });

Route::controller(ShoppingListController::class)->group(function () {
    Route::get('/', 'index');
    Route::post('/add-item', 'create');
    Route::post('/remove-item', 'delete');
    Route::post('/task-done', 'done');
    Route::post('/update-item', 'update');
});