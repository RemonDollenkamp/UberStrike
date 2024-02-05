<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Workday;
use App\Models\Ride;
use Carbon\Carbon;


class WorkshiftList extends Component
{
    public $driverId;
    public $workshifts;
    public $selectedDays;

    public $workshiftsByDay;

    public $incorrectStatus;


    public function mount($driverId)
    {
        $this->driverId = $driverId;

        // Get days of the week
        $daysOfWeek = $this->getDaysOfWeek();

        // Initialize $selectedDays with keys corresponding to the days of the week
        $this->selectedDays = array_fill_keys(range(1, count($daysOfWeek)), false);

        // If driverId is set, fetch the workshifts and update $selectedDays
        if ($this->driverId) {
            $this->workshifts = Workday::where('driver_id', $this->driverId)->get();
            $this->updateSelectedDays();
        }
    }


    public function updateSelectedDays()
    {
        $existingWorkdays = Workday::where('driver_id', $this->driverId)->get();

        foreach ($existingWorkdays as $workday) {
            $dayOfWeek = $workday->day_of_the_week;

            // Ensure the key exists before updating
            if (isset($this->selectedDays[$dayOfWeek])) {
                $this->selectedDays[$dayOfWeek] = true;
            }
        }
    }

    public function render()
    {
        $daysOfWeek = $this->getDaysOfWeek();

        $this->workshiftsByDay = $this->organizeWorkshiftsByDay();


        //  dd($this->selectedDays);

        return view('livewire.workshift-list', [
            'daysOfWeek' => $daysOfWeek,
            'workshiftsByDay' => $this->workshiftsByDay,
            'selectedDays' => $this->selectedDays,
        ]);
    }

    private function getDaysOfWeek()
    {
        return [1 => 'Ma', 2 => 'Di', 3 => 'Wo', 4 => 'Do', 5 => 'Vr', 6 => 'Za', 7 => 'Zo'];
    }

    private function organizeWorkshiftsByDay()
    {
        $organizedWorkshifts = [];

        foreach ($this->workshifts as $workshift) {
            $dayOfWeek = $workshift->day_of_the_week;

            $organizedWorkshifts[$dayOfWeek] = [
                'shift_start' => $workshift->shift_start,
                'shift_end' => $workshift->shift_end,
                'break-time' => $workshift->break_time
            ];
        }
        return $organizedWorkshifts;
    }

    public function toggleWorkday($dayIndex)
    {
        $hasErrors = false;
        // Check the current state
        $currentState = $this->selectedDays[$dayIndex];

        if ($currentState) {
            $workshiftData = $this->workshiftsByDay[$dayIndex] ?? [
                'shift_start' => '00:00:00',
                'shift_end' => '00:00:00',
                'break-time' => 0,
            ];

            $this->updateOrCreateWorkday($dayIndex, $workshiftData);
            return redirect()->route('werktijden', ['driverId' => $this->driverId])->with('status', 1);
        } else {
            $this->deleteWorkday($dayIndex);
        }
    }

    protected function updateOrCreateWorkday($dayIndex, $workshiftData)
    {
        Workday::updateOrCreate(
            [
                'day_of_the_week' => $dayIndex,
            ],
            [
                'driver_id' => $this->driverId,
                'shift_start' => $workshiftData['shift_start'],
                'shift_end' => $workshiftData['shift_end'],
                'break_time' => $workshiftData['break-time'],
                'status' => '1'
            ]
        );
    }

    protected function deleteWorkday($dayIndex)
    {
        Workday::where('driver_id', $this->driverId)
            ->where('day_of_the_week', $dayIndex)
            ->delete();
    }

    public function saveChanges()
    {
        $incorrectStatus = [];
        $hasErrors = false;

        foreach ($this->selectedDays as $dayIndex => $isSelected) {
            // Access the values
            $shiftStart = '00:00:00';
            $shiftEnd = '00:00:00';
            $breakTime = 0;

            if ($isSelected) {
                $workshiftData = $this->workshiftsByDay[$dayIndex] ?? [
                    'shift_start' => $shiftStart,
                    'shift_end' => $shiftEnd,
                    'break-time' => $breakTime,
                ];

                $existingWorkshiftData = Workday::where('driver_id', $this->driverId)
                ->where('day_of_the_week', $dayIndex)
                ->first();
            
                $workshiftStart = Carbon::parse($existingWorkshiftData['shift_start'])->toTimeString();
                $workshiftEnd = Carbon::parse($existingWorkshiftData['shift_end'])->toTimeString();

                $conflictingRides = Ride::where(function ($query) use ($workshiftStart, $workshiftEnd, $dayIndex) {
                    $query->where(function ($subQuery) use ($workshiftStart, $workshiftEnd, $dayIndex) {
                        $subQuery->whereRaw("TIME(dep) BETWEEN ? AND ?", [$workshiftStart, $workshiftEnd])
                                 ->orWhereRaw("TIME(arrival) BETWEEN ? AND ?", [$workshiftStart, $workshiftEnd]);
                    });
                })
                ->where('driver_id', $this->driverId)
                ->whereHas('workdays', function ($subQuery) use ($dayIndex) {
                    $subQuery->where('day_of_the_week', $dayIndex);
                })
                ->get();

            
                if ($conflictingRides->isNotEmpty()) {
                    session()->flash('error', 'Voor de gekozen werktijd heeft deze chauffeur nog een rit staan! Verwijder eerst de rit of wacht totdat deze voltooid is.');
                    $incorrectStatus[$dayIndex] = true;
                    $hasErrors = true;
                    continue;
                }

                if ((isset($workshiftData['shift_start']) && $workshiftData['shift_start'] == $shiftStart)
                    || (isset($workshiftData['shift_end']) && $workshiftData['shift_end'] == $shiftEnd)
                    || (isset($workshiftData['break-time']) && $workshiftData['break-time'] == $breakTime)
                ) {

                    session()->flash('error', 'U dient voor elke actieve dag een begin-, eind- en pauzetijd in te vullen!');
                    $hasErrors = true;
                    continue;
                }

                $this->updateOrCreateWorkday($dayIndex, $workshiftData);
            } elseif (!$isSelected) {
                $this->deleteWorkday($dayIndex);
            }
        }

        $this->incorrectStatus = $incorrectStatus;

        if (!$hasErrors) {
            session()->flash('success', 'Werktijden succesvol aangepast!');
        }
    }
}
