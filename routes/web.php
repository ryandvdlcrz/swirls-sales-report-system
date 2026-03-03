<?php

use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\SaleController;
use Illuminate\Support\Facades\Auth;

// Root route - redirect to login for guests, to home for authenticated users
Route::get('/', function () {
    if (Auth::check()) {
        return redirect()->route('authenticated.home');
    }
    return redirect()->route('login');
});

// Authenticated home - redirects based on role
Route::get('/home', function () {
    $user = Auth::user();

    if ($user->role === 'admin') {
        return redirect('/admin');
    } elseif ($user->role === 'merchant') {
        return redirect()->route('index');
    } else {
        return redirect()->route('index');
    }
})->middleware('auth')->name('authenticated.home');

Route::get('/login', [AuthenticatedSessionController::class, 'create'])
    ->middleware('guest')
    ->name('login');

Route::post('/login', [AuthenticatedSessionController::class, 'store'])
    ->middleware('guest');

Route::middleware('auth')->group(function () {
    Route::post('/sales/store', [SaleController::class, 'store'])->name('sales.store');
    Route::get('/order/success', [SaleController::class, 'success'])->name('order.success');
    Route::view('/order/checkout', 'order.checkOut')->name('order.checkout'); // Changed to 'order.checkOut'
});


Route::get('/index', function () {
    return view('index');
})->middleware(['auth'])->name('index');

Route::middleware(['auth'])->prefix('menu')->name('menu.')->group(function () {
    Route::view('/', 'menu.index')->name('index');
    Route::view('/daydreamclassic', 'menu.dd_classic')->name('daydreamclassic');
    Route::view('/bigcone', 'menu.bigcone')->name('bigcone');
    Route::view('/sundaecup', 'menu.sundae_cup')->name('sundaecup');
    Route::view('/sundaecone', 'menu.sundae_cone')->name('sundaecone');
    Route::view('/daydreampremium', 'menu.dd_premium')->name('daydreampremium');
    Route::view('/swirldelight', 'menu.swirl_id')->name('swirldelight');
    Route::view('/vanillacone', 'menu.vanill_c')->name('vanillacone');
    Route::view('/sodafloat', 'menu.soda_fi')->name('sodafloat');
    Route::view('/carfait', 'menu.carfait')->name('carfait');
    Route::view('/milkshake', 'menu.mlkshake')->name('milkshake');
    Route::view('/icedcoffeefloat', 'menu.ice_flt')->name('icedcoffeefloat');
});

Route::middleware(['auth'])->prefix('settings')->name('settings.')->group(function () {
    Route::view('/', 'settings.index')->name('index');
    Route::get('/account', [App\Http\Controllers\SettingsController::class, 'account'])->name('account');
});

// Updated: Redirect sales to Filament merchant panel
Route::middleware(['auth'])->prefix('sales')->name('sales.')->group(function () {
    Route::get('/', function () {
        $user = Auth::user();  // Get user object first

        // Check if user exists and is a merchant
        if (!$user || $user->role !== 'merchant') {
            return redirect()->route('index')->with('error', 'Access denied. Merchants only.');
        }

        // Redirect to Filament merchant sales table
        return redirect('/merchant');
    })->name('index');
});

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__ . '/auth.php';
