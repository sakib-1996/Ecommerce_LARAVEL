<?php

use App\Models\AvailableCountry;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\Admin\BrandController;
use App\Http\Controllers\Admin\OrdersController;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\Admin\SettingController;
use App\Http\Controllers\Frontend\ProductReviews;
use App\Http\Controllers\Frontend\UserController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\DiscountController;
use App\Http\Controllers\Admin\AdminAuthController;
use App\Http\Controllers\Admin\AdminHomeController;
use App\Http\Controllers\AvailableCountryController;
use App\Http\Controllers\Admin\SubCategoryController;
use App\Http\Controllers\AvailableDistrictController;
use App\Http\Controllers\Frontend\CheckOutController;
use App\Http\Controllers\Frontend\AddToCartController;
use App\Http\Controllers\Admin\ChildCategoryController;
use App\Http\Controllers\Frontend\ContactController;
use App\Http\Controllers\Frontend\ProductWishController;
use App\Http\Controllers\Frontend\FrontendHomeController;
use App\Http\Controllers\Frontend\UserProfilesController;

Route::get('/admin/login', function () {
    return view('admin.pages.auth.login');
})->name('admin.login');
Route::post('/admin/login', [AdminAuthController::class, 'login']);






Route::prefix('admin')->middleware('admin.auth')->group(function () {

    Route::get('/admin/logout', [AdminAuthController::class, 'logout'])->name('admin.logout');
    Route::get('/dashboard', [AdminHomeController::class, 'index'])->name('admin.dashboard');

    // category
    Route::get('/category', [CategoryController::class, 'index'])->name('admin.category');
    Route::post('/category/store', [CategoryController::class, 'storeCategory'])->name('admin.storeCategory');
    Route::get('/category/delete/{id}', [CategoryController::class, 'destroyCategory'])->name('admin.deleteCategory');
    Route::get('/category/edit/{id}', [CategoryController::class, 'editCategory'])->name('admin.editCategory');
    Route::post('/category/update', [CategoryController::class, 'updateCategory'])->name('admin.categoryUpdate');


    // Sub category
    Route::get('/subCategory', [SubCategoryController::class, 'index'])->name('admin.subCategory');
    Route::post('/subCategory/store', [SubCategoryController::class, 'storeCategory'])->name('admin.storeSubCategory');
    Route::get('/subCategory/delete/{id}', [SubCategoryController::class, 'destroySubCategory'])->name('admin.deleteSubCategory');
    Route::get('/subCategory/edit/{id}', [SubCategoryController::class, 'editSubCategory'])->name('admin.editSubCategory');
    Route::post('/subCategory/update', [SubCategoryController::class, 'updateSubCategory'])->name('admin.updateSubCategory');

    // === child category ===
    Route::get('/childCategory', [ChildCategoryController::class, 'index'])->name('admin.childCategory');
    Route::post('/childCategory/store', [ChildCategoryController::class, 'storeChildCategory'])->name('admin.storeChildCategory');
    Route::get('/childCategory/delete/{id}', [ChildCategoryController::class, 'destroyChildCategory'])->name('admin.deleteChildCategory');
    Route::get('/childCategory/edit/{id}', [ChildCategoryController::class, 'editChildCategory'])->name('admin.editChildCategory');
    Route::post('/childCategory/update', [ChildCategoryController::class, 'ChildcategoryUpdate'])->name('admin.ChildcategoryUpdate');

    // === sabCategoryByCategoyId
    Route::get('/sabCategoryByCategoyId/{id}', [ChildCategoryController::class, 'sabCategoryByCategoyId']);
    Route::get('/chlidCategoryBySabCategoyId/{id}', [ChildCategoryController::class, 'chlidCategoryBySabCategoyId']);

    // === Brand ====
    Route::get('/brand', [BrandController::class, 'index'])->name('admin.brand');
    Route::post('/admin/brand/store', [BrandController::class, 'storeBrand'])->name('admin.storeBrand');
    Route::get('/brand/delete/{id}', [BrandController::class, 'destroyBrand'])->name('admin.destroyBrand');
    Route::get('/brand/edit/{id}', [BrandController::class, 'editBrand'])->name('admin.editBrand');
    Route::post('/brand/update', [BrandController::class, 'brandUpdate'])->name('admin.brandUpdate');


    // === size =====
    Route::get('/settings/size', [SettingController::class, 'sizeIndex'])->name('settings.sizeIndex');
    Route::post('/settings/size/store', [SettingController::class, 'sizeStore'])->name('Settings.sizeStore');
    Route::get('/settings/size/edit/{id}', [SettingController::class, 'editSize'])->name('settings.editSize');
    Route::post('/settings/size/update', [SettingController::class, 'sizeUpdate'])->name('settings.sizeUpdate');
    Route::get('/settings/size/delete/{id}', [SettingController::class, 'destroySize'])->name('settings.destroySize');


    // ====== color =====
    Route::get('/settings/color', [SettingController::class, 'colorIndex'])->name('settings.colorIndex');
    Route::post('/settings/color/store', [SettingController::class, 'colorStore'])->name('Settings.colorStore');
    Route::get('/settings/color/edit/{id}', [SettingController::class, 'editColor'])->name('settings.editColor');
    Route::post('/settings/color/update', [SettingController::class, 'colorUpdate'])->name('settings.colorUpdate');
    Route::get('/settings/color/delete/{id}', [SettingController::class, 'destroyColor'])->name('settings.destroyColor');


    // ====== Available Country =====
    Route::get('/settings/available-country', [AvailableCountryController::class, 'index'])->name('settings.countryIndex');
    Route::post('/settings/available-country/store', [AvailableCountryController::class, 'addCountry'])->name('Settings.addCountry');
    Route::get('/settings/available-country/edit/{id}', [AvailableCountryController::class, 'editCountry'])->name('settings.editCountry');
    Route::post('/settings/available-country/update', [AvailableCountryController::class, 'countryUpdate'])->name('settings.countryUpdate');
    Route::get('/settings/available-country/delete/{id}', [AvailableCountryController::class, 'destroyCountry'])->name('settings.destroyCountry');



    // ====== Available District =====
    Route::get('/settings/available-country/{country}', [AvailableDistrictController::class, 'index'])->name('settings.districtIndex');
    Route::post('/settings/available-district/store', [AvailableDistrictController::class, 'addistrict'])->name('Settings.addistrict');
    Route::get('/settings/available-country/district/edit/{id}', [AvailableDistrictController::class, 'editdistrict'])->name('settings.editDiscrict');
    Route::post('/settings/available-country/district/update', [AvailableDistrictController::class, 'districtUpdate'])->name('settings.districtUpdate');
    Route::get('/settings/available-country/district/delete/{id}', [AvailableDistrictController::class, 'destroyDistrict'])->name('settings.destroyDistrict');


    // === products =====
    Route::get('/products', [ProductController::class, 'index'])->name('products.index');
    Route::get('/products/create', [ProductController::class, 'createProductPage'])->name('products.create');
    Route::post('/products/create', [ProductController::class, 'createProduct']);
    Route::get('/products/edit/{productId}', [ProductController::class, 'editeProductPage'])->name('editeProduct');
    Route::post('/products/edit/{productId}', [ProductController::class, 'updateProduct']);
    Route::get('/products/delete/{productId}', [ProductController::class, 'deleteProduct'])->name('deleteProduct');
    Route::post('/products/druft/Update/{productId}', [ProductController::class, 'ProductDruftUpdate'])->name('products.druft.update');
    Route::get('/search/productsByName', [ProductController::class, 'productsByName'])->name('products.search');


    // === products Quantity =====
    Route::get('/products/addQty/{productId}', [ProductController::class, 'addQtyPage'])->name('products.addQty');
    Route::post('/products/addQty/{productId}', [ProductController::class, 'addQty']);
    Route::get('/products/QtyById/{qtyId}', [ProductController::class, 'QtyById']);
    Route::post('/products/QtyUpdate', [ProductController::class, 'QtyUpdate'])->name('products.QtyUpdate');
    Route::post('/products/Qty/druft/Update/{qtyId}', [ProductController::class, 'QtyDruftUpdate'])->name('qty.druft.update');
    Route::get('/products/Qty/delete/{qtyId}', [ProductController::class, 'QtyDelete'])->name('Qty.delete');
    Route::get('/products/{productId}', [ProductController::class, 'QtyDetails'])->name('products.QtyDetails');

    // === products Discount =====
    Route::get('/products/discount/index/{productId}', [DiscountController::class, 'disIndex'])->name('products.disIndex');
    Route::post('/products/discount/addDis/{productId}', [DiscountController::class, 'addDis'])->name('products.addDis');
    Route::post('/products/discount/status/Update/{disId}', [DiscountController::class, 'discountStatusUpdate'])->name('discountStatusUpdate');
    Route::get('/products/discount/delete/{disId}', [DiscountController::class, 'DeleteDis'])->name('product.DeleteDis');
    Route::get('/products/discount/edit/{disId}', [DiscountController::class, 'editDiscount'])->name('admin.editDiscount');
    Route::post('/products/discount/update', [DiscountController::class, 'updateDiscount'])->name('admin.updateDiscount');


    // === orders ====
    Route::get('/orders', [OrdersController::class, 'index'])->name('ordersIndex');

    Route::post('/orders/deliveryStatus/{orderID}', [OrdersController::class, 'deliveryStatus'])->name('deliveryStatus');
    Route::get('/delivariedProduct', [OrdersController::class, 'delivariedProduct'])->name('delivariedProduct');
});
Route::get('/orders/{orderID}', [OrdersController::class, 'ordersProduct'])->name('ordersProduct');














