<?php

use App\Http\Controllers\CuentasPorPagar;
use App\Http\Controllers\UploadController;
use App\Http\Livewire\Chequesytransferencias;
use App\Http\Livewire\Cheques;
use App\Http\Livewire\Modals\Editar;
use App\Http\Livewire\Pdfcheque;
use App\Http\Livewire\Porpagar;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;



Auth::routes(['register'=>false]);




;
Route::match(['get', 'post'], '/home', [App\Http\Controllers\Login1Controller::class, 'login'])->name('home');
Route::match(['get', 'post'], '/modules', [App\Http\Controllers\HomeController::class, 'index'])->name('modules');











Route::get('/script2', [App\Http\Controllers\RecarpetarCheques::class, 'archivar'])->name('archivar');
Route::view('editar','livewire.editar');
Route::post('/upload/{id}', [App\Http\Controllers\UploadController::class, 'store']);
Route::post('/uploadEdit/{id}', [App\Http\Controllers\UploadController::class, 'storeEditPdf']);
Route::get('/chequesytransferencias',Chequesytransferencias::class)->name('cheques');
Route::get('/descargascfdi', [App\Http\Controllers\DescargascfdiController::class, 'index'])->name('descargascfdi');




Route::get('/cuentas-por-pagar',Porpagar::class)->name('cuentas');

