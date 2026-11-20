<?php

use App\Http\Controllers\HabitLogController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect()->route('habits.index');
});

Route::get('/habits', [HabitLogController::class, 'index'])->name('habits.index');
Route::post('/habits', [HabitLogController::class, 'storeHabit'])->name('habits.store');
Route::post('/habits/{habit}/check-in', [HabitLogController::class, 'toggleToday'])->name('habits.checkIn');
Route::delete('/habits/{habit}', [HabitLogController::class, 'destroyHabit'])->name('habits.destroy');