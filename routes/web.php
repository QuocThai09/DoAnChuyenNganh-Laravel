<?php

use App\Http\Controllers\HomeController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;
use App\Http\Middleware\CheckLogIn;
use App\Http\Controllers\ManageController;
use App\Http\Controllers\ClientController;
use App\Http\Controllers\api\GoogleController;
use App\Http\Controllers\PaymentController;
use GuzzleHttp\Client;

// Route::middleware('checklogin')->get('/',[HomeController::class,'index']);


Route::get('/login',[UserController::class,'Login'])->name('login');
Route::post('/login',[UserController::class,'postLogin'])->name('postLogin');

Route::get('/register',[UserController::class,'register']);
Route::post('/register',[UserController::class,'postRegister']);

Route::middleware('checklogin')->prefix('/admin')->group(function(){
    
    Route::get('/logout',[UserController::class,'Logout'])->name('Logout');

    //xác nhận phòng khi có customer  đặt trên clent
    Route::get('/',[HomeController::class,'index'])->name('home');
    Route::post('/filter-by-date',[HomeController::class,'filter_by_date']);
    Route::get('/xacnhanphong',[HomeController::class,'xacnhanphong'])->name('xacnhanphong');
    Route::post('/editDatPhong',[HomeController::class,'editDatPhong'])->name('editDatPhong');

    //check in phong
    Route::get('/checkin',[HomeController::class,'checkin'])->name('checkin');
    Route::post('/dsCheckIn',[HomeController::class,'dsCheckIn']);
    Route::get('/doi-phong',[HomeController::class,'changeRoom']);
    Route::post('/doi-phong',[HomeController::class,'updateRoom'])->name('updateRoom');
    Route::get('/check-in-room',[HomeController::class,'checkInRoom']);

    //check out phong
    Route::get('/checkout',[HomeController::class,'checkOut'])->name('checkout');
    Route::post('/dsCheckOut',[HomeController::class,'dsCheckOut']);
    Route::get('/su-dung-dich-vu',[HomeController::class,'useService'])->name('useService');
    Route::post('/them-dich-vu-vao-hoa-don',[HomeController::class,'addServiceToHD'])->name('add_ctPDP_DV');
    Route::get('/khach-tra-phong',[HomeController::class,'customerCheckOut']);
    Route::post('/tao-hoa-don',[HomeController::class,'createHD'])->name('createHD');

    //Hóa đơn của customer
    Route::get('/hoa-don-customer',[HomeController::class,'customerHD'])->name('customerHD');
    Route::post('/danh-sach-customer-HD',[HomeController::class,'dsCustomerHD']);
    Route::get('/xem-chi-tiet-hoa-don',[HomeController::class,'detailsHD'])->name('detailsHD');
    Route::get('/thanh-toan-hoa-don',[HomeController::class,'showPayHD']);
    Route::post('/thanh-toan-hoa-don',[HomeController::class,'payHD'])->name('payHD');

    //quản lý tài khoản
    Route::get('/tai-khoan',[ManageController::class,'account'])->name('account');
    Route::post('/create-tai-khoan',[ManageController::class,'createAccount'])->name('createAccount');
    Route::get('/delete-tai-khoan',[ManageController::class,'deleteAccount'])->name('deleteAccount');
    Route::post('/update-tai-khoan',[ManageController::class,'updateAccount'])->name('updateAccount');

    //quản lý nhân viên
    Route::get('/nhan-vien',[ManageController::class,'nhanVien'])->name('nhanVien');
    Route::post('/create-nhan-vien',[ManageController::class,'createNhanVien'])->name('createNhanVien');
    Route::get('/show-thong-tin-nhan-vien',[ManageController::class,'showNhanVien'])->name('showNhanVien');
    Route::post('/update-thong-tin-nhan-vien',[ManageController::class,'updateNhanVien'])->name('updateNhanVien');
    Route::get('/delete-thong-tin-nhan-vien',[ManageController::class,'deleteNhanVien'])->name('deleteNhanVien');

    //quản lý khách hàng
    Route::get('/khach-hang',[ManageController::class,'customer'])->name('customer');
    Route::post('/create-khach-hang',[ManageController::class,'createCustomer'])->name('createCustomer');
    Route::get('/show-khach-hang',[ManageController::class,'showCustomer'])->name('showCustomer');
    Route::post('/update-khach-hang',[ManageController::class,'updateCustomer'])->name('updateCustomer');

    //quản lý phòng
    Route::get('/phong',[ManageController::class,'room'])->name('room');
    Route::post('/create-phong',[ManageController::class,'createRoom'])->name('createRoom');
    Route::get('/show-thong-tin-phong',[ManageController::class,'showRoom'])->name('showRoom');
    Route::post('/update-phong',[ManageController::class,'updateManageRoom'])->name('updateManageRoom');
    Route::get('/delete-phong',[ManageController::class,'deleteRoom'])->name('deleteRoom');

    //quản lý sơ đồ phòng
    Route::get('/so-do-phong',[ManageController::class,'diagramRoom'])->name('diagramRoom');
    Route::post('/danh-sach-phong',[ManageController::class,'mapRoom'])->name('mapRoom');

    //quản lý dịch vụ
    Route::get('/dich-vu',[ManageController::class,'service'])->name('service');
    Route::post('/create-dich-vu',[ManageController::class,'createService'])->name('createService');
    Route::post('/update-dich-vu',[ManageController::class,'updateService'])->name('updateService');
    Route::get('/delete-dich-vu',[ManageController::class,'deleteService'])->name('deleteService');

    //quản lý loại phòng 
    Route::get('/loai-phong',[ManageController::class,'typeRoom'])->name('typeRoom');
    Route::post('/create-loai-phong',[ManageController::class,'createTypeRoom'])->name('createTypeRoom');
    Route::post('/update-loai-phong',[ManageController::class,'updateTypeRoom'])->name('updateTypeRoom');
    Route::get('/delete-loai-phong',[ManageController::class,'deleteTypeRoom'])->name('deleteTypeRoom');
    //quản lý khuyến mãi    
    Route::get('/khuyen-mai',[ManageController::class,'discount'])->name('discount');
    Route::post('/create-khuyen-mai',[ManageController::class,'createDiscount'])->name('createDiscount');
    Route::post('/update-khuyen-mai',[ManageController::class,'updateDiscount'])->name('updateDiscount');
    Route::get('/delete-khuyen-mai',[ManageController::class,'deleteDiscount'])->name('deleteDiscount');

    //test
    // Route::get('/test',[HomeController::class,'test'])->name('test');
    // Route::post('/dstest',[HomeController::class,'dstest']);
});


