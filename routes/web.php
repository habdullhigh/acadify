<?php

use App\Http\Controllers\OfficeController;
use App\Http\Controllers\StudentFormController;
use App\Services\StudentFormService;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

Route::get('/', function () {
    return Inertia::render('welcome');
})->name('home');

Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('dashboard', function () {
        return Inertia::render('dashboard');
    })->name('dashboard');
});
Route::middleware(['auth'])->group(function () {
    Route::get('/offices',[OfficeController::class,'getOffices'])->name('offices');
    Route::post('form/submit',[StudentFormController::class, 'store'])->name('form.submit');

});

Route::middleware(['auth'])->group(function () {
    Route::get('/student-forms', function(){
        return Inertia::render('StudentFormsPage');
    });
    Route::get('/reciepts', function(){
        return Inertia::render('RecieptsPage');
    });
});


Route::middleware('auth')->group(function () {
    Route::get('/upload-section', function(){
        return Inertia::render('UploadSection');
    });
    Route::get('/forms', function(){
        return Inertia::render('FormsPage');
    });

    Route::get('/reciepts', function(){
        return Inertia::render('RecieptsPage');
    });

});

require __DIR__.'/settings.php';
require __DIR__.'/auth.php';
