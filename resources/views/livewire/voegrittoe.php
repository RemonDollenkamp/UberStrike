<div>
    <!-- Trigger/Open The Modal -->
    <button wire:click="openPopup">Open Modal</button>

    <!-- The Modal -->
    @if($isOpen)
        <div wire:click="closePopup" class="fixed inset-0 z-50 bg-black bg-opacity-50">
            <!-- Modal content -->
            <div class="p-4 max-w-lg mx-auto mt-12 bg-white rounded shadow-md">
                <p>Popup content goes here.</p>
            </div>
        </div>
    @endif
</div>
