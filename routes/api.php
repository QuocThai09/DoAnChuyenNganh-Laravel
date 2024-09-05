<?php 
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\api\GoogleController;

Route::post('/get-google-sign-in-url',[GoogleController::class,'getGoogleSignUrl']);
Route::get('/call-back',[GoogleController::class,'loginCallBack']);
Route::get('/product',function(){
    return "ádhasudhu";
})->name('product');