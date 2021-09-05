<?php

use App\Http\Controllers\CalendarDateController;
use App\Http\Controllers\EventController;
use App\Http\Controllers\NewsController;
use App\Http\Controllers\ReminderController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::middleware('auth:web')->group(function () {
    Route::get('/', [HomeController::class, 'index'])->name('home');
//    Route::get('/c/{year}/{month}', [HomeController::class, 'calendarMonth'])->name('calendarMonth');

    Route::get('/month', [CalendarDateController::class, 'getMonthData'])->name('getMonthData');
    Route::get('/date', [CalendarDateController::class, 'getDateData'])->name('getDateData');

    Route::post('/removeObject', [CalendarDateController::class, 'deleteObject'])->name('removeObject');

    Route::get('/reminders/edit', [ReminderController::class, 'edit'])->name('editReminder');
    Route::post('/reminders', [ReminderController::class, 'create'])->name('createReminder');
    Route::put('/reminders', [ReminderController::class, 'update'])->name('updateReminder');


    Route::get('/news/edit', [NewsController::class, 'edit'])->name('editNews');

    Route::get('/events/edit', [EventController::class, 'edit'])->name('editEvent');
});

require __DIR__.'/auth.php';
