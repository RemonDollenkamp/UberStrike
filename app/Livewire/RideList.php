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


        $startPoint = $this->start_point;
        $endPoint = $this->end_point;

        $apiKey = 'AoL3QYNUBUvzjT8_69hxnDOMwWn-_fU2vIbylH-1UxgNFe0NxEJ0cHcSVzrX1fbN';

        $response = Http::get("http://dev.virtualearth.net/REST/V1/Routes/Driving?wp.0=$startPoint&wp.1=$endPoint&optimize=distance&key=$apiKey");
        $jsonResponse = json_decode($response->body(), true); // Decoding JSON into an associative array


        if (isset($jsonResponse['resourceSets'][0]['resources'][0]['travelDistance'])) {
            $distanceInKm = $jsonResponse['resourceSets'][0]['resources'][0]['travelDistance'];

            if (isset($jsonResponse['resourceSets'][0]['resources'][0]['travelDuration'])) {
                $durationInSeconds = $jsonResponse['resourceSets'][0]['resources'][0]['travelDuration'];

                $durationFormatted = gmdate('H:i:s', $durationInSeconds);

                dd("Distance: $distanceInKm km, Duration: $durationFormatted");

                // Set ride details for confirmation
                $this->rideDetails = [
                    'start_point' => $this->start_point,
                    'end_point' => $this->end_point,
                    'personCount' => $this->personCount,
                    'dep' => \Carbon\Carbon::parse($this->dep)->format('Y-m-d H:i:s'),
                    'duration' => $durationFormatted,
                    'distance' => $distanceInKm
                ];

                // Open the confirmation pop-up
                $this->isConfirmationOpen = true;

            } else {
                dd("Travel duration information not found in the response", $jsonResponse);
            }
        } else {
            dd("Travel distance information not found in the response", $jsonResponse);
        }
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
