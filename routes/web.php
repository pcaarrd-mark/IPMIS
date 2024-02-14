<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ProgramController;
use App\Http\Controllers\ProjectController;
use App\Http\Controllers\LibraryController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\BP206\BP206ProjectController;
use App\Http\Controllers\BP207\BP207ProjectController;
use App\Http\Controllers\OSEP\OSEPProjectController;
use App\Http\Controllers\OSEP\OSEPPrintController;
use App\Http\Controllers\OSEP\OSEPProgramController;
use App\Http\Controllers\OSEP\OSEPLibController;
use App\Http\Controllers\OSEP\AdminOSEPController;
use App\Http\Controllers\OSEP\AdminAccountController;
use App\Http\Controllers\OSEP\CommentController;
use App\Http\Controllers\OSEP\OSEPProjectByDivisionController;
use App\Http\Controllers\OSEP\WorkplanController;
use App\Http\Controllers\PrinterController;



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
    Route::get('/test-password', [HomeController::class, 'pass']);
    Route::get('/balance', [HomeController::class, 'balance']);
    Route::get('/overview/{type}/{division}/{yr}', [HomeController::class, 'overview']);

    Route::get('/test', [HomeController::class, 'test']);
});

Route::controller(AdminOSEPController::class)->group(function () {
    Route::post('/osep/project/single-send-to-dpmis', [AdminOSEPController::class, 'singleSendToDPMIS']);
    Route::post('/osep/project/batch-send-to-dpmis', [AdminOSEPController::class, 'batchSendToDPMIS']);
    Route::post('/osep/project/batch-accept-from-dpmis', [AdminOSEPController::class, 'batchAcceptFromDPMIS']);
    Route::get('/osep/proposals', [AdminOSEPController::class, 'proposals']);
    Route::get('/osep/projects', [AdminOSEPController::class, 'index']);
    Route::post('/osep/proposals', [AdminOSEPController::class, 'proposal']);
    Route::post('/osep/admin-update-status', [AdminOSEPController::class, 'adminUpdateStatus']);
    Route::post('/osep/project/add-division', [AdminOSEPController::class, 'assignDivision']);
    Route::get('/osep/dpmis', [AdminOSEPController::class, 'dpmis']);
});

Route::controller(AdminAccountController::class)->group(function () {
    Route::get('/settings/account', [AdminAccountController::class, 'index']);
    Route::get('/settings/account/json', [AdminAccountController::class, 'json']);
});

Route::controller(OSEPProjectByDivisionController::class)->group(function () {
    Route::get('/project/division', [OSEPProjectByDivisionController::class, 'index']);
    Route::get('/project/division/json', [OSEPProjectByDivisionController::class, 'json']);
    Route::get('/program/division/json', [OSEPProjectByDivisionController::class, 'jsonprogram']);
});

// OSEP
Route::controller(OSEPProjectController::class)->group(function () {
    Route::get('/osep/dashboard', [OSEPProjectController::class, 'dashboard']);
    Route::get('/osep/project', [OSEPProjectController::class, 'index']);
    //Route::get('/osep/project/add', [OSEPProjectController::class, 'add']);
    Route::get('/osep/project/add/{form}/{programid}', [OSEPProjectController::class, 'add']);
    Route::get('/osep/project-list/{id}', [OSEPProjectController::class, 'index2']);
    Route::get('/osep/proposal/json', [OSEPProjectController::class, 'json']);
    Route::get('/osep/proposal-by-division/json', [OSEPProjectController::class, 'json4']);
    Route::get('/osep/project/json2/{progid}', [OSEPProjectController::class, 'json2']);
    Route::get('/osep/project/json', [OSEPProjectController::class, 'json3']);
    Route::get('/osep/dpmis/json', [OSEPProjectController::class, 'jsondpmis']);
    Route::post('/osep/project/create', [OSEPProjectController::class, 'create']);
    Route::get('/osep/project/edit-view/{id}', [OSEPProjectController::class, 'editview']);
    Route::post('/osep/project/update', [OSEPProjectController::class, 'update']);

    //Route::get('/project/comments/{id}', [OSEPProjectController::class, 'comment']);
    //Route::get('/project/list-comments/{id}', [OSEPProjectController::class, 'jsoncomment']);
    //Route::post('/project/done-comments', [OSEPProjectController::class, 'donecomment']);
    Route::post('/project/update-status', [OSEPProjectController::class, 'updatestatus']);
    Route::get('/project/total-months/{monstart}/{yearstart}/{monend}/{year}', [OSEPProjectController::class, 'totalmonths']);
});

