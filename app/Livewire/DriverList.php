<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Driver;
use App\Models\Ride;
use Illuminate\Support\Facades\Redirect;

class DriverList extends Component
{
    public $id;

    public $isOpen = false;
    public $driverName;
    public $carNumber = 2;

    protected $rules = [
        'driverName' => 'required|string|max:36',
    ];

    public function render()
    {
        $drivers = Driver::all();

        return view('livewire.driver-list', ['drivers' => $drivers]);
    }

    public function closeModal()
    {
        $this->isOpen = false;
    }

    public function saveDriver()
    {
        $this->validate([
            'driverName' => 'required|min:2'
        ], [
            'driverName.required' => 'U dient een naam in te vullen van minimaal 2 karakters!',
            'driverName.min' => 'U dient een naam in te vullen van minimaal 2 karakters!'
        ]);
        
        // Save the driver to the database
        Driver::create([
            'fullname' => $this->driverName,
            'car' => $this->carNumber,
        ]);

            // Add success message to the session
        session()->flash('success', 'Chauffeur toegevoegd');

        // Redirect back to the DriverController@index after saving
        return redirect()->route('chauffeurbeheer');
    }

    public function delete($id)
    {
        // Check if there are associated rides with the given driver_id
        if (Ride::where('driver_id', $id)->exists()) {
            // If there are associated rides, you may want to handle this case (e.g., show a message or prevent deletion)
            session()->flash('error', 'Er zijn nog ritten gekoppeld aan deze chauffeur. Verwijder eerst de ritten.');
        } else {
            // If no associated rides, proceed to delete the Driver record
            Driver::find($id)->delete();
            session()->flash('success', 'Chauffeur verwijderd');
        }
    
        return redirect()->route('chauffeurbeheer');
    }
    
}
