<?php

use Illuminate\Support\Facades\Route;
use User\Http\Controllers\ReservationController;
use User\Http\Controllers\RoomController;

Route::middleware('auth:api')->group(function () {
    Route::apiResource('rooms', RoomController::class);
    Route::apiResource('reservations', ReservationController::class);
});
