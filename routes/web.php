<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\EvaluationController;
use App\Livewire\User\EvalFinal;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/


Route::middleware([

    ])->group(function () {
         Route::get('/dashboard', function () {
           if (auth()->user()->is_admin == 1) {
            return redirect()->route('admin-dashboard');
           }
           else{
            return redirect()->route('user-dashboard');
           }
         })->name('userdashboard');

    });

    Route::prefix('admin')->middleware('admin')->group(function(){

        Route::get('/admin', function(){
            return view('admin.index');
        })->name('admin-dashboard');

        Route::get('/manage-events', function(){
            return view('admin.manage-events');
        })->name('manage-events');

        Route::get('/manage-questions', function(){
            return view('admin.manage-questions');
        })->name('manage-questions');

        Route::get('/ratings', function(){
            return view('admin.ratings');
        })->name('ratings');

        Route::get('/result', function(){
            return view('admin.result');
        })->name('result');

        Route::get('/survey_questions', function(){
            return view('admin.survey_questions');
        })->name('survey_questions');

        Route::get('/act', function(){
            return view('admin.act');
        })->name('act');

        Route::get('/venue', function(){
            return view('admin.venue');
        })->name('venue');

        Route::get('/accomodations', function(){
            return view('admin.accomodations');
        })->name('accomodations');

        Route::get('/speaker', function(){
            return view('admin.speaker');
        })->name('speaker');

        Route::get('/evaluation', function(){
            return view('admin.evaluation');
        })->name('evaluation');


     });

     Route::prefix('user')->middleware('user')->group(function(){

        Route::get('/user', function(){
            return view('user.index');
        })->name('user-dashboard');

        Route::get('/evaluate-from', function(){
            return view('user.evaluate-form');
        })->name('evaluate-form');
        Route::get('/eval-final', function () {
            return view('user.eval-final');
        })->name('eval-final');

        Route::get('/about', function () {
            return view('user.about');
        })->name('about');


     });

     Route::view('/', 'welcome');

// Route::view('dashboard', 'dashboard')
//     ->middleware(['auth', 'verified'])
//     ->name('dashboard');
// Route::get('/eval-final/{evaluation_id}', EvalFinal::class)->name('eval-final');

Route::view('profile', 'profile')
    ->middleware(['auth'])
    ->name('profile');
Route::get('/logout', [AuthController::class, 'logout'])->name('logout');
require __DIR__.'/auth.php';
