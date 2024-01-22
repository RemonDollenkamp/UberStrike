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
                    Chauffeur-naam
                </th>
                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                    Werktijden
                </th>
                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                    auto
                </th>
                <th class="px-6 py-3 border-b-2 border-gray-300"></th>
            </tr>
        </thead>
        <tbody class="bg-white divide-y divide-gray-200">
            <!-- Loop through drivers and display a row for each -->
            @foreach($drivers as $driver)
            <tr>
                <td class="px-6 py-4 whitespace-nowrap">
                    {{ $driver['fullname'] }}
                </td>
                <td class="px-6 py-4 whitespace-nowrap">
                    <!-- Example: Display a button linking to the work shifts -->
                    <a href="{{ route('login', $driver->id) }}" class="text-blue-500 hover:underline">Bekijk</a>
                </td>
                <td class="px-6 py-4 whitespace-nowrap">
                    {{ $driver->car }}
                </td>
                <td class="px-6 py-4 whitespace-no-wrap text-right border-b border-gray-200">
                    <button type="button" wire:click="delete({{ $driver->id }})" wire:confirm="Weet je het zeker?">Verwijder</button>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
    <div>
        <button wire:click="$toggle('isOpen')" class="fixed bottom-4 right-4 p-2 bg-blue-500 text-white rounded-full">
            +
        </button>

        @if($isOpen)
        <!-- Your add driver form or content goes here -->
        <button wire:click="closeModal" class="fixed inset-0"></button>

        <div class="fixed bottom-4 right-4 p-4 bg-white rounded-lg shadow-md">
            <div class="fixed bottom-4 right-4 p-4 bg-white rounded-lg shadow-md">
                <h2 class="text-lg font-semibold mb-4">Chauffeur toevoegen</h2>

                <form wire:submit.prevent="saveDriver">
                    <div class="mb-4">
                        <label for="driverName" class="block text-sm font-medium text-gray-700">naam</label>
                        <input wire:model="driverName" type="text" id="driverName" name="driverName" class="mt-1 p-2 w-full border rounded-md">
                        @error('driverName') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                    </div>

                    <div class="flex justify-end">
                        <button type="submit" class="px-4 py-2 bg-blue-500 text-white rounded-md">Maak aan</button>
                    </div>
                </form>
            </div>
            @endif
        </div>
    </div>