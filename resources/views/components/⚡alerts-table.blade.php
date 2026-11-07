<?php

use App\Models\Alert;
use Livewire\Component;

new class extends Component {
    public $search = '';
    public $location = '';
    public $status = '';


    public function getAlertsProperty()
    {
        return Alert::query()
            ->with('device')
            ->when($this->status !== '', function ($query) {
                $query->where('status', $this->status);
            })
            ->latest()
            ->limit(20)
            ->get();
    }
    
};
?>

<div>

    <div class="card p-5 w-full">

        <div class="users-header flex flex-row flex-nowrap gap-20  justify-end w-full pb-4 pr-40">


            {{-- Role --}}
            {{-- <div class="">
                <select wire:model.live="location" class="h-8 border rounded">
                    <option value="">Latest</option>
                    <option value="admin">Admin</option>
                    <option value="user">User</option>
                </select>
            </div> --}}

            {{-- Active --}}
            {{-- <div class="">
                <select wire:model.live="status" class="h-8 border rounded">
                    <option value="">All Status</option>
                    <option value="1">Resolved</option>
                    <option value="0">Active</option>
                </select>
            </div> --}}

        </div>


        {{-- Users table --}}

        <div class="users-table w-full">

            <table class="w-full text-left border border-gray-200 p-1.5">

                <thead class="bg-gray-200 p-1.5">
                    <tr class="p-1.5">
                        <th>id</th>
                        <th>Serverity</th>
                        <th>Message</th>
                        <th>Device id</th>
                        <th>Device Name</th>
                        <th>Status</th>
                        <th>Triggered At</th>
                        <th>Resolved At</th>
                        {{-- <th>Actions</th> --}}
                    </tr>
                </thead>

                <tbody class="p-1.5">

                    @forelse($this->alerts as $alert)

                        <tr wire:key="user-{{ $alert->id }}"
                            class="border border-gray-100 p-1.5">

                            <td class="p-2">
                                #ALT-{{ $alert->id }}
                            </td>

                            <td>
                                {{ $alert->severity }}
                            </td>
                            <td>
                                Gas Level exceeded threshold
                            </td>
                            <td>
                                {{ $alert->device->uid ?? 'Unknown Device' }}
                            </td>
                            <td>
                                {{ $alert->device->name ?? 'Unknown Device' }}
                            </td>
                                
                            <td>
                                <span class="{{ $alert->status == 'active' ? 'status-active':'status-resolved' }} pl-1.5 pr-1.5">
                                {{ ucfirst($alert->status) }}
                                </span>
                            </td>
                            <td>
                                {{ $alert->triggered_at->format('d M Y, h:i A')}}
                            </td>
                            {{-- <td>
                                @if($device->is_active)
                                    <span class="bg-green-200 rounded-2xl p-1">Active</span>
                                @else
                                    <span class="bg-red-200 rounded-2xl p-1">Inactive</span>
                                @endif
                            </td> --}}

                            <td>
                                {{ $alert->resolved_at != null ? $alert->resolved_at->format('d M Y, h:i A') : 'null'}}
                            </td>
                            {{-- <td>
                                <button
                                    type="button"
                                    wire:click="toggleActive({{ $device->id }})"
                                    class="m-2 p-1.5 rounded-xl text-blue-600 bg-blue-100 hover:bg-blue-200"
                                >
                                    {{ $device->is_active ? 'Deactivate' : 'Activate' }}
                                </button>
                                <button type="button"
                                    wire:click="deleteDevice({{ $device->id }})"
                                >
                                    <i data-lucide="trash" class="text-red-400"></i>
                                </button>
                            </td> --}}

                        </tr>

                    @empty

                        <tr>
                            <td colspan="6">
                                No Alerts found.
                            </td>
                        </tr>

                    @endforelse

                </tbody>

            </table>

        </div>

    </div>
</div>