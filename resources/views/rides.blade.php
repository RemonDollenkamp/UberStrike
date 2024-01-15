<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Taxiritten') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                <button class="absolute bottom-4 right-4 p-2 bg-blue-500 text-white rounded-full">
                    +
                </button>
                <div class="mt-4">
    @livewire('taxiride.create-taxiride')
</div>
            </div>
        </div>
    </div>
</x-app-layout>