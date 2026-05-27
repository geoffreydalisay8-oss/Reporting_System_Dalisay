<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdminDashboardController;
use App\Http\Controllers\TicketController;
use App\Http\Controllers\AttachmentController;

Route::get('/', function () { 
    return view('welcome'); 
});

// --- ROUTES FOR EVERYONE (Employees & Admins) ---
Route::middleware(['auth', 'verified'])->group(function () {
    
    // This is the dashboard the Employee sees
    Route::get('/dashboard', function () {
    return view('tickets.dashboard'); // Note the "tickets." prefix
    })->name('dashboard');

    
    Route::get('/tickets', [TicketController::class, 'index'])->name('tickets.index');
    Route::get('/tickets/create', [TicketController::class, 'create'])->name('tickets.create');
    Route::post('/tickets', [TicketController::class, 'store'])->name('tickets.store');
    Route::get('/tickets/{id}', [TicketController::class, 'show'])->name('tickets.show');
    Route::post('/tickets/{ticket}/comments', [TicketController::class, 'storeComment'])->name('comments.store');
    Route::post('/tickets/{id}/cancel', [TicketController::class, 'cancel'])->name('tickets.cancel');

    // Profile Routes
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';




// --- ADMIN & STAFF SHARED ROUTES ---
Route::middleware(['auth', 'role:admin,staff'])
    ->prefix('admin')
    ->name('admin.')          // ← ADD THIS
    ->group(function () {

    Route::get('/dashboard', [AdminDashboardController::class, 'index'])->name('dashboard');
    Route::get('/tickets', [AdminDashboardController::class, 'ticket'])->name('ticket.index');
    Route::post('/tickets/assign/{id}', [AdminDashboardController::class, 'assignTicket'])->name('tickets.assign');
    Route::get('/tickets/{id}', [AdminDashboardController::class, 'showTicket'])->name('tickets.show');
    Route::post('/tickets/{ticket}/comments', [TicketController::class, 'storeComment'])->name('comments.store');
    Route::get('/activity-log', [AdminDashboardController::class, 'activityLog'])->name('activity.log');

    Route::middleware(['role:admin'])->group(function () {
        Route::get('/staff', [AdminDashboardController::class, 'manageStaff'])->name('staff.index');
        Route::get('/staff/create', [AdminDashboardController::class, 'createStaff'])->name('staff.create');
        Route::post('/staff/store', [AdminDashboardController::class, 'storeStaff'])->name('staff.store');
        Route::get('/staff/{id}/edit', [AdminDashboardController::class, 'editStaff'])->name('staff.edit');
        Route::put('/staff/{id}', [AdminDashboardController::class, 'updateStaff'])->name('staff.update');
        Route::delete('/staff/{id}', [AdminDashboardController::class, 'destroyStaff'])->name('staff.destroy');
        Route::post('/tickets/{id}/status', [AdminDashboardController::class, 'updateStatus'])->name('tickets.updateStatus');
        Route::get('/departments', [AdminDashboardController::class, 'indexDepartments'])->name('departments.index');
        Route::post('/departments', [AdminDashboardController::class, 'storeDepartment'])->name('departments.store');
    });
});
