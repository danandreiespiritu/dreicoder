<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ProductController;
use App\Http\Middleware\AdminMiddleware;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\BrandController;


// guest dashboard route
Route::middleware('guest')->group(function () {
    Route::get('/', function () {
        $products = Product::all();
        return view('guestDashboard', compact('products'));
    })->name('guestDashboard');
    Route::get('/', [HomeController::class, 'guestDashboard'])->name('guestDashboard');
});



// Admin index route
Route::get('/index', function () {
    return view('admin.index');
})->middleware(['auth', 'verified'])->name('index');

// Login route
if (Route::has('login')) {
    Route::get('/login', function () {
        if (auth()->check()) {
            return redirect(auth()->user()->hasRole('admin') ? 'admin/dashboard' : 'userDashboard');
        }
        return view('auth.login');
    })->name('login');
}
Route::middleware('auth')->group(function () {
    Route::get('shoppingcart', [CartController::class, 'index'])->name('cart.index');
    Route::post('cartz/add/{id}', [CartController::class, 'add'])->name('cart.add');
    Route::delete('cart/remove/{id}', [CartController::class, 'remove'])->name('cart.remove');
    Route::put('cart/update/{id}', [CartController::class, 'update'])->name('cart.update');
    Route::post('/cart/delete-selected', [CartController::class, 'deleteSelected'])->name('cart.delete.selected');
    Route::get('user/product/checkout', [CartController::class, 'checkoutView'])->name('user.product.checkout');
    Route::post('user/product/checkout', [CartController::class, 'checkout'])->name('cart.checkout'); 
    Route::post('user/product/checkout/place-an-order',[CartController::class,'place_an_order'])->name('cart.place.an.order');
    Route::get('user/product/order-confirmation',[CartController::class,'order_confirmation'])->name('user.product.order_confirmation');
});

// Authenticated user routes
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    
    Route::get('/search', [ProductController::class, 'search'])->name('products.search');
    Route::get('/profile/addAddress', [ProfileController::class, 'addressForm'])->name('profile.addAddress');
    Route::post('/profile/addAddress', [ProfileController::class, 'saveAddress']);

    Route::patch('/profile/avatar', [ProfileController::class, 'updateAvatar'])->name('profile.avatar.update');
    
    Route::get('user/product/userCart', [CartController::class, 'cart'])->name('user.product.userCart');
    Route::get('user/product/view/{categoryId}', [ProductController::class, 'userViewProductByCategory'])->name('user.product.viewByCategory');
    Route::get('dashboard', [HomeController::class, 'userDashboard'])->name('daushboard');
    Route::get('user/products', [ProductController::class, 'userViewProduct'])->name('user.product.userViewProduct');
    Route::get('user/products/featured/{id}', [ProductController::class, 'userViewFeaturedProducts'])->name('user.product.featured');
    Route::get('user/product/search', [ProductController::class, 'userSearchProduct'])->name('user.product.search');
    Route::get('user/product/categoryList', [CategoryController::class, 'userCategoryList'])->name('user.product.adminCategoryList');

    Route::get('profile/trackorder', [ProfileController::class, 'trackOrder'])->name('profile.trackorder');
    Route::get('profile/orderDetails/{orderId}', [ProfileController::class, 'viewOrderDetails'])->name('profile.viewOrderDetails');
    Route::put('profile/order/cancel/{orderId}', [ProfileController::class, 'cancelOrder'])->name('profile.cancel');
});

Route::middleware(['auth', 'admin'])->group(function () {
    Route::get('admin/dashboard', [AdminController::class, 'index'])->name('admin.index');
    Route::get('admin/product/orders', [AdminController::class, 'orders'])->name('admin.product.orders');
    Route::get('admin/category/addCategory', [CategoryController::class, 'adminAddCategory'])->name('admin.category.addCategory');
    Route::get('admin/brand/addBrand', [BrandController::class, 'adminAddBrand'])->name('admin.brand.addBrand');
    Route::post('admin/brand/addBrand', [BrandController::class, 'adminStoreBrand'])->name('admin.brand.store');
    Route::post('admin/category/addCategory', [CategoryController::class, 'adminStoreCategory'])->name('admin.category.store');
    Route::get('admin/product/viewUser', [HomeController::class, 'viewUser'])->name('admin.product.viewUser');
    Route::get('admin/product/add', [ProductController::class, 'adminAddProduct'])->name('admin.product.add');
    Route::get('admin/product/adminViewProduct', [ProductController::class, 'adminViewProduct'])->name('admin.product.adminViewProduct');
    Route::get('admin/product/userViewList', [HomeController::class, 'viewUserList'])->name('admin.product.userViewList');
    Route::get('admin/product/categoryList', [CategoryController::class, 'adminCategoryList'])->name('admin.product.adminCategoryList');   
    Route::post('admin/product/search', [ProductController::class, 'adminSearchProduct'])->name('admin.product.search');
    Route::post('admin/product/add', [ProductController::class, 'adminStoreProduct'])->name('admin.product.store');
    Route::delete('admin/product/delete/{id}', [AdminController::class, 'destroyUser'])->name('admin.user.destroy');
    Route::delete('admin/product/deleteProduct/{id}', [ProductController::class, 'adminDeleteProduct'])->name('admin.product.delete');
    Route::get('admin/product/edit/{id}', [ProductController::class, 'adminEditProduct'])->name('admin.product.edit');
    Route::put('admin/product/update/{id}', [ProductController::class, 'adminUpdateProduct'])->name('admin.product.update');
    Route::get('/orders/search', [AdminController::class, 'search'])->name('orders.search');
    // View the edit form (GET)
    Route::get('/admin/product/editProduct/{id}', [AdminController::class, 'editProductView'])->name('admin.product.editProductView');

    // Handle form submission (PUT)
    Route::put('/admin/product/editProduct/{id}', [AdminController::class, 'editProduct'])->name('admin.product.editProduct');

    // For viewing a specific transaction
    Route::get('/admin/product/transaction/{id}', [AdminController::class, 'viewOrder'])->name('admin.product.transaction');
    // For updating status
    Route::put('/orders/{id}/status', [AdminController::class, 'updateStatus'])->name('admin.orders.updateStatus');

    Route::get('/admin/product/orders/search', [AdminController::class, 'search'])->name('orders.search');

    Route::post('/orders/{order}/complete', [AdminController::class, 'complete'])->name('admin.order.complete');
    Route::post('/orders/{order}/cancel', [AdminController::class, 'cancel'])->name('admin.order.cancel');
    
});

require __DIR__.'/auth.php';
