<?php

use App\Http\Controllers\Dashboard\CategoriesController;
use App\Http\Controllers\Dashboard\ProductController;
use App\Http\Controllers\Dashboard\ProfileController;
use App\Http\Controllers\Dashboard\RolesController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;

Route::group(
    [
        'middleware'=>['auth:admin'],
        'as' => 'dashboard.',    //put this word before the name of resource route name
        'prefix'=>'admin/dashboard'

    ],
    function () {
        Route::get('profile',[ProfileController::class,'edit'])->name('profile.edit');
        Route::patch('profile',[ProfileController::class,'update'])->name('profile.update');
        Route::get('/', [DashboardController::class, 'index']);
        Route::get('/categories/trash',[CategoriesController::class,'trash'])
        ->name('categories.trash');
        Route::put('/categories/{category}/restore',[CategoriesController::class,'restore'])
        ->name('categories.restore');
        Route::delete('/categories/{category}/force-delete',[CategoriesController::class,'forcedelete'])
        ->name('categories.force-delete');
        Route::resource('/categories', CategoriesController::class);
        Route::resource('/products', ProductController::class);
        Route::resource('/roles', RolesController::class);
    }
);
