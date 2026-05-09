<?php

use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\Auth\ConfirmablePasswordController;
use App\Http\Controllers\Auth\EmailVerificationNotificationController;
use App\Http\Controllers\Auth\EmailVerificationPromptController;
use App\Http\Controllers\Auth\NewPasswordController;
use App\Http\Controllers\Auth\PasswordController;
use App\Http\Controllers\Auth\PasswordResetLinkController;
use App\Http\Controllers\Auth\RegisteredUserController;
use App\Http\Controllers\Auth\VerifyEmailController;
use Illuminate\Support\Facades\Route;

Route::middleware('guest')->group(function () {
    // Generic Routes (Keeping these for fallback or Admin if needed)
    Route::get('register', [RegisteredUserController::class, 'create'])
        ->name('register');

    Route::post('register', [RegisteredUserController::class, 'store'])
        ->middleware('throttle:auth');

    Route::get('login', [AuthenticatedSessionController::class, 'create'])
        ->name('login');

    Route::post('login', [AuthenticatedSessionController::class, 'store']);

    // Guest Account Login (View)
    Route::get('guest/login', [AuthenticatedSessionController::class, 'createGuest'])
        ->name('guest.login');

    // Guest Magic Link logic
    Route::post('guest/login/magic-link', [\App\Http\Controllers\Auth\GuestMagicLinkController::class, 'sendLink'])
        ->name('guest.login.magic-link')
        ->middleware('throttle:auth');
    
    Route::get('guest/login/verify/{user}', [\App\Http\Controllers\Auth\GuestMagicLinkController::class, 'verifyLink'])
        ->name('guest.login.verify');

    // Teacher Routes
    Route::get('teacher/register', [RegisteredUserController::class, 'createTeacher'])
        ->name('teacher.register');

    // Student Routes
    Route::get('student/register', [RegisteredUserController::class, 'createStudent'])
        ->name('student.register');

    // POST route for no-payment registration
    Route::post('student/register-no-payment', [RegisteredUserController::class, 'store'])
        ->name('student.register.no-payment.post');



    Route::get('forgot-password', [PasswordResetLinkController::class, 'create'])
        ->name('password.request');

    Route::post('forgot-password', [PasswordResetLinkController::class, 'store'])
        ->name('password.email');

    Route::get('reset-password/{token}', [NewPasswordController::class, 'create'])
        ->name('password.reset');

    Route::post('reset-password', [NewPasswordController::class, 'store'])
        ->name('password.store');
});

Route::middleware('auth')->group(function () {
    Route::get('verify-email', EmailVerificationPromptController::class)
        ->name('verification.notice');

    Route::get('verify-email/{id}/{hash}', VerifyEmailController::class)
        ->middleware(['signed', 'throttle:6,1'])
        ->name('verification.verify');

    Route::post('email/verification-notification', [EmailVerificationNotificationController::class, 'store'])
        ->middleware('throttle:6,1')
        ->name('verification.send');

    Route::get('confirm-password', [ConfirmablePasswordController::class, 'show'])
        ->name('password.confirm');

    Route::post('confirm-password', [ConfirmablePasswordController::class, 'store']);

    Route::put('password', [PasswordController::class, 'update'])->name('password.update');

    Route::post('logout', [AuthenticatedSessionController::class, 'destroy'])
        ->name('logout');
});
// Student register-no-payment: accessible to both guests and logged-in users (guest_quick)
Route::get('student/register-no-payment', [RegisteredUserController::class, 'createStudentNoPayment'])
    ->name('student.register.no-payment');

// Student & Teacher login pages are accessible even when logged in as guest,
// so they are NOT inside the 'guest' middleware group.
Route::get('student/login', [AuthenticatedSessionController::class, 'createStudent'])
    ->name('student.login');

Route::get('teacher/login', [AuthenticatedSessionController::class, 'createTeacher'])
    ->name('teacher.login');
