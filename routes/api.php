<?php

use App\Http\Controllers\TenderController;
use Illuminate\Support\Facades\Route;

Route::apiResource('tenders', TenderController::class);
