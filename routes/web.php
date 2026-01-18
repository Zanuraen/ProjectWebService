<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\BookingController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\MemberController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

// 1. ROUTE PUBLIK (BERANDA)
Route::get('/', function () {
    return view('home');
})->name('home');

// 2. ROUTE OTENTIKASI
Route::get('/login', function () {
    return view('login');
})->name('login');

Route::post('/login', function (\Illuminate\Http\Request $request) {
    $credentials = $request->validate([
        'email' => ['required', 'email'],
        'password' => ['required'],
    ]);

    if (\Illuminate\Support\Facades\Auth::attempt($credentials)) {
        $request->session()->regenerate();
        
        // Logika: Admin ke Dashboard, User Biasa ke Home
        if (\Illuminate\Support\Facades\Auth::user()->is_admin) {
            return redirect()->route('admin.dashboard');
        }

        return redirect()->intended(route('home'));
    }

    return back()->withErrors([
        'email' => 'Email atau password salah.',
    ]);
})->name('login.process');

Route::get('/register', function () {
    return view('register');
})->name('register');

Route::post('/register', function (\Illuminate\Http\Request $request) {
    $data = $request->validate([
        'name' => 'required|string|max:255',
        'email' => 'required|string|email|max:255|unique:users',
        'password' => 'required|string|min:6|confirmed',
    ]);
    $user = \App\Models\User::create([
        'name' => $data['name'],
        'email' => $data['email'],
        'password' => \Illuminate\Support\Facades\Hash::make($data['password']),
    ]);
    \Illuminate\Support\Facades\Auth::login($user);
    return redirect()->route('home')->with('success', 'Akun berhasil dibuat!');
})->name('register.store');

Route::post('/logout', function (\Illuminate\Http\Request $request) {
    \Illuminate\Support\Facades\Auth::logout();
    $request->session()->invalidate();
    $request->session()->regenerateToken();
    return redirect('/');
})->name('logout');

// 3. ROUTE DIPROTEKSI (LOGIN)
Route::middleware(['auth'])->group(function () {
    
    // === AREA MEMBER (USER BIASA) ===
    Route::get('/booking', [BookingController::class, 'index'])->name('booking');
    Route::post('/booking', [BookingController::class, 'store'])->name('booking.store');
    Route::get('/member', [MemberController::class, 'index'])->name('member');

    // === AREA POSTINGAN USER (LIHAT & BACA) ===
    Route::get('/posts', [PostController::class, 'index'])->name('posts.index');
    Route::get('/posts/{id}', [PostController::class, 'show'])->name('posts.show');

    // === AREA ADMIN (KHUSUS ADMIN) ===
    // FIX: Menggunakan Full Path Class AdminCheck untuk menghindari error Kernel
    Route::prefix('admin')
          ->middleware([\App\Http\Middleware\AdminCheck::class]) 
          ->name('admin.')
          ->group(function () {
            
            // Dashboard & Stats
            Route::get('/dashboard', [AdminController::class, 'index'])->name('dashboard');
            
            // Users Management
            Route::get('/users', [AdminController::class, 'users'])->name('users');
            Route::delete('/users/{id}', [AdminController::class, 'deleteUser'])->name('deleteUser');

            // Bookings Management
            Route::get('/bookings', [AdminController::class, 'bookings'])->name('bookings');
            Route::post('/bookings/{id}/status', [AdminController::class, 'updateBookingStatus'])->name('updateBooking');

            // Packages Management
            Route::get('/packages', [AdminController::class, 'packages'])->name('packages');
            Route::post('/packages/store', [AdminController::class, 'storePackage'])->name('storePackage');
            Route::put('/packages/{id}', [AdminController::class, 'updatePackage'])->name('updatePackage');
            Route::delete('/packages/{id}', [AdminController::class, 'deletePackage'])->name('deletePackage');

            // Posts Management (CRUD)
            Route::get('/posts', [PostController::class, 'adminIndex'])->name('posts');
            Route::get('/posts/create', [PostController::class, 'create'])->name('posts.create');
            Route::post('/posts', [PostController::class, 'store'])->name('posts.store');
            Route::get('/posts/{id}/edit', [PostController::class, 'edit'])->name('posts.edit');
            Route::put('/posts/{id}', [PostController::class, 'update'])->name('posts.update');
            Route::delete('/posts/{id}', [PostController::class, 'destroy'])->name('posts.destroy');
        });

});