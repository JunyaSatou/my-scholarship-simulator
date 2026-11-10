<?php

use App\Http\Controllers\ScholarshipSimulationController;
use Illuminate\Support\Facades\Route;

Route::get('/', [ScholarshipSimulationController::class, 'index'])->name('scholarships.index');
Route::post('/', [ScholarshipSimulationController::class, 'simulate'])->name('scholarships.simulate');
