<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

Route::get('/redirect', function(){
if(Auth::user() && Auth::user()->is_admin == 1){
    return redirect('/dashboard');
}else{
    Auth::guard('web')->logout();
    return redirect('/admin/login');
}
});


Route::prefix('admin')->middleware('admin')->group(function() {
    Route::get('/', [App\Http\Controllers\AdminController::class, 'index'])->name('admin.dashboard');
});

// Route::post('/logout', [App\Http\Controllers\Auth\AdminLoginController::class, 'logout'])->name('admin.logout');

Route::prefix('admin')->group(function() {
    Route::get('/login', [App\Http\Controllers\Auth\AdminLoginController::class, 'showLoginForm'])->name('admin.login');
    Route::post('/login', [App\Http\Controllers\Auth\AdminLoginController::class, 'login'])->name('admin.login.submit');
    Route::get('/', [App\Http\Controllers\AdminController::class, 'index'])->name('admin.dashboard');
});
