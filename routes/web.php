<?php

use App\Http\Controllers\Auth\ConfirmPasswordController;
use App\Http\Controllers\Auth\ForgotPasswordController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Auth\ResetPasswordController;
use App\Http\Controllers\Auth\VerificationController;
use App\Http\Controllers\HomeController;
use Illuminate\Support\Facades\Route;
use Mantax559\LaravelTranslations\Controllers\LanguageController;

// Authentication routes
Route::controller(LoginController::class)->group(function () {
    Route::get(trans('routes.login'), 'showLoginForm')->name('login');
    Route::post(trans('routes.login'), 'login');
    Route::post(trans('routes.logout'), 'logout')->name('logout');
});

Route::controller(RegisterController::class)->group(function () {
    Route::get(trans('routes.register'), 'showRegistrationForm')->name('register');
    Route::post(trans('routes.register'), 'register');
});

Route::name('password.')->controller(ForgotPasswordController::class)->group(function () {
    Route::get(trans('routes.password.request'), 'showLinkRequestForm')->name('request');
    Route::post(trans('routes.password.email'), 'sendResetLinkEmail')->name('email');
})->controller(ResetPasswordController::class)->group(function () {
    Route::get(trans('routes.password.reset'), 'showResetForm')->name('reset');
    Route::post(trans('routes.password.update'), 'reset')->name('update');
})->controller(ConfirmPasswordController::class)->group(function () {
    Route::get(trans('routes.password.confirm'), 'showConfirmForm')->name('confirm');
    Route::post(trans('routes.password.confirm'), 'confirm');
});

Route::name('verification.')->controller(VerificationController::class)->group(function () {
    Route::get(trans('routes.verification.notice'), 'show')->name('notice');
    Route::get(trans('routes.verification.verify'), 'verify')->name('verify');
    Route::post(trans('routes.verification.resend'), 'resend')->name('resend');
});

// Other routes
Route::get(trans('routes.language'), [LanguageController::class, 'change'])->name('language.change');

Route::get(trans('routes.default'), function () {
    return view('welcome');
});

Route::middleware(['auth', 'verified'])->group(function () {
    Route::controller(HomeController::class)->group(function () {
        Route::get(trans('routes.home'), 'index')->name('home');
    });
});
