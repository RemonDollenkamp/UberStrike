<div>
    @if(session()->has('success'))
    <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mt-4" role="alert">
        <p class="font-bold">Succes!</p>
        <p>{{ session('success') }}</p>
    </div>
    @endif

    <table class="min-w-full divide-y divide-gray-200">
        <thead class="bg-gray-50">
            <tr>
                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                    Vertrektijd
                </th>
                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                    Aankomsttijd
                </th>
                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                    Beginlocatie
                </th>
                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                    Eindlocatie
                </th>
                <th scope="col" class="px-3 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                    Kostenindicatie
                </th>
                <th scope="col" class="px-3 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                    Chauffeur
                </th>
                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                    Status
                </th>
                <th scope="col" class="px-3 py-3 border-b-2 border-gray-300"></th> <!-- Placeholder for delete button styling -->


            </tr>
        </thead>
        <tbody class="bg-white divide-y divide-gray-200">
            <!-- Loop through rides and display a row for each -->
            @foreach($rides as $ride)
            <tr>
                <td class="px-6 py-4 whitespace-nowrap">
                    {{ $ride->dep }}
                </td>
                <td class="px-3 py-4 whitespace-nowrap">
                    <!-- Example: Display a button linking to the work shifts -->
                    {{ $ride->arrival }}
                </td>
                <td class="px-1 py-4 whitespace-nowrap">
                    {{ $ride->start_point }}
                </td>
                <td class="px-1 py-4 whitespace-nowrap">
                    {{ $ride->end_point }}
                </td>
                <td class="px-6 py-4 whitespace-nowrap">
                    {{ $ride->costs }} EUR
                </td>
                <td class="px-6 py-4 whitespace-nowrap">
                    {{ $ride->driver_id }}
                </td>
                <td class="px-6 py-4 whitespace-nowrap">
                    @php
                    $now = \Carbon\Carbon::now('Europe/Amsterdam');
                    $departureTime = \Carbon\Carbon::parse($ride->dep);
                    $arrivalTime = \Carbon\Carbon::parse($ride->arrival);
                    @endphp

                    @if($now > $arrivalTime)
                    compleet
                    @elseif($now >= $departureTime && $now <= $arrivalTime)
                    in rit
                    @else
                    n.v.t
                    @endif
                </td>


                <td class="px-4 py-4 whitespace-nowrap">
                    <!-- Delete button connected to the row -->
                    <button type="button" wire:click="delete({{ $ride->id }})" wire:confirm="Weet je het zeker?" class="text-red-500 hover:underline focus:outline-none">
                        Verwijder
                    </button>
                </td>

            </tr>
            @endforeach
        </tbody>
    </table>
    <div>
        <button wire:click="$toggle('isOpen')" class="fixed bottom-4 right-4 p-2 bg-blue-500 text-white rounded-full">
            +
        </button>

        <div wire:loading class="fixed top-1/2 left-1/2 transform -translate-x-1/2 -translate-y-1/2">
            <!-- Loading spinner or indicator -->
        </div>


        @if($isOpen)
        <div class="fixed top-1/2 left-1/2 transform -translate-x-1/2 -translate-y-1/2 p-4 bg-white rounded-lg shadow-md">
            <form wire:submit.prevent="saveDriver" class="flex flex-col items-center">
                <div class="mb-4">
                    <label for="start_point" class="block text-sm font-medium text-gray-700">Beginlocatie</label>
                    <input wire:model="start_point" type="text" id="start_point" name="start_point" class="mt-1 p-2 w-full border rounded-md">
                    @error('start_point') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                </div>

                <div class="mb-4">
                    <label for="end_point" class="block text-sm font-medium text-gray-700">Eindlocatie</label>
                    <input wire:model="end_point" type="text" id="end_point" name="end_point" class="mt-1 p-2 w-full border rounded-md">
                    @error('end_point') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                </div>

                <div class="mb-4">
                    <label for="personCount" class="block text-sm font-medium text-gray-700">Aantal personen</label>
                    <select wire:model="personCount" id="personCount" name="personCount" class="mt-1 p-2 w-full border rounded-md">
                        <option value="" disabled selected>Kies</option>
                        <option value="1">1</option>
                        <option value="2">2</option>
                        <option value="3">3</option>
                        <option value="4">4</option>
                    </select>
                    @error('personCount') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                </div>

                <div class="mb-4">
                    <label for="dep" class="block text-sm font-medium text-gray-700">Vertrektijd</label>
                    <input wire:model="dep" type="datetime-local" id="dep" name="dep" class="mt-1 p-2 w-full border rounded-md">
                    @error('dep') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                </div>

                <div class="flex justify-end w-full">
                    <button type="submit" class="px-4 py-2 bg-blue-500 text-white rounded-md">Maak aan</button>
                </div>
            </form>
        </div>
        @endif

        @if($isConfirmationOpen)
        <div class="fixed top-1/2 left-1/2 transform -translate-x-1/2 -translate-y-1/2 bg-white rounded-lg shadow-md max-w-md mx-auto p-6">
            <div class="text-center mb-4">
                <h2 class="text-2xl font-bold text-gray-800">Taxirit confirmatiepop-up</h2>
            </div>

            <p class="mb-2"><strong>Van:</strong> {{ $rideDetails['start_point'] }}</p>
            <p class="mb-2"><strong>Naar:</strong> {{ $rideDetails['end_point'] }}</p>
            <p class="mb-2"><strong>Vertrektijd:</strong> {{ $rideDetails['dep'] }}</p>
            <p class="mb-2"><strong>Aankomsttijd:</strong> {{ $rideDetails['arrival'] }}</p>
            <p class="mb-2"><strong>Duur:</strong> {{ $rideDetails['duration'] }} uur</p>
            <p class="mb-2"><strong>Aantal personen:</strong> {{ $rideDetails['personCount'] }}</p>
            <p class="mb-4"><strong>Afstand:</strong> {{ $rideDetails['distance'] }} km</p>
            <p class="mb-4"><strong>Kostenindicatie:</strong> {{ number_format($rideDetails['costs'], 2, ',', '.') }} EUR</p>

            <button wire:click="confirmRide" class="px-4 py-2 bg-green-500 text-white rounded-md">Ja</button>
            <button wire:click="cancelRide" class="px-4 py-2 bg-red-500 text-white rounded-md">Nee</button>
        </div>
        @endif

    </div>
</div>