<?php

use App\Models\User;
use App\Models\Device;
use Illuminate\Support\Facades\Hash;
use Livewire\Attributes\On;
use Livewire\Component;

new class extends Component {
    public bool $showModal = false;

    public string $name = '';
    public string $location = '';
    public string $type = '';
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

    public function save()
    {
        $this->validate();

        Device::create([
            'name' => $this->name,
            'location' => $this->location,
            // 'type' => $this->type,
            'is_active' => $this->is_active,
        ]);

        $this->showModal = false;

        $this->reset([
            'name',
            'location',
            'type',
        ]);
        $this->is_active = true;

        $this->dispatch('user-created');
    }
};
?>

<div>

    {{-- Add User Button --}}
    <button type="button" wire:click="openModal" 
    class="btn-blue flex flex-row flex-nowrap rounded p-2">
        <i data-lucide="plus" class="h-24px"></i>
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


                <form wire:submit="save">

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

                        <input type="text" id="location" wire:model="location" placeholder="Enter email">

                        @error('location')
                            <span class="error">{{ $message }}</span>
                        @enderror
                    </div>


                    {{-- Password --}}
                    {{-- <div class="form-group">
                        <label for="password">
                            Password
                        </label>

                        <input type="password" id="password" wire:model="password" placeholder="Minimum 8 characters">

                        @error('password')
                            <span class="error">{{ $message }}</span>
                        @enderror
                    </div> --}}


                    {{-- Type --}}
                    <div class="form-group">
                        <label for="type">
                            Type
                        </label>

                        <select id="role" wire:model="role">
                            <option value="ESP">
                                ESP
                            </option>

                            <option value="Arduino">
                                Arduino 
                            </option>
                            <option value="Raspberry">
                                Raspberry
                            </option>
                        </select>

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