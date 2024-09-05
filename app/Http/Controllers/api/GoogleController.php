<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Models\KhachHang;
use App\Models\TaiKhoan;
use Exception;
use Illuminate\Http\Request;
use Laravel\Socialite\Facades\Socialite;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class GoogleController extends Controller
{
    public function getGoogleSignUrl(){
        return Socialite::driver('google')->stateless()->redirect();
    }

    public function loginCallBack(){
        try {
            $googleUser = Socialite::driver('google')->stateless()->user();
            $DBTKhoan = KhachHang::where('TAIKHOAN',$googleUser->email)->first();
            if($DBTKhoan){
                session_start();
                $_SESSION['client'] = $DBTKhoan;
                $_SESSION['successMessage'] = "Đăng nhập thành công.";
                return redirect()->route('index');
            }

            $data_max_kh = DB::table('khachhang')
                ->select(DB::raw('MAX(CAST(SUBSTRING(MAKH, 3) AS UNSIGNED)) AS max_makh'))
                ->first();
            if($data_max_kh){
                $max_kh =  $data_max_kh->max_makh;
                $new_makh = "KH" . ($max_kh) + 1;
            }else{
                $max_kh =  null;
            }
            $user = TaiKhoan::create([
                'TAIKHOAN' => $googleUser->email,
                'MATKHAU' => Hash::make('123'),
                'status' => 1,
                'MAPQ' => 3,
                'google_id' => $googleUser->id,
            ]);

            $cutomer = KhachHang::create([
                'MAKH' => $new_makh,
                'HOTENKH' => $googleUser->name,
                'LOAIKHACHHANG'=> 0,
                'TAIKHOAN' => $googleUser->email,
            ]);
            $data = DB::table('taikhoan')
                ->join('khachhang','khachhang.TAIKHOAN','=','taikhoan.TAIKHOAN')
                ->where('taikhoan.TAIKHOAN','=',$googleUser->email)
                ->first();
            session_start();
            $_SESSION['client'] = $data;
            $_SESSION['successMessage'] = "Đăng nhập thành công.";
            return redirect()->route('index');
        } catch (Exception $e) {
            dd($e); // In ra toàn bộ thông tin ngoại lệ
        }
    }
}
