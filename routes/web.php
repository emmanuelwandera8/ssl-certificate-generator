<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\SslCertificateController;

Route::get('/', function () {
    return redirect()->route('ssl-certificates.index');
});

Route::prefix('ssl-certificates')->name('ssl-certificates.')->group(function () {
    Route::get('/', [SslCertificateController::class, 'index'])->name('index');
    Route::post('/generate', [SslCertificateController::class, 'generate'])->name('generate');
    Route::get('/download', [SslCertificateController::class, 'download'])->name('download');
    Route::get('/info', [SslCertificateController::class, 'info'])->name('info');
    Route::get('/list', [SslCertificateController::class, 'list'])->name('list');
    Route::delete('/delete', [SslCertificateController::class, 'delete'])->name('delete');
    Route::get('/content', [SslCertificateController::class, 'content'])->name('content');
});
