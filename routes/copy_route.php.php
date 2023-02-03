<?php
use App\Http\Controllers\Order\CustomerPaymentController;

Route::prefix('payment')->name('payment.')->group(function(){
  Route::get('/', [CustomerPaymentController::class, 'index'])->name('index');
  Route::post('/store', [CustomerPaymentController::class, 'store'])->name('store');
  Route::post('/{id}/update', [CustomerPaymentController::class, 'update'])->name('update');
  Route::delete('/{id}/delete', [CustomerPaymentController::class, 'destroy'])->name('delete');
});



?>