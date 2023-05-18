<?php
use App\Http\Controllers\Staff\StaffController;

Route::prefix('staff')->name('staff.')->group(function(){
  Route::get('/', [StaffController::class, 'index'])->name('index');
  Route::post('/store', [StaffController::class, 'store'])->name('store');
  Route::post('/{id}/update', [StaffController::class, 'update'])->name('update');
  Route::delete('/{id}/delete', [StaffController::class, 'destroy'])->name('delete');
});



?>