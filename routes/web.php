<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ProgramController;
use App\Http\Controllers\ProjectController;
use App\Http\Controllers\LibraryController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\BP206\BP206ProjectController;
use App\Http\Controllers\BP207\BP207ProjectController;


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





Route::controller(HomeController::class)->group(function () {
    Route::get('/home', [HomeController::class, 'index']);
    Route::get('/', [HomeController::class, 'index']);
    // Route::get('/update-password', [HomeController::class, 'pass']);
    Route::get('/balance', [HomeController::class, 'balance']);
    Route::get('/overview/{type}/{division}/{yr}', [HomeController::class, 'overview']);
});

// BP202
Route::controller(ProjectController::class)->group(function () {
    Route::get('/program', [ProjectController::class, 'index']);
    Route::get('/program/json', [ProjectController::class, 'json']);
    Route::post('/program/create', [ProjectController::class, 'create']);
});

// BP206
Route::controller(BP206ProjectController::class)->group(function () {
    Route::get('/bp206/project', [BP206ProjectController::class, 'index']);
    Route::get('/bp206/summary', [BP206ProjectController::class, 'summary']);
});

// BP207
Route::controller(BP207ProjectController::class)->group(function () {
    Route::get('/bp207/project', [BP207ProjectController::class, 'index']);
    Route::get('/bp207/summary', [BP207ProjectController::class, 'summary']);
});

Route::controller(ProjectController::class)->group(function () {
    Route::get('/project', [ProjectController::class, 'index']);
    Route::get('/project/new', [ProjectController::class, 'new']);
    Route::get('/project/json', [ProjectController::class, 'json']);
    Route::get('/project/jsonranking', [ProjectController::class, 'jsonranking']);
    Route::post('/project/create', [ProjectController::class, 'create']);
    Route::get('/project/edit/{id}', [ProjectController::class, 'edit']);
    Route::post('/project/update', [ProjectController::class, 'update']);
    Route::post('/project/delete', [ProjectController::class, 'delete']);
    Route::get('/project/print/{id}', [ProjectController::class, 'print']);
    Route::get('/project/priority', [ProjectController::class, 'priority']);
});

//LIBRARY
Route::controller(LibraryController::class)->group(function () {
    Route::get('/library/agency', [LibraryController::class, 'agency']);
    Route::get('/library/division', [LibraryController::class, 'division']);
    Route::get('/library/pap', [LibraryController::class, 'pap']);
    Route::get('/library/expense', [LibraryController::class, 'expense']);
    Route::get('/library/allotment', [LibraryController::class, 'allotment']);
    Route::get('/library/region', [LibraryController::class, 'region']);
});


// ADMIN
Route::controller(AdminController::class)->group(function () {
    Route::get('/bp202/summary', [AdminController::class, 'summary']);
    Route::post('/bp202/summary', [AdminController::class, 'summaryprint']);
    Route::get('/bp202/priority', [AdminController::class, 'priority']);
    Route::get('/bp202/agency', [AdminController::class, 'agency']);
    Route::post('/bp202/add-agency', [AdminController::class, 'agencyadd']);
    Route::post('/bp202/set-priority', [AdminController::class, 'updateranking']);
});


require __DIR__.'/auth.php';


