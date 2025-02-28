<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TestController;
use App\Http\Controllers\ManageProductController; 
use App\Http\Controllers\PayOnlineController;
use App\Http\Controllers\AddProductController;
use App\Http\Controllers\AdminLoginController;
use App\Http\Controllers\AdminManageOrderController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\CollectionController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\InfoProductController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\InfoAccountController;
 
use App\Http\Controllers\SearchProductController;
use App\Http\Controllers\UpdateProductController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\ManageAccountCustomerController;
use App\Http\Controllers\ManageAccountStaff;
use App\Http\Controllers\MyOrderController;
use App\Http\Controllers\ReviewProduct;
use App\Http\Controllers\SetDataController;
use App\Http\Controllers\StatisticController;
use App\Http\Controllers\VoucherController;
use App\Http\Middleware\VerifyCsrfToken;
use Illuminate\Foundation\Http\Middleware\ConvertEmptyStringsToNull;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
}); 
//Login
Route::post('signUp', [LoginController::class, 'signUp']);
Route::get('/email/verify/{id}/{hash}', [LoginController::class, 'verify']) 
->middleware(['signed'])->name('verification.verify');
Route::post('signIn', [LoginController::class, 'signIn']);
Route::post('sendMailRecoverPassword', [LoginController::class, 'sendMailRecoverPassword']);

//AdminLogin
Route::post('adminRegister', [AdminLoginController::class, 'adminRegister']);
Route::post('Adminlogin', [AdminLoginController::class, 'Adminlogin']);


Route::middleware(['auth:sanctum'])->group(function() {
    Route::post('logout', [LoginController::class, 'logout']); 

    Route::post('addToCart', [InfoProductController::class, 'addToCart']);
    // Route::post('updateQuantityProductInCart', [InfoProductController::class, 'updateQuantityProductInCart'])->withoutMiddleware([VerifyCsrfToken::class, ConvertEmptyStringsToNull::class]);
    
    //Cart
    Route::get('cartInfo', [CartController::class, 'cartInfo']);
    Route::post('updateSelectedProperty', [CartController::class, 'updateSelectedProperty']);
    Route::post('deleteItemCart', [CartController::class, 'deleteItemCart']);
    Route::post('updateQuantityProductInCart', [CartController::class, 'updateQuantityProductInCart']);


    //Payment + Payment Online VNPAY
    Route::get('infoForPayment', [PaymentController::class, 'infoForPayment']);
    Route::post('saveOrderInfo', [PaymentController::class, 'saveOrderInfo']);
    Route::post('payOnline', [PayOnlineController::class, 'payOnline']);
    
    //Payment Result
    Route::post('processPaymentResult', [PaymentController::class, 'processPaymentResult']);

    //Info Account
    Route::get('getAccountInfo', [InfoAccountController::class, 'getAccountInfo']);
    Route::post('saveAccountInfo', [InfoAccountController::class, 'saveAccountInfo']);
    Route::post('changePassword', [InfoAccountController::class, 'changePassword']);

    //MyOrder 
    Route::get('getInfoMyOrder', [MyOrderController::class, 'getInfoMyOrder']);
    Route::get('infoOrderDetail_myOder', [MyOrderController::class, 'infoOrderDetail_myOder']);
    Route::get('getQuantityOrderToDevidePage__myOder', [MyOrderController::class, 'getQuantityOrderToDevidePage__myOder']);
     
    //ReviewProduct
    Route::post('saveReviewProduct', [ReviewProduct::class, 'saveReviewProduct']);

}); 
 

//Home
Route::get('getProductAtHome', [HomeController::class, 'getProductAtHome']);

//Search Product
Route::get('search', [SearchProductController::class, 'search']);
Route::get('filterSearchProduct', [SearchProductController::class, 'filterSearchProduct']);
 
//InfoProduct
Route::get('productDetail', [InfoProductController::class, 'productDetail']);
Route::get('getProductReviews', [InfoProductController::class, 'getProductReviews']);
Route::get('getRelativeProduct', [InfoProductController::class, 'getRelativeProduct']); 

//Collection
Route::get('getQuantityCollectionToDevidePage', [CollectionController::class, 'getQuantityCollectionToDevidePage']);
Route::get('getProductCollection', [CollectionController::class, 'getProductCollection']);


