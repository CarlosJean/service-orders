<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class OrdersSupController extends Controller
{
    public function index(){
        return view('ordersSup');
    }

  
}
