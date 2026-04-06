<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\StoreController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\ReviewController;

Route::get('/', [StoreController::class, 'index'])->name('home');
Route::get('/games', [StoreController::class, 'browse'])->name('store.browse');
Route::get('/games/{game}', [StoreController::class, 'show'])->name('store.show');

Route::get('/dashboard', function () {
    if (auth()->user()->role === 'admin') return redirect()->route('admin.dashboard');
    $orders = \App\Models\Order::with(['items.game'])->where('user_id', auth()->id())->latest()->get();
    $keysByOrder = \App\Models\GameKey::with('game')->whereIn('order_id', $orders->pluck('id'))->get()->groupBy('order_id');
    $lastOrder = $orders->first();
    return view('dashboard', compact('orders', 'keysByOrder', 'lastOrder'));
})->middleware(['auth', 'verified'])->name('dashboard');

Route::get('/my-orders', function () {
    if (auth()->user()->role === 'admin') return redirect()->route('admin.dashboard');
    $orders = \App\Models\Order::with(['items.game'])->where('user_id', auth()->id())->latest()->get();
    $keysByOrder = \App\Models\GameKey::with('game')->whereIn('order_id', $orders->pluck('id'))->get()->groupBy('order_id');
    return view('client.orders', compact('orders', 'keysByOrder'));
})->middleware(['auth', 'verified'])->name('client.orders');


Route::middleware('auth')->group(function () {
    // Reviews
    Route::post('/games/{game}/reviews', [ReviewController::class, 'store'])->name('reviews.store');
    
    // Cart Routes
    Route::get('/cart', [CartController::class, 'index'])->name('cart.index');
    Route::post('/cart/{game}', [CartController::class, 'add'])->name('cart.add');
    Route::patch('/cart/{game}', [CartController::class, 'update'])->name('cart.update');
    Route::delete('/cart/{game}', [CartController::class, 'remove'])->name('cart.remove');
    
    // Checkout Routes
    Route::get('/checkout', [CheckoutController::class, 'index'])->name('checkout.index');
    Route::post('/checkout', [CheckoutController::class, 'store'])->name('checkout.store');
    Route::get('/checkout/success/{order}', [CheckoutController::class, 'success'])->name('checkout.success');
    Route::get('/checkout/{order}/pdf', [CheckoutController::class, 'downloadPdf'])->name('checkout.pdf');
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

use App\Http\Controllers\Admin\DashboardController as AdminDashboardController;
use App\Http\Controllers\Admin\CategoryController as AdminCategoryController;
use App\Http\Controllers\Admin\GameController as AdminGameController;
use App\Http\Controllers\Admin\GameKeyController as AdminGameKeyController;
use App\Http\Controllers\Admin\OrderController as AdminOrderController;
use App\Http\Controllers\Admin\UserController as AdminUserController;

Route::prefix('admin')->name('admin.')->middleware(['auth', 'admin'])->group(function () {
    Route::get('/', [AdminDashboardController::class, 'index'])->name('dashboard');
    Route::resource('categories', AdminCategoryController::class);
    Route::resource('games', AdminGameController::class);
    Route::resource('keys', AdminGameKeyController::class);
    Route::get('orders/export', [AdminOrderController::class, 'export'])->name('orders.export');
    Route::resource('orders', AdminOrderController::class)->only(['index', 'show']);
    Route::resource('users', AdminUserController::class)->only(['index', 'destroy']);
});

require __DIR__.'/auth.php';
