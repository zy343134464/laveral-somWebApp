<?php

namespace App\Http\Controllers\Home;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class UserController extends Controller
{
    public function product(Request $request)
    {
        return view('home.user.product');
    }
    public function consumes(Request $request)
    {
        return view('home.user.consumes');
    }
    public function organ(Request $request)
    {
        return view('home.user.organ');
    }
    public function info(Request $request)
    {
        return view('home.user.info');
    }
    

}