Route::controller(CommentController::class)->group(function () {
    Route::get('/project/comments/{id}', [CommentController::class, 'index']);
    Route::post('/project/add-comments', [CommentController::class, 'create']);
    Route::post('/project/update-comments', [CommentController::class, 'update']);
    Route::post('/project/delete-comments', [CommentController::class, 'delete']);
    Route::get('/project/list-comments/{id}', [CommentController::class, 'jsoncomment']);
    Route::get('/project/json-comment/{id}', [CommentController::class, 'json']);
    Route::post('/project/done-comments', [CommentController::class, 'donecomment']);
    Route::get('/project/comments-view-all/{id}', [CommentController::class, 'all']);
    //Route::post('/project/comments/update', [CommentController::class, 'update']);
});

Route::controller(OSEPPrintController::class)->group(function () {
    Route::get('/osep/project/print/{id}', [OSEPPrintController::class, 'project']);
    Route::get('/osep/history/print/{type}/{id}', [OSEPPrintController::class, 'history']);
});

Route::controller(WorkplanController::class)->group(function () {
    Route::get('/project/workplan/{id}', [WorkplanController::class, 'index']);
    Route::post('/project/workplan/create', [WorkplanController::class, 'create']);
});


Route::controller(OSEPProgramController::class)->group(function () {
    Route::get('/osep/program', [OSEPProgramController::class, 'index']);
    Route::get('/osep/program/json', [OSEPProgramController::class, 'json']);
    Route::get('/osep/program/add', [OSEPProgramController::class, 'add']);
    Route::post('/osep/program/create', [OSEPProgramController::class, 'create']);
});

Route::controller(OSEPLibController::class)->group(function () {
    Route::get('/project/lib/{projectid}', [OSEPLibController::class, 'index']);
    Route::get('/project/add-lib/{projectid}/{budgetyr}/{budgettype}', [OSEPLibController::class, 'add']);
    Route::post('/project/lib/create', [OSEPLibController::class, 'create']);
    Route::post('/project/lib/print', [OSEPLibController::class, 'print']);
    Route::get('/project/lib-edit/{projectid}/{agencyid}', [OSEPLibController::class, 'edit']);
    Route::post('/project/lib/update', [OSEPLibController::class, 'update']);
    Route::get('/test-year', [OSEPLibController::class, 'test']);
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
    Route::get('/library/hnrda', [LibraryController::class, 'hnrda']);
    Route::get('/library/sdga', [LibraryController::class, 'sdga']);
    Route::get('/library/region', [LibraryController::class, 'region']);
    Route::get('/library/program', [LibraryController::class, 'program']);
    Route::get('/library/locregion', [LibraryController::class, 'locregion']);
    Route::get('/library/locprovince/{id}', [LibraryController::class, 'locprovince']);
    Route::get('/library/locmunicipal/{id}', [LibraryController::class, 'locmunicipal']);
    Route::get('/library/locbarangay/{id}', [LibraryController::class, 'locbarangay']);
    Route::get('/library/lib/{id}', [LibraryController::class, 'lib']);
    Route::get('/library/agencyinfo/{id}', [LibraryController::class, 'agencyinfo']);
});


// ADMIN
Route::controller(AdminController::class)->group(function () {
    Route::get('/bp202/dashboard', [AdminController::class, 'dashboard']);
    Route::get('/bp202/summary', [AdminController::class, 'summary']);
    Route::post('/bp202/summary', [AdminController::class, 'summaryprint']);
    Route::get('/bp202/priority', [AdminController::class, 'priority']);
    Route::get('/bp202/agency', [AdminController::class, 'agency']);
    Route::post('/bp202/add-agency', [AdminController::class, 'agencyadd']);
    Route::post('/bp202/set-priority', [AdminController::class, 'updateranking']);
});

// PRINT
Route::controller(PrinterController::class)->group(function () {
    Route::get('/print/workplan/{projectid}', [PrinterController::class, 'workplan']);
});


require __DIR__.'/auth.php';


