<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CheckStockController;
use App\Http\Controllers\ImportController;
use App\Http\Controllers\UserController;

use App\Http\Middleware\UsernameSessionMiddleware;

// Route::get('/', function () {
//     return view('welcome');
// });

Route::get('/', function () {
    return view('login');
});
Route::post('/login', [UserController::class, 'login'])->name('login');
Route::get('/logout', [UserController::class, 'logout'])->name('logout');

Route::middleware([UsernameSessionMiddleware::class])->group(function () {
    Route::get('/form_scan', function () {
        return view('form_scan');
    });
    Route::get('/qr_pallet', [CheckStockController::class, 'index'])->name('dataTable');
    Route::get('/box_pallet/{id}', [CheckStockController::class, 'edit'])->where('id', '.*');
    Route::post('/checked', [CheckStockController::class, 'checked']);

    //Data Current
    Route::get('/import_data', function () {
        return view('import_data');
    });
    Route::post('/import/data', [ImportController::class, 'import'])->name('products.import');
    Route::get('/get-import-progress', [ImportController::class, 'getImportProgress'])->name('get-import-progress');
    Route::post('/transfer_past/data', [ImportController::class, 'transfer_past'])->name('transfer_past');
    Route::get('/qr_import', [ImportController::class, 'index'])->name('dataTable');
    Route::get('/group_bin', [ImportController::class, 'group_bin']);


});
