<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\SslCertificateController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\ContactController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

// Public routes
Route::get('/', function () {
    return view('welcome');
})->name('welcome');

Route::get('/pricing', function () {
    return view('pricing');
})->name('pricing');

Route::get('/contact', [ContactController::class, 'index'])->name('contact');
Route::post('/contact', [ContactController::class, 'send'])->name('contact.send');

// Payment routes
Route::middleware(['auth'])->group(function () {
    Route::post('/payment/initiate', [PaymentController::class, 'initiate'])->name('payment.initiate');
    Route::get('/payment/callback', [PaymentController::class, 'callback'])->name('payment.callback');
});

// Webhook route (no auth required)
Route::post('/payment/webhook', [PaymentController::class, 'webhook'])->name('payment.webhook');

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // SSL Certificate routes
    Route::get('/ssl-certificates', [SslCertificateController::class, 'index'])->name('ssl-certificates.index');
    Route::post('/ssl-certificates/generate', [SslCertificateController::class, 'generate'])->name('ssl-certificates.generate');
    Route::get('/ssl-certificates/download', [SslCertificateController::class, 'download'])->name('ssl-certificates.download');
    Route::post('/ssl-certificates/info', [SslCertificateController::class, 'info'])->name('ssl-certificates.info');
    Route::get('/ssl-certificates/list', [SslCertificateController::class, 'list'])->name('ssl-certificates.list');
    Route::delete('/ssl-certificates/delete', [SslCertificateController::class, 'delete'])->name('ssl-certificates.delete');
    Route::post('/ssl-certificates/content', [SslCertificateController::class, 'content'])->name('ssl-certificates.content');

    Route::get('/change-password', function () {
        return view('profile.change-password');
    })->name('password.change');
});

require __DIR__.'/auth.php';
