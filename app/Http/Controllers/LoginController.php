<?php

namespace App\Http\Controllers;

use App\Http\Requests\LoginRequest;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;

class LoginController extends Controller
{
    public function index(){
        return View('login');
    }
    public function register(){
        return View('login');
    }
    public function handleLogin(LoginRequest $request){
        // lấy data kiểu advance
            //dd($request->all());

        // sử dụng validate giống Yii2 [nhưng nó sẽ được chuyển đến file Request]
        // $request->validate([
        //     'name'=> ['required', 'alpha' , 'min:6' , 'max:10'],
        //     'email'=> ['required', 'email'],
        //     'password'=> 'required',
        // ],
        // [
        //     'name.required' => 'The user name field is requried!',
        //     'name.alpha' => 'User name should only countain letters!',
        //     'email.required' => 'Email should only countain letters!',
        // ]);
        return $request;




        // cách lấy data kiểu basic
            // echo $_POST['name'];
            // echo $_POST['email'];
            // echo $_POST['password'];

    }
}
