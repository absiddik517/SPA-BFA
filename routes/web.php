<?php

use App\Http\Controllers\Admin\AdminDashboardController;
use App\Http\Controllers\Admin\Gate\RoleController;
use App\Http\Controllers\Company\SeasonController;
use App\Http\Controllers\Order\CustomerController;
use App\Http\Controllers\Gate\PermissionController;
use App\Http\Controllers\Order\ProductController;
use App\Http\Controllers\Order\CustomerPaymentController;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

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
    return Inertia::render('Welcome', [
        'canLogin' => Route::has('login'),
        'canRegister' => Route::has('register'),
        'laravelVersion' => Application::VERSION,
        'phpVersion' => PHP_VERSION,
    ]);
});

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {
    Route::get('/dashboard', function () {
        return Inertia::render('Dashboard');
    })->name('dashboard');
});

Route::prefix('admin')->name('admin.')->middleware(['auth:sanctum', config('jetstream.auth_session'), 'verified'])->group(function () {
    Route::get('dashboard', [AdminDashboardController::class, 'index'])->name('dashboard.index');
    Route::get('table', [AdminDashboardController::class, 'table'])->name('dashboard.table');
    
    Route::prefix('gate')->name('gate.')->group(function (){
      Route::prefix('role')->name('role.')->group(function(){
        Route::get('/', [RoleController::class, 'index'])->name('index');
        Route::get('/create', [RoleController::class, 'create'])->name('create');
        Route::post('/store', [RoleController::class, 'store'])->name('store');
        Route::delete('/{id}/delete', [RoleController::class, 'destroy'])->name('delete');
        Route::post('/{id}/delete', [RoleController::class, 'update'])->name('edit');
      });
      
      Route::prefix('permission')->name('permission.')->group(function() {
        Route::get('/', [PermissionController::class, 'index'])->name('index');
      });
    });
});

Route::get('user-list', [AdminDashboardController::class, 'getUser'])->name('select.user');


Route::prefix('gate')->name('gate.')->middleware(['auth:sanctum', config('jetstream.auth_session'), 'verified'])->group(function(){
  Route::prefix('permission')->name('permission.')->group(function(){
    Route::get('/', [PermissionController::class, 'index'])->name('index');
    Route::post('/store', [PermissionController::class, 'store'])->name('store');
    Route::delete('/{id}/delete', [PermissionController::class, 'destroy'])->name('delete');
    Route::post('/{id}/delete', [PermissionController::class, 'update'])->name('update');
  });
});

Route::name('order.')->middleware(['auth:sanctum', config('jetstream.auth_session'), 'verified'])->group(function(){
  Route::prefix('customer')->name('customer.')->group(function(){
    Route::get('/', [CustomerController::class, 'index'])->name('index');
    Route::post('/store', [CustomerController::class, 'store'])->name('store');
    Route::post('/{id}/update', [CustomerController::class, 'update'])->name('update');
    Route::delete('/{id}/delete', [CustomerController::class, 'destroy'])->name('delete');
    
    Route::prefix('payment')->name('payment.')->group(function(){
      Route::get('/', [CustomerPaymentController::class, 'index'])->name('index');
      Route::post('/store', [CustomerPaymentController::class, 'store'])->name('store');
      Route::post('/{id}/update', [CustomerPaymentController::class, 'update'])->name('update');
      Route::delete('/{id}/delete', [CustomerPaymentController::class, 'destroy'])->name('delete');
      Route::get('/customers', [CustomerPaymentController::class, 'customers'])->name('customers');
    });
  });
  
  Route::prefix('product')->name('product.')->group(function(){
    Route::get('/', [ProductController::class, 'index'])->name('index');
    Route::post('/store', [ProductController::class, 'store'])->name('store');
    Route::post('/{id}/update', [ProductController::class, 'update'])->name('update');
    Route::delete('/{id}/delete', [ProductController::class, 'destroy'])->name('delete');
  });
});

Route::prefix('company')->name('company.')->middleware(['auth:sanctum', config('jetstream.auth_session'), 'verified'])->group(function(){
  Route::prefix('season')->name('season.')->group(function(){
    Route::get('/', [SeasonController::class, 'index'])->name('index');
    Route::post('/store', [SeasonController::class, 'store'])->name('store');
    Route::post('/{id}/update', [SeasonController::class, 'update'])->name('update');
    Route::delete('/{id}/delete', [SeasonController::class, 'destroy'])->name('delete');
  });
});
