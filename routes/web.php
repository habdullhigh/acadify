<?php

use App\Http\Controllers\AdminSubmissionsController;
use App\Http\Controllers\OfficeController;
use App\Http\Controllers\StudentFormController;
use App\Http\Controllers\StudentRecieptController;
use App\Models\StudentReciept;
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
Route::middleware(['auth', 'verified','admin'])->prefix('admin')->group(function () {
    Route::get('/dashboard', function () {
        return Inertia::render('admin/dashboard');
    })->name('dashboard.admin');
    Route::get('/all-submissions', [AdminSubmissionsController::class, 'allSubmissions' ])->name('submissions.admin');
    Route::get('/submissions', function () {
        return Inertia::render('admin/submissions');
    })->name('submissions');
});
Route::middleware(['auth'])->group(function () {
    Route::get('/offices',[OfficeController::class,'getOffices'])->name('offices');
    Route::post('form/submit',[StudentFormController::class, 'store'])->name('form.submit');
    Route::post('reciept/submit',[StudentRecieptController::class, 'store'])->name('reciept.submit');
    Route::get('my-reciepts',[StudentRecieptController::class, 'getReciepts'])->name('reciept.get');
    Route::get('my-forms',[StudentFormController::class, 'getForms'])->name('form.get');

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