Route::prefix('/client')->group(function() {
    Route::get('/',[ClientController::class,'index'])->name('index');
    Route::post('/login-Client',[ClientController::class,'login'])->name('loginClient');
    Route::get('/logout-Client',[ClientController::class,'logout'])->name('logoutClient');

    //login with google
    Route::get('/get-google-sign-in-url',[GoogleController::class,'getGoogleSignUrl'])->name('login-by-google');
    Route::get('/callback',[GoogleController::class,'loginCallBack']);

    //button đặt phòng
    Route::post('/button-dat-phong',[ClientController::class,'bookRoomDetail'])->name('button-dat-phong');
    Route::post('/search-so-luong-phong-detail',[ClientController::class,'searchQuanlityRoomDetail']);

    //Đặt phòng
    Route::get('/dat-phong',[ClientController::class,'bookRoom']);
    Route::post('/search-so-luong-phong',[ClientController::class,'searchQuanlityRoom']);
    Route::post('/close-order-room',[ClientController::class,'closeOrderRoom'])->name('close-order-room');

    //Xem chi tiết phòng
    Route::get('/detail-room',[ClientController::class,'detailRoom']);

    //giỏ hàng
    Route::get('/all-lich-dat-phong',[ClientController::class,'allBookRoom'])->name('all-lich-dat-phong');
    Route::post('/remove-dat-phong',[ClientController::class,'removeBookRoom'])->name('remove-dat-phong');
    Route::post('/add-feed-back',[ClientController::class,'addFeedBack'])->name('add-feed-back');

    //Thanh toán vnpay
    Route::post('/vnpay-payment',[PaymentController::class,'vnpay_payment'])->name('vnpay-payment');
});