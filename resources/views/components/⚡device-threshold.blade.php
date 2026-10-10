<?php

use App\Models\Device;
use Livewire\Component;

new class extends Component
{
    public $devices = [];
    public $deviceId = null;

    public $gasThreshold = null;
    public $temperatureThreshold = null;
    public $humidityThreshold = null;
    public $gasModThreshold = null;
    public $temperatureModThreshold = null;
    public $humidityModThreshold = null;

    public $successMessage = '';

    public function mount()
    {
        $this->devices = Device::get();

        if ($this->devices->isNotEmpty()) {
            $this->deviceId = $this->devices->first()->id;

            $this->loadDeviceThreshold();
        }
    }

     public function editDevice($id)
    {
        $device = Device::where('id', $id)
            //->where('user_id', auth()->id())
            ->firstOrFail();

        $this->deviceId = $device->id;

        $this->gasThreshold = $device->gas_threshold;
        $this->temperatureThreshold = $device->temperature_threshold;
        $this->humidityThreshold = $device->humidity_threshold;
        $this->gasModThreshold = $device->gas_mod_threshold;
        $this->temperatureModThreshold = $device->temperature_mod_threshold;
        $this->humidityModThreshold = $device->humidity_mod_threshold;

        $this->successMessage = '';
    }

    public function updatedDeviceId()
    {
        $this->loadDeviceThreshold();

        $this->successMessage = '';
    }

    public function loadDeviceThreshold()
    {
        $device = Device::where('id', $this->deviceId)
            // ->where('user_id', auth()->id())
            ->first();

        if (!$device) {
            return;
        }

        $this->gasThreshold = $device->gas_threshold;
        $this->temperatureThreshold = $device->temperature_threshold;
        $this->humidityThreshold = $device->humidity_threshold;
        $this->gasModThreshold = $device->gas_mod_threshold;
        $this->temperatureModThreshold = $device->temperature_mod_threshold;
        $this->humidityModThreshold = $device->humidity_mod_threshold;
    }

    public function save()
    {
        $this->validate([
            'deviceId' => ['required', 'exists:devices,id'],
            'gasThreshold' => ['required', 'numeric', 'min:0'],
            'temperatureThreshold' => ['required', 'numeric', 'min:0'],
            'humidityThreshold' => ['required', 'numeric', 'min:0', 'max:100'],
            'gasModThreshold' => ['required', 'numeric', 'min:0'],
            'temperatureModThreshold' => ['required', 'numeric', 'min:0'],
            'humidityModThreshold' => ['required', 'numeric', 'min:0', 'max:100'],
        ]);

        $device = Device::where('id', $this->deviceId)
            // ->where('user_id', auth()->id())
            ->firstOrFail();

        $device->update([
            'gas_threshold' => $this->gasThreshold,
            'temperature_threshold' => $this->temperatureThreshold,
            'humidity_threshold' => $this->humidityThreshold,
            'gas_mod_threshold' => $this->gasModThreshold,
            'temperature_mod_threshold' => $this->temperatureModThreshold,
            'humidity_mod_threshold' => $this->humidityModThreshold,
        ]);

        $this->successMessage = 'Thresholds updated successfully.';
    }
};
?>

