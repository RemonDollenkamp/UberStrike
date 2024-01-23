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
            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                Kostenindicatie
            </th>
            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                Chauffeur
            </th>
            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                Status
            </th>
            <th scope="col" class="px-6 py-3 border-b-2 border-gray-300"></th> <!-- Placeholder for delete button styling -->
        </tr>
    </thead>
    <tbody class="bg-white divide-y divide-gray-200">
        <!-- Loop through rides and display a row for each -->
        @foreach($rides as $ride)
        <tr>
            <td class="px-6 py-4 whitespace-nowrap">
                {{ $ride->dep }}
            </td>
            <td class="px-6 py-4 whitespace-nowrap">
                <!-- Example: Display a button linking to the work shifts -->
                {{ $ride->arrival }}
            </td>
            <td class="px-6 py-4 whitespace-nowrap">
                {{ $ride->start_point }}
            </td>
            <td class="px-6 py-4 whitespace-nowrap">
                {{ $ride->end_point }}
            </td>
            <td class="px-6 py-4 whitespace-nowrap">
                {{ $ride->costs }}
            </td>
            <td class="px-6 py-4 whitespace-nowrap">
                {{ $ride->driver_id }}
            </td>
            <td class="px-6 py-4 whitespace-nowrap">
                 compleet 
            </td>
            <td class="px-6 py-4 whitespace-no-wrap">
                <!-- Delete button styled as a label connected to the row -->
                <button type="button" wire:click="delete({{ $ride->id }})" wire:confirm="Weet je het zeker?" class="text-red-500 hover:underline focus:outline-none">
                    Verwijder
                </button>
            </td>
        </tr>
        @endforeach
    </tbody>
</table>

</div>