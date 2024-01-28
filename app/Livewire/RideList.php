<?php

namespace App\Livewire;

use App\Models\Ride;
use Livewire\Component;
use Illuminate\Support\Facades\Http;

class RideList extends Component
{
    public $id;
    public $start_point;
    public $end_point;
    public $personCount;
    public $dep;
    public $isOpen = false;
    public $isConfirmationOpen = false; // New property for the confirmation pop-up
    public $rideDetails;

    public function mount()
    {
        // Set the default value for personCount
        $this->personCount = '';
    }

    public function render()
    {
        $rides = Ride::all();

        return view('livewire.ride-list', ['rides' => $rides]);
    }

    public function saveDriver()
    {
        $this->validate([
            'start_point' => 'required|string',
            'end_point' => 'required|string',
            'personCount' => 'required|int',
            'dep' => 'required|date_format:Y-m-d\TH:i',
        ]);

        $this->isOpen = false;


        //  $startPoint = $this->start_point;
        //  $endPoint = $this->end_point;

        $apiKey = 'AoL3QYNUBUvzjT8_69hxnDOMwWn-_fU2vIbylH-1UxgNFe0NxEJ0cHcSVzrX1fbN';

        // $response = Http::get("https://dev.virtualearth.net/REST/v1/Routes?wayPoint.1={47.610,-122.107}&waypoint.2={45.500,-121.100}&optimize=distance&dateTime=03/01/2011&maxSolutions=1&distanceUnit=km&key=$apiKey");

        $response = Http::get("http://dev.virtualearth.net/REST/V1/Routes/Driving?wp.0=redmond%2Cwa&wp.1=Issaquah%2Cwa&optimize=distance&key=$apiKey");
        $jsonResponse = json_decode($response->body(), true); // Decoding JSON into an associative array


        if (isset($jsonResponse['resourceSets'][0]['resources'][0]['travelDistance'])) {
            $distanceInKm = $jsonResponse['resourceSets'][0]['resources'][0]['travelDistance'];

            // Check if the required keys for travel duration also exist
            if (
                isset($jsonResponse['resourceSets'][0]['resources'][0]['travelDuration']) &&
                isset($jsonResponse['resourceSets'][0]['resources'][0]['durationUnit'])
            ) {
                // Extracting the duration and unit from the response
                $duration = $jsonResponse['resourceSets'][0]['resources'][0]['travelDuration'];
                $durationUnit = $jsonResponse['resourceSets'][0]['resources'][0]['durationUnit'];

                // Optionally, you can check if the unit is in seconds
                if ($durationUnit === 'Second') {
                    // You may convert seconds to a more human-readable format if needed
                    $durationFormatted = gmdate('H:i:s', $duration);
                    dd("Distance: $distanceInKm km, Duration: $durationFormatted");
                } else {
                    dd("Unexpected duration unit: $durationUnit");
                }
            } else {
                dd("Travel duration information not found in the response", $jsonResponse);
            }
        } else {
            dd("Travel distance information not found in the response", $jsonResponse);
        }



        //  $response = Http::withOptions([
        //      'base_uri' => config('services.bing.base_uri'),
        //      'verify' => config('services.bing.verify'),
        //      'cert' => config('services.bing.cert'),
        //      'ssl_key' => config('services.bing.ssl_key'),
        //      'cainfo' => config('services.bing.cainfo'),
        //  ])->get('DistanceMatrix', [
        //      'origins' => $startPoint,
        //      'destinations' => $endPoint,
        //      'travelMode' => 'driving',
        //      'key' => $apiKey,
        //  ]);
        // dd($response->body());

        // Set ride details for confirmation
        $this->rideDetails = [
            'start_point' => $this->start_point,
            'end_point' => $this->end_point,
            'personCount' => $this->personCount,
            'dep' => \Carbon\Carbon::parse($this->dep)->format('Y-m-d H:i:s'),
        ];

        // Open the confirmation pop-up
        $this->isConfirmationOpen = true;
    }

    public function confirmRide()
    {
        $personCount = $this->rideDetails['personCount'];

        // Save the ride to the database
        $ride = new Ride;
        $ride->start_point = $this->rideDetails['start_point'];
        $ride->end_point = $this->rideDetails['end_point'];
        $ride->dep = $this->rideDetails['dep'];
        $ride->save();

        // Close the confirmation pop-up
        $this->isConfirmationOpen = false;

        // Add success message to the session
        session()->flash('success', 'Rit toegevoegd');
    }

    public function cancelRide()
    {
        // Close the confirmation pop-up
        $this->isConfirmationOpen = false;
    }

    public function delete($id)
    {
        Ride::find($id)->delete();

        session()->flash('success', 'Rit verwijderd');
    }
}
