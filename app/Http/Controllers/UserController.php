<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use PhpParser\Node\Stmt\TryCatch;
use Illuminate\Support\Facades\Redirect;

class UserController extends Controller
{
    public function Login(){
        return view('admin.index');
    }

    public function Logout(){
        unset($_SESSION['user']);
        return redirect()->route('login');
    }

    public function postLogin(Request $res){
        // dd($res->all());
        $data = DB::table('taikhoan')
            ->join('nhanvien','taikhoan.TAIKHOAN','=','nhanvien.TAIKHOAN')
            ->where([
                ['taikhoan.TAIKHOAN','=',$res->name],
                ['MATKHAU','=',$res->password]
            ])
            ->first();
            // chưa ktra quyền admin
            //
        if($data && $data->MAPQ == 1){
            if(!isset($_SESSION)) session_start();

            $_SESSION['user'] =  $data;
            //echo $_SESSION['login']->HOTENNV;
            return redirect()->route('home');
        }else{
            return redirect()->back()->with('error','Sai thông tin!!');
        }
    }

    public  function register(){
        return  view('admin.register');
    }
    public  function postRegister(Request $res){
        //dd(Hash::make($res->password));
        $res->merge(['password' => Hash::make($res->password)]);
        try{
            User::create($res->all());
        }catch(\Throwable $th){
            dd($th);
        }
        return redirect()->route('login');
    }
}
