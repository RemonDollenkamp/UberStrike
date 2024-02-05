<div>
    <div>
        @if(session()->has('success'))
        <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mt-4" role="alert">
            <p class="font-bold">Success!</p>
            <p>{{ session('success') }}</p>
        </div>
        @endif
        @if(session()->has('error'))
        <div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4 mt-4" role="alert">
            <p class="font-bold">Fout!</p>
            <p>{{ session('error') }}</p>
        </div>
        @endif

        <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-50">
                <tr>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Dag</th>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Begintijd</th>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Eindtijd</th>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Pauzetijd</th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
                @foreach($daysOfWeek as $wdayIndex => $weekdayData)
                <tr @if(isset($incorrectStatus[$wdayIndex]) && $incorrectStatus[$wdayIndex]) style="background-color: #FFC0C0;" @endif>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <input type="checkbox" id="day{{ $wdayIndex }}" wire:model="selectedDays.{{ $wdayIndex }}" wire:click="toggleWorkday('{{ $wdayIndex }}')" class="form-checkbox h-5 w-5 text-gray-600">
                        <span class="ml-2 text-gray-700">{{ $weekdayData }}</span>
                    </td>
                    @if(count($workshiftsByDay) > 0 && isset($workshiftsByDay[$wdayIndex]) && $selectedDays[$wdayIndex])
                    <!-- Inline-edit inputs for the current day -->
                    <td class="px-6 py-4 whitespace-nowrap">
                        <input wire:model.defer="workshiftsByDay.{{ $wdayIndex }}.shift_start" type="time" class="border-2 border-gray-300 p-2" @if(isset($workshiftsByDay[$wdayIndex])) value="{{ $workshiftsByDay[$wdayIndex]['shift_start'] }}" @endif>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <input wire:model.defer="workshiftsByDay.{{ $wdayIndex }}.shift_end" type="time" class="border-2 border-gray-300 p-2" @if(isset($workshiftsByDay[$wdayIndex])) value="{{ $workshiftsByDay[$wdayIndex]['shift_end'] }}" @endif>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <input wire:model.defer="workshiftsByDay.{{ $wdayIndex }}.break-time" type="text" class="border-2 border-gray-300 p-2" @if(isset($workshiftsByDay[$wdayIndex])) value="{{ $workshiftsByDay[$wdayIndex]['break-time'] }}" @endif>
                    </td>
                    @else
                    <!-- Display placeholders if no workshifts for the current day or checkbox not selected -->
                    <td class="px-6 py-4 whitespace-nowrap" colspan="3">Geen werkdag</td>
                    @endif
                </tr>
                @endforeach
            </tbody>
        </table>

        <button wire:click.prevent="saveChanges" class="my-2 mx-2 mt-4 bg-blue-500 text-white p-2 rounded">Opslaan</button>
    </div>
</div>