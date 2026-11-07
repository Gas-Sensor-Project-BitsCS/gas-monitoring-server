<?php

use App\Models\User;
use App\Models\Device;
use App\Enums\DeviceType;
use Illuminate\Support\Facades\Hash;
use Livewire\Attributes\On;
use Livewire\Component;

new class extends Component {
    public bool $showModal = false;

    public string $name = '';
    public string $location = '';
    public string $type = 'Device';
    public bool $is_active = true;

    protected $rules = [
        'name' => 'required|string|max:255',
        'location' => 'max:255',
        'type' => 'string',
        'is_active' => 'boolean',
    ];

    public function mount()
    {
        abort_unless(
            auth()->user()?->role === 'admin',
            403
        );
    }

    #[On('open-add-device')]
    public function openModal()
    {
        $this->resetValidation();

        $this->reset([
            'name',
            'location',
            'type',
        ]);

        $this->is_active = true;

        $this->showModal = true;
    }

    #[On('close-add-device')]
    public function closeModal()
    {
        $this->showModal = false;
        $this->resetValidation();
    }


    public function saveDevice()
    {
        $this->validate([
            'type' => ['required', new \Illuminate\Validation\Rules\Enum(DeviceType::class)],
            'name' => 'required|string|max:100',
            'location' => 'nullable|string|max:100',
        ]);

        Device::create([
            'type' => $this->type,
            'name' => $this->name,
            'location' => $this->location,
            'is_active' => $this->is_active,
        ]);

        // Reset fields or emit success event...
        session()->flash('message', 'Device added successfully!');
        $this->showModal = false;

        $this->reset([
            'name',
            'location',
            'type',
        ]);
        $this->is_active = true;
        // 1. Dispatch an event telling the app a device was added
        $this->dispatch('device-added');
        
    }
};
?>

<div>

    {{-- Add Device Button --}}
    <button type="button" wire:click="openModal" 
    class="btn-blue flex flex-row flex-nowrap rounded p-2">
        {{-- <i data-lucide="plus" class="h-24px"></i> --}}
        <svg class="h-5 w-5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
        </svg>
        Add Device
    </button>


    {{-- Modal --}}
    @if ($showModal)

        <div class="modal-overlay">

            <div class="modal">

                <div class="modal-header">
                    <div>
                        <h2>Add Device</h2>
                        <p>Create a new device.</p>
                    </div>

                    <button type="button" wire:click="closeModal" class="modal-close">
                        <i data-lucide="x"></i>
                    </button>
                </div>


                <form wire:submit="saveDevice">

                    {{-- Name --}}
                    <div class="form-group">
                        <label for="name">
                            Device Name
                        </label>

                        <input type="text" id="name" wire:model="name" placeholder="Enter name">

                        @error('name')
                            <span class="error">{{ $message }}</span>
                        @enderror
                    </div>


                    {{-- Location --}}
                    <div class="form-group">
                        <label for="location">
                            Location
                        </label>

                        <input type="text" id="location" wire:model="location" placeholder="location">

                        @error('location')
                            <span class="error">{{ $message }}</span>
                        @enderror
                    </div>

                    {{-- Type --}}
                    <div class="form-group">
                        <label for="type">
                            Type
                        </label>
                        <select id="type" wire:model="type" class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm p-2">
                            @foreach(App\Enums\DeviceType::cases() as $type)
                                <option value="{{ $type->value }}">
                                    {{ $type->name }} ({{ $type->value }})
                                </option>
                            @endforeach
                        </select>
                        {{-- <select id="type" wire:model="role">                                
                            <option value="ESP">
                                ESP
                            </option>

                            <option value="Arduino">
                                Arduino 
                            </option>
                            <option value="Raspberry">
                                Raspberry
                            </option>
                        </select> --}}

                        @error('type')
                            <span class="error">{{ $message }}</span>
                        @enderror
                    </div>


                    {{-- Active --}}
                    <div class="form-group checkbox-group">

                        <label>
                            <input type="checkbox" wire:model="is_active">

                            <span>
                                Active device
                            </span>
                        </label>

                    </div>


                    {{-- Actions --}}
                    <div class="modal-actions">

                        <button type="button" wire:click="closeModal" class="btn-secondary">
                            Cancel
                        </button>

                        <button type="submit" class="btn-primary">
                            <i data-lucide="plus"></i>
                            Create Device
                        </button>

                    </div>

                </form>

            </div>

        </div>

    @endif

</div>