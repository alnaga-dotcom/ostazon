<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\TutorDirectoryController;
use App\Http\Controllers\StudentController;
use App\Http\Controllers\TutorController;
use App\Http\Controllers\RequestController;
use App\Http\Controllers\LessonController;
use App\Http\Controllers\ReviewController;
use App\Http\Controllers\CoinController;
use App\Http\Controllers\ReferralController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\BookingController;
use App\Http\Controllers\Admin\TutorController as AdminTutorController;

/*
|--------------------------------------------------------------------------
| Public Routes
|--------------------------------------------------------------------------
*/

Route::get('/', [TutorDirectoryController::class, 'landing'])->name('home');
Route::get('/tutors', [TutorDirectoryController::class, 'index'])->name('tutors.index');
Route::get('/tutors/{id}', [TutorDirectoryController::class, 'show'])->name('tutors.show');

Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
Route::post('/register', [AuthController::class, 'register']);
Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

Route::get('/ref/{code}', [ReferralController::class, 'track'])->name('referral.track');

/*
|--------------------------------------------------------------------------
| Student Routes
|--------------------------------------------------------------------------
*/

Route::middleware(['auth'])->prefix('student')->name('student.')->group(function () {
    Route::get('/dashboard', [StudentController::class, 'dashboard'])->name('dashboard');
    Route::get('/profile', [StudentController::class, 'profile'])->name('profile');
    Route::post('/profile', [StudentController::class, 'updateProfile']);

    // Requests
    Route::get('/requests', [RequestController::class, 'myRequests'])->name('requests');
    Route::get('/requests/create', [RequestController::class, 'create'])->name('requests.create');
    Route::post('/requests', [RequestController::class, 'store'])->name('requests.store');

    // Proposals
    Route::post('/proposals/{proposal}/accept', [RequestController::class, 'acceptProposal'])->name('proposals.accept');

    // Bookings
    Route::get('/bookings', [LessonController::class, 'studentBookings'])->name('bookings');
    Route::post('/bookings', [LessonController::class, 'store'])->name('bookings.store');
    Route::post('/bookings/{id}/cancel', [LessonController::class, 'cancel'])->name('bookings.cancel');
    Route::post('/bookings/{id}/dispute', [LessonController::class, 'fileDispute'])->name('bookings.dispute');

    // Reviews
    Route::get('/reviews/create/{booking}', [ReviewController::class, 'create'])->name('reviews.create');
    Route::post('/reviews', [ReviewController::class, 'store'])->name('reviews.store');

    // Coins
    Route::get('/coins', [CoinController::class, 'history'])->name('coins');
    Route::get('/coins/purchase', [CoinController::class, 'purchase'])->name('coins.purchase');
    Route::post('/coins/purchase', [CoinController::class, 'storePurchase'])->name('coins.purchase.store');
    Route::get('/coins/history', [CoinController::class, 'history'])->name('coins.history');
    Route::post('/coins/reveal', [CoinController::class, 'revealContact'])->name('coins.reveal');
});

/*
|--------------------------------------------------------------------------
| Tutor Routes
|--------------------------------------------------------------------------
*/

Route::middleware(['auth'])->prefix('tutor')->name('tutor.')->group(function () {
    Route::get('/dashboard', [TutorController::class, 'dashboard'])->name('dashboard');
    Route::get('/profile', [TutorController::class, 'profile'])->name('profile');
    Route::post('/profile', [TutorController::class, 'updateProfile']);
    Route::post('/subjects', [TutorController::class, 'updateSubjects'])->name('subjects');

    // Verification
    Route::get('/verification', [TutorController::class, 'verification'])->name('verification');
    Route::post('/verification/video', [TutorController::class, 'uploadVideo'])->name('verification.video');
    Route::post('/verification/id', [TutorController::class, 'uploadId'])->name('verification.id');
    Route::post('/verification/certificate', [TutorController::class, 'uploadCertificate'])->name('verification.certificate');

    // Proposals
    Route::get('/proposals', [RequestController::class, 'tutorProposals'])->name('proposals');
    Route::post('/proposals', [RequestController::class, 'storeProposal'])->name('proposals.store');

    // Bookings
    Route::get('/bookings', [LessonController::class, 'tutorBookings'])->name('bookings');
    Route::post('/bookings/{id}/confirm', [LessonController::class, 'confirm'])->name('bookings.confirm');
    Route::post('/bookings/{id}/complete', [LessonController::class, 'complete'])->name('bookings.complete');

    // Earnings & Withdrawals
    Route::get('/earnings', [TutorController::class, 'earnings'])->name('earnings');
    Route::get('/withdrawals', [TutorController::class, 'withdrawals'])->name('withdrawals');
    Route::post('/withdrawals', [TutorController::class, 'storeWithdrawal'])->name('withdrawals.store');
});

/*
|--------------------------------------------------------------------------
| Language Switcher
|--------------------------------------------------------------------------
*/

Route::get('/locale/{locale}', function ($locale) {
    if (in_array($locale, ['ar', 'en'])) {
        session(['locale' => $locale]);
        app()->setLocale($locale);
    }
    return redirect()->back();
})->name('locale.switch');

/*
|--------------------------------------------------------------------------
| Arbitration Routes
|--------------------------------------------------------------------------
*/

Route::middleware(['auth'])->group(function () {
    Route::post('/bookings/{booking}/dispute', [BookingController::class, 'fileDispute'])->name('bookings.dispute');
    Route::get('/bookings/{booking}/arbitration', [BookingController::class, 'arbitrationStatus'])->name('bookings.arbitration');
});

/*
|--------------------------------------------------------------------------
| Admin Routes
|--------------------------------------------------------------------------
*/

Route::middleware(['auth', 'admin'])->prefix('admin')->name('admin.')->group(function () {
    // Dashboard
    Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('dashboard');

    // Tutors (using new AdminTutorController for badges)
    Route::get('/tutors', [AdminTutorController::class, 'index'])->name('tutors.index');
    Route::post('/tutors/{tutor}/verify', [AdminTutorController::class, 'verify'])->name('tutors.verify');
    Route::post('/tutors/{tutor}/reject', [AdminTutorController::class, 'reject'])->name('tutors.reject');
    Route::post('/tutors/{tutor}/badge', [AdminTutorController::class, 'updateBadge'])->name('tutors.badge');

    // Payments
    Route::get('/payments', [AdminController::class, 'payments'])->name('payments');
    Route::post('/payments/{id}/verify', [AdminController::class, 'verifyPayment'])->name('payments.verify');
    Route::post('/payments/{id}/reject', [AdminController::class, 'rejectPayment'])->name('payments.reject');

    // Withdrawals
    Route::get('/withdrawals', [AdminController::class, 'withdrawals'])->name('withdrawals');
    Route::post('/withdrawals/{id}/process', [AdminController::class, 'processWithdrawal'])->name('withdrawals.process');

    // Disputes
    Route::get('/disputes', [AdminController::class, 'disputes'])->name('disputes');
    Route::post('/disputes/{id}/resolve', [AdminController::class, 'resolveDispute'])->name('disputes.resolve');

    // Arbitrations
    Route::get('/arbitrations', [AdminController::class, 'arbitrations'])->name('arbitrations');
    Route::post('/arbitrations/{booking}/resolve', [AdminController::class, 'resolveArbitration'])->name('arbitrations.resolve');

    // Analytics
    Route::get('/analytics', [AdminController::class, 'analytics'])->name('analytics');
});