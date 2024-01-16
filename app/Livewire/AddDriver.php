<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Driver;
use Illuminate\Support\Facades\Redirect;

class AddDriver extends Component
{
    public $isOpen = false;
    public $driverName;
    public $carNumber = 2;

    protected $rules = [
        'driverName' => 'required|string|max:36',
    ];

    public function render()
    {
        return view('livewire.add-driver');
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

        // Redirect back to the DriverController@index after saving
        return redirect()->route('chauffeurbeheer');
    }
}
