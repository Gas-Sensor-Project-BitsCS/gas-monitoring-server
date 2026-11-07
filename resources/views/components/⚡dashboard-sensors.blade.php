<?php

use Livewire\Component;
use Livewire\Attributes\Computed;
use App\Models\Device;

new class extends Component {
    public $selectedDeviceId = null;

    public function mount(): void
    {
        $this->selectedDeviceId = Device::query()
            ->where('is_active', true)
            ->orderBy('id')
            ->value('id');
    }

    #[Computed]
    public function devices()
    {
        return Device::query()
            ->where('is_active', true)
            ->orderBy('id')
            ->get(['id', 'name', 'uid']);
    }

    public function updatedSelectedDeviceId($value): void
    {
        // Dispatch to other Livewire components/listeners
        $this->dispatch('device-changed', deviceId: (int) $value);
    }
};
?>

<div class="p-5">

    <div class="flex items-center justify-between mb-4">
        <h2 class="text-lg font-semibold">
            Sensor Monitoring
        </h2>

        <div>
            <label for="device-selector">
                Select Device
            </label>

            {{-- <select id="device-selector" wire:model.live="selectedDeviceId"
                x-on:change="$dispatch('device-changed', { deviceId: $el.value })" class="border rounded-lg p-2"
                @disabled($this->devices->isEmpty()) class="border rounded-lg p-2">
                @foreach($this->devices as $device)
                    <option value="{{ $device->id }}">
                        {{ $device->uid }} {{  $device->name  }}
                    </option>
                @endforeach
            </select> --}}
            <select id="device-selector" 
                wire:model.live="selectedDeviceId"
                @disabled($this->devices->isEmpty()) 
                class="border rounded-lg p-2">
                @foreach($this->devices as $device)
                    <option value="{{ $device->id }}">
                        {{ $device->uid }} {{ $device->name }}
                    </option>
                @endforeach
            </select>
        </div>
    </div>

    <div data-device-selector data-device-id="{{ $selectedDeviceId }}">
        {{-- Graph components will go here --}}
    </div>

</div>