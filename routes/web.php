<?php

use App\Http\Controllers\CompanyController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\TransferController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\FinishController;
use App\Http\Controllers\MaterialController;
use App\Http\Controllers\MaterialtypeController;
use App\Http\Controllers\ReservationController;
use App\Http\Controllers\SessionController;
use App\Http\Controllers\WarehouseCompanyController;
use App\Http\Controllers\WarehouseController;
use App\Http\Middleware\Associate;
use App\Http\Middleware\Warehouse;
use App\Models\Reservation;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect()->route('auth.index');
});

Route::get('login', fn() => to_route('auth.create'))->name('login');
Route::resource('auth', AuthController::class)
    ->only('create', 'store');
Route::delete('logout', fn() => to_route('auth.destroy'))->name('logout');
Route::delete('auth', [AuthController::class, 'destroy'])->name('auth.destroy');

Route::post('/update-session', [SessionController::class, 'update'])->name('session.update');
Route::get('/get-session', [SessionController::class, 'get'])->name('session.get');

Route::middleware('auth')->group(function(){

    Route::get('auth', [AuthController::class, 'index'])->name('auth.index');

    Route::middleware([Warehouse::class])->group(function(){
        Route::resource('warehouse/material', MaterialController::class)
            ->except('destroy','update');
        Route::resource('warehouse/warehouse', WarehouseController::class)
            ->only('index', 'edit', 'create', 'store');

        Route::get('warehouse/warehouse/order', [WarehouseController::class, 'order'])->name('warehouse.order');

        Route::resource('warehouse/material_type', MaterialtypeController::class)
            ->only('index','create','store');
        Route::resource('warehouse/finish', FinishController::class)
            ->only('index', 'create', 'store');
        Route::resource('warehouse/reservation', ReservationController::class)
            ->only('show', 'create', 'store', 'destroy', 'edit', 'update');
        Route::resource('warehouse/company', WarehouseCompanyController::class)
            ->except('destroy')->names('warehouseCompany');
        Route::resource('warehouse/contacts', ContactController::class)
            ->except('destroy')->names('contacts');
    });

    Route::middleware([Associate::class])->group(function(){
        Route::get('associates/company/new', [CompanyController::class, 'new'])->name('company.new');

        Route::resource('associates/company', CompanyController::class)
            ->only(['index', 'show', 'create', 'store', 'edit', 'update']);

        Route::get('associates/transfer/payment', [TransferController::class, 'payment'])->name('transfer.payment');
        Route::get('associates/transfer/income', [TransferController::class, 'income'])->name('transfer.income');
        Route::get('associates/display/transfer/{company}', [TransferController::class, 'display'])->name('transfer.display');

        Route::resource('associates/transfer', TransferController::class)
            ->only(['index', 'create', 'store', 'show', 'edit', 'update', 'destroy']);

        Route::resource('associates/user', UserController::class)
            ->only(['index', 'create', 'store', 'show', 'edit', 'update']);
    });

});
