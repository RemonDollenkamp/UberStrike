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
                
                $startTariff = 3.25;
                $costPerKm = 2.45;
                $totalCosts = $startTariff + ($distanceInKm * $costPerKm);
                
                $departureTime = \Carbon\Carbon::parse($this->dep);
                $arrivalTime = $departureTime->copy()->addSeconds($durationInSeconds + 600); // Add duration time plus 10 minutes
                
                $roundedMinutes = ceil($arrivalTime->format('i') / 5) * 5; // Round up to the nearest 5 minutes
                $arrivalTime->setMinutes($roundedMinutes); 
                $arrivalTime->setSeconds(0);                


                $this->rideDetails = [
                    'start_point' => $this->start_point,
                    'end_point' => $this->end_point,
                    'personCount' => $this->personCount,
                    'dep' => $departureTime->format('Y-m-d H:i:s'),
                    'arrival' => $arrivalTime->format('Y-m-d H:i:s'),
                    'duration' => $durationFormatted,
                    'distance' => $distanceInKm,    
                    'costs' => $totalCosts,
                ];

                // Open the confirmation pop-up
                $this->isConfirmationOpen = true;
            } else {
                session()->flash('error', 'Er is iets fout gegaan met berekenen!');
            }
        } else {
            session()->flash('error', 'Er is iets fout gegaan met berekenen! Check of ingevulde adresgegevens of wees specifieker');
        }
    }

    public function confirmRide()
    {
        $personCount = $this->rideDetails['personCount'];
        $driverId = 1;

        $ride = new Ride;
        $ride->start_point = $this->rideDetails['start_point'];
        $ride->end_point = $this->rideDetails['end_point'];
        $ride->dep = $this->rideDetails['dep'];
        $ride->arrival = $this->rideDetails['arrival'];
        $ride->costs = $this->rideDetails['costs'];
        $ride->save();

        // Close the confirmation pop-up
        $this->isConfirmationOpen = false;

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
