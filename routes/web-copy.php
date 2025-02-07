<?php

use App\Http\Controllers\CompanyController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\TransferController;
use App\Http\Controllers\UserController;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    if(Auth::check()){
        if(Auth::user()->role_id === 1){
        return redirect()->route('company.index');
        } else {
            return redirect()->route('transfer.index');
        }
    } else {
        return redirect()->route('login');
    }
})->name('home');

Route::get('/login', [LoginController::class, 'index'])->name('login');
Route::post('/login', [LoginController::class, 'login']);

Route::get('/logout', function(){
    Auth::logout();
    return redirect()->route('login');
})->name('logout');

Route::get('company/new', [CompanyController::class, 'new'])->name('company.new')->middleware('auth');


Route::resource('company', CompanyController::class)
    ->only(['index', 'show', 'create', 'store', 'edit', 'update'])
    ->middleware('auth');

Route::get('transfer/payment', [TransferController::class, 'payment'])->name('transfer.payment')->middleware('auth');
Route::get('transfer/income', [TransferController::class, 'income'])->name('transfer.income')->middleware('auth');
Route::get('display/transfer/{company}', [TransferController::class, 'display'])->name('transfer.display')->middleware('auth');

Route::resource('transfer', TransferController::class)
    ->only(['index', 'create', 'store', 'show', 'edit', 'update', 'destroy'])
    ->middleware('auth');

Route::resource('user', UserController::class)
    ->only(['index', 'create', 'store', 'show', 'edit', 'update'])
    ->middleware('auth');

Route::fallback(function(){
    return redirect()->route('trt');
});

Route::get('/trt', function(){
    return '404';
})->name('trt');

