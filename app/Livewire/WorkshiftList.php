<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Workday;

class WorkshiftList extends Component
{
    public $driverId;

    public function render()
    {
        if ($this->driverId) {
            $workshifts = Workday::where('driver_id', $this->driverId)->get();

            return view('livewire.workshift-list', ['workshifts' => $workshifts]);
        } else {
            // Handle the case where $driverId is not set
            return view('livewire.workshift-list', ['workshifts' => []]);
        }
    }
}
