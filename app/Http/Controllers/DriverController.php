<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Driver;

class DriverController extends Controller
{
    public function index()
    {
        // Fetch all drivers from the database
        $drivers = Driver::all();

        // Pass the drivers data to the view
        return view('drivers', ['drivers' => $drivers]);
    }
}
