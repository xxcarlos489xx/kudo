<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
// use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Support\Facades\Validator;

class LoginController extends Controller{
    // use AuthenticatesUsers;
    
    public function showLoginForm(){
        if (Auth::check()) {
            return redirect()->route('dashboard');
        }
        return view('auth.login');
    }
    public function login(Request $request){
       $messages = [
            'required'  => 'El campo :attribute es requerido.',
            'email'     => 'El formato del campo :attribute es incorrecto',
            'min'       =>  'El campo :attribute debe tener como mínimo :min caracteres'
       ];
        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
            'password' => 'required|min:8',
        ],$messages);

        if ($validator->fails()) {
            
            $data = count($validator->errors()) > 0 ? implode(', ',$validator->errors()->all()) : '';
            
            return response()->json([   "message" =>$data], 401);
        }

        if (Auth::attempt(['email'=>$request->email,'password'=>$request->password])) {
            return response()->json([   "message" =>"You are loggen in"], 200);
        }else{
            return response()->json([   "message" =>"Usuario/Contraseña incorrectos"], 401);
        }
    }
    public function logout(Request $request){
        Auth::logout();
        $request->session()->invalidate();
        return redirect()->route('login');
    }
}