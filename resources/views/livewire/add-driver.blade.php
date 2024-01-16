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