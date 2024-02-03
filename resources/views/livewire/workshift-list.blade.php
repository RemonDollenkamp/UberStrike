<div>
    <div>
        @if(session()->has('success'))
        <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mt-4" role="alert">
            <p class="font-bold">Succes!</p>
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
                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                        Begintijd
                    </th>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                        Eindtijd
                    </th>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                        Pauzetijd
                    </th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
                <!-- Loop through drivers and display a row for each -->
                @foreach($workshifts as $workshift)
                <tr>
                    <td class="px-6 py-4 whitespace-nowrap">
                        {{ $workshift['shift_start'] }}
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        {{ $workshift['shift_end'] }}
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        {{ $workshift['break-time'] }} min.
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
        <div>
        </div>