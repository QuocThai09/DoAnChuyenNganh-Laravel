<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;

class LoginController extends Controller
{
    public function get_user(): View{
        $user = DB::table('user')->get();
        return view('product',['user'=>$user]);
    }
}
