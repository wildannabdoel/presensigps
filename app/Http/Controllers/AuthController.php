<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function proseslogin(Request $request){
        if(Auth::guard('karyawan')->attempt([
            'nik' => $request->nik,
            'password' => $request->password,
        ])){
            return redirect('/dashboard');
        }else{
            return redirect('/')->with(['warning' => 'NIK atau Password Salah']);
        }
        
    }

    public function proseslogout(){
        if(Auth::guard('karyawan')->check()){
           Auth::guard('karyawan')->logout();
        }
           return redirect('/');
    }
    public function prosesloginadmin(Request $request){
        if(Auth::guard('user')->attempt([
            'email' => $request->email,
            'password' => $request->password,
        ])){    
            return redirect('/panel/dashboardadmin');
        }else{
            return redirect('/panel')->with(['warning' => 'Email atau Password Salah']);
        }
        
    }
    public function proseslogoutadmin(){
        if(Auth::guard('user')->check()){
           Auth::guard('user')->logout();
        }
           return redirect('/panel');
    }

}
