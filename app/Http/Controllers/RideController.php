<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class RideController extends Controller
{
    public function index(){
        return view("rides");
    }
}
