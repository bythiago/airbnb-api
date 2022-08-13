<?php

use Illuminate\Support\Facades\Route;
use User\Http\Controllers\ReservationController;
use User\Http\Controllers\RoomController;

Route::apiResource('rooms', RoomController::class);
Route::apiResource('reservations', ReservationController::class);
