<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Chauffeurbeheer') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
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
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        <!-- Loop through drivers and display a row for each -->
                        @foreach($drivers as $driver)
                            <tr>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    {{ $driver['full-name'] }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <!-- Example: Display a button linking to the work shifts -->
                                    <a href="{{ route('login', $driver->id) }}" class="text-blue-500 hover:underline">Bekijk</a>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    {{ $driver->car }}
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <livewire:add-driver />
</x-app-layout>
