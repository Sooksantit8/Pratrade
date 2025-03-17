<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\PackageController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\FacebookAuthController;
use App\Http\Controllers\BookbankController;
use App\Http\Controllers\AuthController;

// เส้นทางที่ไม่ต้องล็อกอิน

Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login']);

Route::get('/auth/facebook', [FacebookAuthController::class, 'redirectToFacebook'])->name('auth.facebook');
Route::get('/auth/facebook/callback', [FacebookAuthController::class, 'handleFacebookCallback']);

Route::get('/', [ProductController::class, 'index'])->name('home');
Route::get('/product/tableproduct', [ProductController::class, 'table_product']);

// เส้นทางที่ต้องล็อกอิน
Route::middleware(['auth'])->group(function () {
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

    Route::get('/product/create', [ProductController::class, 'create'])->name('product.create');
    Route::get('/product/create/pricing', [PackageController::class, 'pricing'])->name('product.pricing');
    Route::post('/product/insertProduct', [ProductController::class, 'insertProduct']);
    Route::get('/product/detail/{id}', [ProductController::class, 'detail'])->name('product.detail');
    Route::post('/product/addcart/{id}', [ProductController::class, 'addCart'])->name('product.addCart');
    Route::get('/product/Showcart', [ProductController::class, 'Showcart'])->name('product.Showcart');

    Route::get('/bookbanuser', [BookbankController::class, 'bookbanuser'])->name('bookbank.bookbanuser');
    Route::get('/bookbank/datauser', [BookbankController::class, 'getbookbankuser'])->name('bookbank.datauser');
    Route::get('/bookbanuser/create', [BookbankController::class, 'createbookbankuser'])->name('bookbank.createbookbankuser');
    Route::post('/bookbank/insertBookbank', [BookbankController::class, 'insertBookbank'])->name('bookbank.insertBookbank');
    Route::post('/bookbank/Changestatusused', [BookbankController::class, 'Changestatusused'])->name('bookbank.Changestatusused');

    Route::get('/myproduct', [ProductController::class, 'myproduct'])->name('product.myproduct');
    Route::get('/myproduct/data', [ProductController::class, 'getProduct'])->name('product.data');
    Route::get('/myproduct/edit/{id}', [ProductController::class, 'edit'])->name('product.edit');

    Route::middleware('permission:P01')->group(function () {
        Route::get('/categories', [CategoryController::class, 'index'])->name('categories.index');
        Route::get('/categories/data', [CategoryController::class, 'getCategories'])->name('categories.data');
        Route::get('/categories/create', [CategoryController::class, 'create'])->name('categories.create');
        Route::post('/categories/insertCategory', [CategoryController::class, 'insertCategory'])->name('categories.insertCategory');
        Route::get('/categories/edit/{id}', [CategoryController::class, 'edit']);
        Route::post('/categories/update/{id}', [CategoryController::class, 'update'])->name('categories.update');
        Route::delete('/categories/destroy/{id}', [CategoryController::class, 'destroy']);
    
        Route::get('/package', [PackageController::class, 'index'])->name('package.index');
        Route::get('/package/data', [PackageController::class, 'getPackage'])->name('package.data');
        Route::get('/package/create', [PackageController::class, 'create'])->name('package.create');
        Route::post('/package/insertPackage', [PackageController::class, 'insertPackage'])->name('package.insertPackage');
        Route::get('/package/edit/{id}', [PackageController::class, 'edit'])->name('package.edit');
        Route::post('/package/update/{id}', [PackageController::class, 'update'])->name('package.update');
        Route::post('/package/destroy/{id}', [PackageController::class, 'destroy']);
    
        Route::get('/user', [UserController::class, 'index'])->name('user.index');
        Route::get('/user/data', [UserController::class, 'getUser'])->name('user.data');
        Route::get('/user/create', [UserController::class, 'create'])->name('user.create');
        Route::post('/user/insertUser', [UserController::class, 'insertUser'])->name('user.insertUser');
        Route::get('/user/edit/{id}', [UserController::class, 'edit'])->name('user.edit');
        Route::post('/user/update/{id}', [UserController::class, 'update'])->name('user.update');

        Route::get('/bookbank', [BookbankController::class, 'index'])->name('bookbank.index');
        Route::get('/bookbank/data', [BookbankController::class, 'getbookbank'])->name('bookbank.data');
        Route::get('/bookbank/create', [BookbankController::class, 'create'])->name('bookbank.create');
        Route::get('/bookbank/edit/{id}', [BookbankController::class, 'edit']);
        Route::post('/bookbank/update/{id}', [BookbankController::class, 'update'])->name('bookbank.update');
        Route::post('/bookbank/destroy/{id}', [BookbankController::class, 'destroy']);
    });

    Route::post('/user/paymentPackage/{packageid}', [UserController::class, 'paymentPackage'])->name('user.paymentPackage');
    Route::post('/user/purpayment/{packageid}', [UserController::class, 'purpayment'])->name('user.purpayment');
    Route::post('/user/Insertpurpayment/{id}', [UserController::class, 'Insertpurpayment'])->name('user.Insertpurpayment');
    Route::get('/user/detail/{packageid}', [UserController::class, 'detail'])->name('user.detail');
    Route::post('/user/Approve/{userid}', [UserController::class, 'Approve'])->name('user.Approve');
});