<?php

namespace App\Livewire;

use App\Models\Ride;
use Livewire\Component;

class RideList extends Component
{
    public $id;

    public $start_point;
    public $end_point;
    public $personCount;
    public $dep;


    public $isOpen = false;

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

        $databaseFormat = \Carbon\Carbon::parse($this->dep)->format('Y-m-d H:i:s');
        $personCount = $this->personCount;

        $ride = new Ride;
        $ride->start_point = $this->start_point;
        $ride->end_point = $this->end_point;
        $ride->dep = $databaseFormat;

        $ride->save();

        // Add success message to the session
        session()->flash('success', 'Rit toegevoegd');

        return redirect()->route('taxiritten');
    }

    public function delete($id)
    {
        Ride::find($id)->delete();

        session()->flash('success', 'Rit verwijderd');
        return redirect()->route('taxiritten');
    }
}
