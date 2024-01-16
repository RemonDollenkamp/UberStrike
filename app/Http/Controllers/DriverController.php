<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Driver;
use WithPagination;

class DriverController extends Controller
{
    public $confirmDriverId;

    public function index()
    {
        // Fetch all drivers from the database
        $drivers = Driver::all();

        // Pass the drivers data to the view
        return view('drivers', ['drivers' => $drivers]);
    }

    public function destroy($id)
    {
        $driver = Driver::find($id);

        if (!$driver) {
            abort(404);
        }

        $driver->delete();

        return redirect()->action([DriverController::class, 'index']);
    }
}
