
<?php

use Livewire\Component;
use Livewire\Attributes\Computed;
use App\Models\Device;

new class extends Component
{
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
        $this->dispatch(
            'device-changed',
            deviceId: (int) $value
        );
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

            <select
                id="device-selector"
                wire:model.live="selectedDeviceId"
                class="border rounded-lg p-2"
                @disabled($this->devices->isEmpty())
            >
                @foreach($this->devices as $device)
                    <option value="{{ $device->id }}">
                        ESP32-{{ $device->id }}  {{  $device->name  }}
                    </option>
                @endforeach
            </select>
        </div>
    </div>

    <div
        data-device-selector
        data-device-id="{{ $selectedDeviceId }}"
    >
        {{-- Graph components will go here --}}
    </div>
</div>