Route::get('/login', [UserController::class, 'loginPage'])->name('login');
Route::post('/login', [UserController::class, 'login']);

Route::get('/registration', [UserController::class, 'registrationPage'])->name('registration');
Route::post('/registration', [UserController::class, 'registration']);

// frontendpages route
Route::get('/', [FrontendHomeController::class, 'homePage'])->name('home');
Route::get('/productByCategory/{catId}', [FrontendHomeController::class, 'productByCatId'])->name('productByCategory');
Route::get('/productBySubCategory/{subCatId}', [FrontendHomeController::class, 'productBySubCatId'])->name('productBySubCatId');
Route::get('/productdetails/{productId}', [FrontendHomeController::class, 'productById'])->name('productById');


// ============== contact route ==========
Route::get("/contactPage", [ContactController::class, 'ContactPage'])->name('contactPage');
Route::post("/contactMessage", [ContactController::class, 'contactMessage'])->name('contactMessage');








Route::middleware('auth')->group(function () {

    Route::get('/logout', [UserController::class, 'logout'])->name('logout');


    Route::get('/user-dashboard', [UserProfilesController::class, 'userDashboard'])->name('userDashboard');
    Route::post('/user-profileCreate', [UserProfilesController::class, 'profileCreate'])->name('profileCreate');

    // === cart ===
    Route::get('/cart', [AddToCartController::class, 'viewCart'])->name('viewCart');
    Route::post('/product/add-toCart', [AddToCartController::class, 'addToCart'])->name('addToCart');
    Route::post('/cart/update', [AddToCartController::class, 'updateCart'])->name('updateCart');
    Route::get('remove/cart_item/{itenId}', [AddToCartController::class, 'removeCartItem'])->name('removeCartItem');
    Route::post('/availabledistrict/{countryId}', [AddToCartController::class, 'availabledistrict'])->name('availabledistrict');

    // === wishlist ===
    Route::get('/wishlist', [ProductWishController::class, 'wishlist'])->name('wishlist');
    Route::get('remove/wishlist/{itemId}', [ProductWishController::class, 'removeWishlist'])->name('removeWishlist');
    Route::get('/product/add-toWishlist/{productId}', [ProductWishController::class, 'addToWish'])->name('addToWishlist');

    // === checkOut ===
    Route::get('/cart/checkOut', [CheckOutController::class, 'checkOutPage'])->name('checkOut');
    Route::post('/cart/checkOut', [CheckOutController::class, 'InvoiceCreate']);

    //payment
    Route::get("/PaymentSuccess", [CheckOutController::class, 'PaymentSuccess']);
    Route::get("/PaymentCancel", [CheckOutController::class, 'PaymentCancel']);
    Route::get("/PaymentFail", [CheckOutController::class, 'PaymentFail']);

    // Reviews 
    Route::post('/product/review', [ProductReviews::class, 'productReview'])->name('productReview');
    Route::get('/product/review/{reviewId}', [ProductReviews::class, 'deletReview'])->name('deletReview');
});


// Route::get('hello2', function () {
//     return view('frontend.pages.PaymentMethodList');
// });
