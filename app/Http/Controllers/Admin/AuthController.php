<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function home(){
        $role = Auth::user()->role;
        if($role == 'admin'){
            return view('Admin.index');
        }else{
            return view('welcome');
    }
    }
}
