// Add these to your routes/web.php file

// Language switcher route
Route::get('/locale/{locale}', function ($locale) {
    if (in_array($locale, ['ar', 'en'])) {
        session(['locale' => $locale]);
        app()->setLocale($locale);
    }
    return redirect()->back();
})->name('locale.switch');

// Arbitration routes (add inside your auth group)
Route::middleware(['auth'])->group(function () {
    // ... existing routes ...

    // Arbitration
    Route::post('/bookings/{booking}/dispute', [BookingController::class, 'fileDispute'])->name('bookings.dispute');
    Route::get('/bookings/{booking}/arbitration', [BookingController::class, 'arbitrationStatus'])->name('bookings.arbitration');
});

// Admin arbitration routes (add inside admin middleware group)
Route::middleware(['auth', 'admin'])->group(function () {
    // ... existing admin routes ...

    Route::get('/admin/arbitrations', [AdminController::class, 'arbitrations'])->name('admin.arbitrations');
    Route::post('/admin/arbitrations/{booking}/resolve', [AdminController::class, 'resolveArbitration'])->name('admin.arbitrations.resolve');
});
