<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class GestionMaterialesController extends Controller
{
    public function index(){
        return view('GestionMateriales');
    }

  
}
