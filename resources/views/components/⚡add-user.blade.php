<?php

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Livewire\Attributes\On;
use Livewire\Component;

new class extends Component {
    public bool $showModal = false;

    public string $name = '';
    public string $email = '';
    public string $password = '';
    public string $role = 'user';
    public bool $is_active = true;

    protected $rules = [
        'name' => 'required|string|max:255',
        'email' => 'required|email|max:255|unique:users,email',
        'password' => 'required|string|min:8',
        'role' => 'required|in:admin,user',
        'is_active' => 'boolean',
    ];

    public function mount()
    {
        abort_unless(
            auth()->user()?->role === 'admin',
            403
        );
    }

    #[On('open-add-user')]
    public function openModal()
    {
        $this->resetValidation();

        $this->reset([
            'name',
            'email',
            'password',
        ]);

        $this->role = 'user';
        $this->is_active = true;

        $this->showModal = true;
    }
    #[On('close-add-user')]
    public function closeModal()
    {
        $this->showModal = false;
        $this->resetValidation();
    }

    public function save()
    {
        $this->validate();

        User::create([
            'name' => $this->name,
            'email' => $this->email,
            'password' => Hash::make($this->password),
            'role' => $this->role,
            'is_active' => $this->is_active,
        ]);

        $this->showModal = false;

        $this->reset([
            'name',
            'email',
            'password',
        ]);

        $this->role = 'user';
        $this->is_active = true;

        $this->dispatch('user-created');
    }
};
?>

<div>

    {{-- Add User Button --}}
    <button type="button" wire:click="openModal" 
    class="btn-blue flex flex-row flex-nowrap rounded p-2">
        <i data-lucide="user-plus" class="h-24px"></i>
        Add User
    </button>


    {{-- Modal --}}
    @if ($showModal)

        <div class="modal-overlay">

            <div class="modal">

                <div class="modal-header">
                    <div>
                        <h2>Add User</h2>
                        <p>Create a new user account.</p>
                    </div>

                    <button type="button" wire:click="closeModal" class="modal-close">
                        <i data-lucide="x"></i>
                    </button>
                </div>


                <form wire:submit="save">

                    {{-- Name --}}
                    <div class="form-group">
                        <label for="name">
                            Name
                        </label>

                        <input type="text" id="name" wire:model="name" placeholder="Enter name">

                        @error('name')
                            <span class="error">{{ $message }}</span>
                        @enderror
                    </div>


                    {{-- Email --}}
                    <div class="form-group">
                        <label for="email">
                            Email
                        </label>

                        <input type="email" id="email" wire:model="email" placeholder="Enter email">

                        @error('email')
                            <span class="error">{{ $message }}</span>
                        @enderror
                    </div>


                    {{-- Password --}}
                    <div class="form-group">
                        <label for="password">
                            Password
                        </label>

                        <input type="password" id="password" wire:model="password" placeholder="Minimum 8 characters">

                        @error('password')
                            <span class="error">{{ $message }}</span>
                        @enderror
                    </div>


                    {{-- Role --}}
                    <div class="form-group">
                        <label for="role">
                            Role
                        </label>

                        <select id="role" wire:model="role">
                            <option value="user">
                                User
                            </option>

                            <option value="admin">
                                Admin
                            </option>
                        </select>

                        @error('role')
                            <span class="error">{{ $message }}</span>
                        @enderror
                    </div>


                    {{-- Active --}}
                    <div class="form-group checkbox-group">

                        <label>
                            <input type="checkbox" wire:model="is_active">

                            <span>
                                Active account
                            </span>
                        </label>

                    </div>


                    {{-- Actions --}}
                    <div class="modal-actions">

                        <button type="button" wire:click="closeModal" class="btn-secondary">
                            Cancel
                        </button>

                        <button type="submit" class="btn-primary">
                            <i data-lucide="user-plus"></i>
                            Create User
                        </button>

                    </div>

                </form>

            </div>

        </div>

    @endif

</div>