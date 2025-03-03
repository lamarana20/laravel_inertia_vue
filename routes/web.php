<?php

use Illuminate\Support\Facades\Route;
use Inertia\Inertia;
use App\Http\Controllers\AuthController;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\ProfileController;







Route::get('/', function (Request $request) {
    return Inertia::render('Home', [
        'users' => User::when(trim($request->search), function ($query) use ($request) {
            $query
                ->where('name', 'like', '%' . trim($request->search) . '%')
                ->orWhere('email', 'like', '%' . trim($request->search) . '%');
        })->paginate(5)->withQueryString(),
        'filters' => $request->search,
        'can' => [
            'deleteUser' => Auth::check() ? 
            Auth::user()->can('delete', User::class) : null,
        ],
        
    ]);
})->name('home');
Route::middleware(['auth'])->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::post('/profile', [ProfileController::class, 'update'])->name('profile.update');

    Route::inertia('/dashboard', 'Dashboard')->name('dashboard');

    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
    Route::inertia('/about', 'About')->name('about');
    Route::inertia('/contact', 'Contact')->name('contact');
});
Route::middleware('guest')->group(function () {
    Route::inertia('/register', 'Auth/Register')->name('register');
    Route::post('/register', [AuthController::class, 'register']);
    Route::inertia('/login', 'Auth/Login')->name('login');
    Route::post('/login', [AuthController::class, 'login']);
});
