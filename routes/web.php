<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ModuleController;

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

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');


// returns the home page with all modules
Route::get('/modules', ModuleController::class .'@index')->name('modules.index');
// returns the form for adding a Module
Route::get('/modules/create', ModuleController::class . '@create')->name('modules.create');
// adds a Module to the database
Route::Post('/modules', ModuleController::class .'@store')->name('modules.store');
// returns a page that shows a full Module
Route::get('/modules/{Module}', ModuleController::class .'@show')->name('modules.show');
// returns the form for editing a Module
Route::get('/modules/{Module}/edit', ModuleController::class .'@edit')->name('modules.edit');
// updates a Module
Route::put('/modules/{module}', [ModuleController::class, 'update'])->name('modules.update');
// deletes a Module
Route::delete('/modules/{id}', ModuleController::class .'@destroy')->name('modules.destroy');
// history a Module
Route::get('/modules/{module}/history', [ModuleController::class, 'showHistory'])->name('modules.history');

