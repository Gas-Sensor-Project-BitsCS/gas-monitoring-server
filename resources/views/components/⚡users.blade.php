<?php

use App\Models\User;
use Livewire\Component;

new class extends Component {
    public $search = '';
    public $role = '';
    public $active = '';

    public function getUsersProperty()
    {
        return User::query()
            ->when($this->search, function ($query) {
                $query->where(function ($q) {
                    $q->where('name', 'like', '%' . $this->search . '%')
                        ->orWhere('email', 'like', '%' . $this->search . '%');
                });
            })
            ->when($this->role, function ($query) {
                $query->where('role', $this->role);
            })
            ->when($this->active !== '', function ($query) {
                $query->where('is_active', $this->active);
            })
            ->latest()
            ->get();
    }
    public function toggleActive($userId)
    {
        $user = User::findOrFail($userId);

        $user->update([
            'is_active' => !$user->is_active,
        ]);
    }
};
?>

<div class="p-5">
    <div class=" flex flex-row justify-between  mb-2">
        <div >
            <h1 class=" text-2xl font-semibold">
            Users
        </h1>
        <p>Manage system users and access</p>
        </div>
        <div>
            <button class=" btn-blue flex flex-row flex-nowrap  rounded p-2.5">
                <i data-lucide="plus" class="h-24px"></i>
                Add Users
            </button>
        </div>
    </div>
    <div class="card p-5 w-full">

        <div class="users-header flex flex-row flex-nowrap gap-5 justify-between w-full pb-4 pr-40">

            {{-- Search --}}
            <div class="flex-5 flex flex-row  items-center gap-2.5 border h-8 rounded">
                <i data-lucide="search" class="h-24px"></i>
                <input type="text" placeholder="Search users..." wire:model.live.debounce.300ms="search"
                    class="w-full border-0 focus:border-transparent focus:outline-none">
            </div>

            {{-- Role --}}
            <div class="flex-1">
                <select wire:model.live="role" class="h-8 border rounded">
                    <option value="">All Roles</option>
                    <option value="admin">Admin</option>
                    <option value="user">User</option>
                </select>
            </div>

            {{-- Active --}}
            <div class="flex-1">
                <select wire:model.live="active" class="h-8 border rounded">
                    <option value="">All Status</option>
                    <option value="1">Active</option>
                    <option value="0">Inactive</option>
                </select>
            </div>

        </div>


        {{-- Users table --}}

        <div class="users-table w-full">

            <table class="w-full text-left border border-gray-200 p-1.5">

                <thead class="bg-gray-200 p-1.5">
                    <tr class="p-1.5">
                        <th>Name</th>
                        <th>Email</th>
                        <th>Role</th>
                        <th>Status</th>
                        <th>Created</th>
                        <th>Actions</th>
                    </tr>
                </thead>

                <tbody class="p-1.5">

                    @forelse($this->users as $user)

                        <tr wire:key="user-{{ $user->id }}"
                            class="border border-gray-100 p-1.5">

                            <td>
                                {{ $user->name }}
                            </td>

                            <td>
                                {{ $user->email }}
                            </td>

                            <td>
                                {{ ucfirst($user->role) }}
                            </td>

                            <td>
                                @if($user->is_active)
                                    <span class="bg-green-200 rounded-2xl p-1">Active</span>
                                @else
                                    <span class="bg-red-200 rounded-2xl p-1">Inactive</span>
                                @endif
                            </td>

                            <td>
                                {{ $user->created_at->format('d M Y') }}
                            </td>
                            <td>
                                <button
                                    type="button"
                                    wire:click="toggleActive({{ $user->id }})"
                                    class="m-2 p-1.5 rounded-xl text-blue-600 bg-blue-100 hover:bg-blue-200"
                                >
                                    {{ $user->is_active ? 'Deactivate' : 'Activate' }}
                                </button>
                            </td>

                        </tr>

                    @empty

                        <tr>
                            <td colspan="6">
                                No users found.
                            </td>
                        </tr>

                    @endforelse

                </tbody>

            </table>

        </div>

    </div>
</div>