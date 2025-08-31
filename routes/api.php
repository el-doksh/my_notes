<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\TopicController;

Route::prefix('api')->middleware('api')->group(function () {
    Route::get('/topics', [TopicController::class, 'index'])->name('api.topics.index');
});