Route::middleware(['auth:sanctum'])->group(function() {
    Route::middleware('abilities:admin')->group(function() { 

        //Admin - ManageAccountStaff 
        Route::get('getQuantityAccountStaffToDevidePage', [ManageAccountStaff::class, 'getQuantityAccountStaffToDevidePage']);
        Route::get('getInfoManageAccountStaff', [ManageAccountStaff::class, 'getInfoManageAccountStaff']);
        Route::post('deleteAccountStaff', [ManageAccountStaff::class, 'deleteAccountStaff']);
        Route::post('updateStatusOfAccountStaff', [ManageAccountStaff::class, 'updateStatusOfAccountStaff']);
        Route::get('searchAccountStaff', [ManageAccountStaff::class, 'searchAccountStaff']);

        //Admin - ManageAccountCustomer 
        Route::get('getQuantityAccountCustomerToDevidePage', [ManageAccountCustomerController::class, 'getQuantityAccountCustomerToDevidePage']);
        Route::get('getInfoManageAccountCustomer', [ManageAccountCustomerController::class, 'getInfoManageAccountCustomer']);
        Route::get('searchAccountCustomer', [ManageAccountCustomerController::class, 'searchAccountCustomer']);

    });

    Route::middleware(['abilities:nhanvien', 'abilities:admin'])->group(function() {
        
        //Admin - AddProduct
        Route::post('addProduct', [AddProductController::class, 'addProduct']);
    
        //Admin - ManageOrder
        Route::get('getInfoManageOrder', [AdminManageOrderController::class, 'getInfoManageOrder']);
        Route::get('infoOrderDetail', [AdminManageOrderController::class, 'infoOrderDetail']);
        Route::get('infoOrderDetail_Many', [AdminManageOrderController::class, 'infoOrderDetail_Many']);
        Route::post('saveNote', [AdminManageOrderController::class, 'saveNote']);
        Route::post('updateOrderStatus', [AdminManageOrderController::class, 'updateOrderStatus']);

        //Admin - ManageProduct
        Route::post('deleteProduct', [ManageProductController::class, 'deleteProduct']);

        //Admin - UpdateProduct
        Route::post('updateProduct', [UpdateProductController::class, 'updateProduct']);
        Route::post('updateProduct2', [UpdateProductController::class, 'updateProduct2']);
        
        
        //Admin - Voucher
        Route::post('addVoucher', [VoucherController::class, 'addVoucher']);
        Route::get('getQuantityVoucherToDevidePage', [VoucherController::class, 'getQuantityVoucherToDevidePage']);
        Route::get('getQuantityVoucherToDevidePageSearch', [VoucherController::class, 'getQuantityVoucherToDevidePageSearch']);
        Route::get('getInfoManageVoucher', [VoucherController::class, 'getInfoManageVoucher']);
        Route::get('infoVoucherDetail', [VoucherController::class, 'infoVoucherDetail']);
        Route::post('updateVoucher', [VoucherController::class, 'updateVoucher']);
        Route::get('getInfoSearchVoucher', [VoucherController::class, 'getInfoSearchVoucher']);
        Route::post('deleteVoucher', [VoucherController::class, 'deleteVoucher']);
    });

});

//Admin - AddProduct
Route::post('addProduct', [AddProductController::class, 'addProduct']);
Route::get('getInfoForAddProduct', [AddProductController::class, 'getInfoForAddProduct']);
Route::get('linkImageProduct', [AddProductController::class, 'linkImageProduct']);
Route::get('updateQuantity', [AddProductController::class, 'updateQuantity']);
Route::get('getCategory', [AddProductController::class, 'getCategory']);
 
//Admin - ManageOrder
Route::get('getQuantityOrderToDevidePage', [AdminManageOrderController::class, 'getQuantityOrderToDevidePage']);

//Admin - SearchOrder
Route::get('getInfoSearchOrder', [AdminManageOrderController::class, 'getInfoSearchOrder']);
Route::get('getQuantityOrderToDevidePage_Search', [AdminManageOrderController::class, 'getQuantityOrderToDevidePage_Search']);


Route::get('testtest', [TestController::class, 'testtest']);
Route::get('testlaythongtin', [TestController::class, 'testlaythongtin']);


//Admin - ManageProduct
Route::get('getQuantityProductToDevidePage', [ManageProductController::class, 'getQuantityProductToDevidePage']);
Route::get('getInfoManageProduct', [ManageProductController::class, 'getInfoManageProduct']);
Route::get('infoProductDetail', [ManageProductController::class, 'infoProductDetail']);

//Admin - SearchProduct
Route::get('getInfoSearchProductAdmin', [ManageProductController::class, 'getInfoSearchProductAdmin']);
Route::get('getQuantityProductToDevidePage_SearchProductAdmin', [ManageProductController::class, 'getQuantityProductToDevidePage_SearchProductAdmin']);
 

//Admin - Statistic
Route::get('statisticRevenue', [StatisticController::class, 'statisticRevenue']);
Route::get('performModifyDataset', [StatisticController::class, 'performModifyDataset']);
Route::get('statisticOrderAndPayMethod', [StatisticController::class, 'statisticOrderAndPayMethod']);
Route::get('getTopProducts', [StatisticController::class, 'getTopProducts']);
Route::get('getTopKHACHHANG', [StatisticController::class, 'getTopKHACHHANG']);

//SETDATA
Route::get('setdata', [SetDataController::class, 'setdata']);