<div class="flex justify-center flex-col gap-4" style="padding: 20px;">
    <div>
    <h1 class=" text-2xl font-semibold">
        Device Thresholds
    </h1>
    <p>Configure sensor threshold for each device</p>
    </div>
    @if ($successMessage)
        <div class="mb-6 rounded-lg bg-green-50 p-4 text-green-700">
            {{ $successMessage }}
        </div>
    @endif

    @if ($devices->isNotEmpty() && auth()->user()->role === 'admin')
        <div class="card">
        <div class="mb-6 w-1/3">
            <label class="mb-2 block font-medium">
                Select Device
            </label>

            <select
                wire:model.live="deviceId"
                class="w-full rounded-xs border px-4 py-2 h-10"
            >
                @foreach ($devices as $device)
                    <option value="{{ $device->id }}">
                        {{ $device->uid ?? $device->name  }}
                    </option>
                @endforeach
            </select>
        </div>

        <form wire:submit="save">

            <div class="grid grid-cols-1 gap-6 md:grid-cols-3">

                <div class="  p-5 shadow-sm">
                    <h2 class="mb-2 text-lg font-semibold">
                        Gas
                    </h2>

                    <label class="mb-2 block text-sm">
                        Gas Threshold (ppm) High
                    </label>

                    <input
                        type="number"
                        step="0.01"
                        wire:model="gasThreshold"
                        class="w-full rounded border px-4 py-2 h-10"
                    >

                    <label class="mb-2 block text-sm">
                        Moderate
                    </label>

                    <input
                        type="number"
                        step="0.01"
                        wire:model="gasModThreshold"
                        class="w-full rounded border px-4 py-2 h-10"
                    >

                    @error('gasThreshold')
                        <p class="mt-1 text-sm text-red-600">
                            {{ $message }}
                        </p>
                    @enderror
                </div>

                <div class=" p-5 shadow-sm">
                    <h2 class="mb-2 text-lg font-semibold">
                        Temperature
                    </h2>

                    <label class="mb-2 block text-sm">
                        Temperature Threshold (°C) High
                    </label>

                    <input
                        type="number"
                        step="0.1"
                        wire:model="temperatureThreshold"
                        class="w-full rounded border px-4 py-2 h-10"
                    >
                    <label class="mb-2 block text-sm">
                        Moderate
                    </label>
                    <input
                        type="number"
                        step="0.1"
                        wire:model="temperatureModThreshold"
                        class="w-full rounded border px-4 py-2 h-10"
                    >

                    @error('temperatureThreshold')
                        <p class="mt-1 text-sm text-red-600">
                            {{ $message }}
                        </p>
                    @enderror
                </div>

                <div class=" p-5 shadow-sm">
                    <h2 class="mb-2 text-lg font-semibold">
                        Humidity
                    </h2>

                    <label class="mb-2 block text-sm">
                        Humidity Threshold (%) High
                    </label>

                    <input
                        type="number"
                        step="0.1"
                        min="0"
                        max="100"
                        wire:model="humidityThreshold"
                        class="w-full rounded border px-4 py-2 h-10"
                    >
                    <label class="mb-2 block text-sm">
                        Moderate
                    </label>
                    <input
                        type="number"
                        step="0.1"
                        min="0"
                        max="100"
                        wire:model="humidityModThreshold"
                        class="w-full rounded border px-4 py-2 h-10"
                    >

                    @error('humidityThreshold')
                        <p class="mt-1 text-sm text-red-600">
                            {{ $message }}
                        </p>
                    @enderror
                </div>

            </div>

            <div class="mt-6 flex justify-end">
                <button
                    type="submit"
                    wire:loading.attr="disabled"
                    class="rounded-lg bg-blue-600 px-6 py-2.5 font-medium text-white
                           hover:bg-blue-700 disabled:opacity-50 h-12"
                >
                    <span wire:loading.remove>
                        Save Thresholds
                    </span>

                    <span wire:loading>
                        Saving...
                    </span>
                </button>
            </div>

        </form>
        </div>

    @else

        <div class="rounded-xl border bg-white p-8 text-center">
            <h2 class="text-lg font-semibold">
                No Devices Found
            </h2>

            <p class="mt-2 text-gray-500">
                No devices are associated with your account.
            </p>
        </div>

    @endif
    {{-- ========================= --}}
    {{-- DEVICE THRESHOLD LIST --}}
    {{-- ========================= --}}

    <div class="device-threshold-list card flex-1">

        <h2>Latest Thresholds</h2>

        @if(count($devices) > 0)

            <table class="w-full border border-gray-200">

                <thead class="w-full bg-gray-200">
                    <tr class="w-full">
                        {{-- <th>Device</th> --}}
                        <th>Device UID</th>
                        <th>Gas High</th>
                        <th>Gas Moderate</th>
                        <th>Temp High</th>
                        <th>Temp  Moderate</th>
                        <th>Humidity High</th>
                        <th>Humidity Moderate</th>
                        <th>Action</th>
                    </tr>
                </thead>

                <tbody class="text-center">

                    @foreach($devices as $device)

                        <tr class="border border-gray-100 p-1.5">

                            {{-- <td>
                                {{ $device->name }}
                            </td> --}}

                            <td>
                                {{ $device->uid }}
                            </td>

                            <td >
                                {{ $device->gas_threshold }}
                            </td>
                            <td >
                                {{ $device->gas_mod_threshold }}
                            </td>

                            <td>
                                {{ $device->temperature_threshold }}
                            </td>
                            <td>
                                {{ $device->temperature_mod_threshold }}
                            </td>

                            <td>
                                {{ $device->humidity_threshold }}
                            </td>
                            <td>
                                {{ $device->humidity_mod_threshold }}
                            </td>

                            <td>

                                <button
                                    type="button"
                                    wire:click="editDevice({{ $device->id }})"
                                    class="hover:bg-blue-100 text-blue-600 pl-2 pr-2 p-1 m-2 rounded-xl"
                                >
                                    Edit
                                </button>

                            </td>

                        </tr>

                    @endforeach

                </tbody>

            </table>

        @endif

    </div>

</div>
