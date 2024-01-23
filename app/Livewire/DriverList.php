<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Driver;
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
        $this->validate();

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
        Driver::find($id)->delete();

        session()->flash('success', 'Chauffeur verwijderd');
        return redirect()->route('chauffeurbeheer');
    }
}
