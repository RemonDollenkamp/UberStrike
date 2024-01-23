<?php

namespace App\Livewire;

use App\Models\Ride;
use Livewire\Component;

class RideList extends Component
{
    public $id;

    public function render()
    {
        $rides = Ride::all();

        return view('livewire.ride-list', ['rides' => $rides]);
    }

    public function delete($id)
    {
        Ride::find($id)->delete();

        session()->flash('success', 'Rit verwijderd');
        return redirect()->route('taxiritten');
    }
}
