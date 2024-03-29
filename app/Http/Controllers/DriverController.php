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
        return view('drivers');
    }

    public function getWorkshifts($driverId, request $request)
    {
        $incorrectStatus = $request['$incorrectStatus'];

        return view('workshifts', ['driverId' => $driverId, 'incorrectStatus' => $incorrectStatus]);
    }
}
