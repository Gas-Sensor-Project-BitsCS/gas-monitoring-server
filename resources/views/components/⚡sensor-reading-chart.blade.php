<?php

use Livewire\Component;
use Livewire\Attributes\On;
use App\Models\SensorData;

new class extends Component {
    public $deviceId;

    public function mount($deviceId = null)
    {
        $this->deviceId = $deviceId;
    }

    public function getData(): array
    {
        return SensorData::query()
            ->where('device_id', $this->deviceId)
            ->latest('recorded_at')
            ->limit(100)
            ->get([
                'gas_value',
                'temperature',
                'humidity',
                'recorded_at',
            ])
            ->reverse()
            ->values()
            ->map(fn($reading) => [
                'gas' => $reading->gas_value,
                'temperature' => $reading->temperature,
                'humidity' => $reading->humidity,
                'time' => $reading->recorded_at?->format('H:i:s'),
            ])
            ->all();
    }

    #[On('device-changed')]
    public function changeDevice($deviceId)
    {
        $this->deviceId = (int) $deviceId;

        // $this->dispatch(
        //     'sensor-chart-updated',
        //     readings: $this->getData(),
        //     deviceId: $this->deviceId
        // );
    } 

    public function loadDeviceData($deviceId)
    {
        $this->deviceId = (int) $deviceId;

        $this->dispatch(
            'sensor-chart-updated',
            readings: $this->getData(),
            deviceId: $this->deviceId
        );
    }
};
?>

<div class="flex flex-col card flex-2">
    <div>
        <div>
            <h2>Live Sensor Readings</h2>
        </div>
        <div></div>
        <div></div>
    </div>
    <div class="" wire:ignore>
        <canvas id="myChart" style="height: 600px; width: 50vw;"></canvas>
    </div>
    @assets
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    @endassets

    @script
    <script>
        const readings = @js($this->getData());
        const canvas = $wire.$el.querySelector('#myChart');

        const chart = new Chart(canvas, {
            type: 'line',
            data: {
                labels: readings.map(r => r.time),
                datasets: [
                    {
                        label: 'Gas Level',
                        data: readings.map(r => r.gas),
                        borderColor: '#ef4444',
                        backgroundColor: 'rgba(239, 68, 68, 0.1)',
                        yAxisID: 'y',
                        tension: 0.3,
                        spanGaps: true,
                        fill: true, 
                    },
                    {
                        label: 'Temperature (°C)',
                        data: readings.map(r => r.temperature),
                        borderColor: '#3b82f6',
                        backgroundColor: 'rgba(59, 130, 246, 0.1)',
                        yAxisID: 'y1',
                        tension: 0.3,
                        spanGaps: true,
                    },
                    {
                        label: 'Humidity (%)',
                        data: readings.map(r => r.humidity),
                        borderColor: 'green',
                        backgroundColor: 'rgba(100, 130, 246, 0.1)',
                        yAxisID: 'y1',
                        tension: 0.3,
                        spanGaps: true,
                    },
                ],
            },
            options: {
                animation: { duration: 500, easing: 'easeOutQuart' },
                responsive: true,
                maintainAspectRatio: false,
                interaction: { mode: 'index', intersect: false },
                scales: {
                    y: { type: 'linear', position: 'left', title: { display: true, text: 'Gas Level' } },
                    y1: { type: 'linear', position: 'right', title: { display: true, text: 'Temperature and Humidity' }, grid: { drawOnChartArea: false }, suggestedMax: 100 }
                },
            },
        });


        // 1. Listen to the global window event dispatched by your device selector component
        window.addEventListener('device-changed', (event) => {
            // Support both direct detail value or custom payload wrapper
            const newDeviceId = event.detail.deviceId || event.detail[0];
            if (newDeviceId) {
                // Call the PHP method in this Livewire component
                $wire.loadDeviceData(newDeviceId);
            }
        });

        // 2. Listen for the response from PHP when new device readings are fetched
        $wire.on('sensor-chart-updated', (event) => {
            // Livewire 3 passes event data as an array or object payload
            const payload = Array.isArray(event) ? event[0] : event;
            const newReadings = payload.readings || [];

            chart.data.labels = newReadings.map(r => r.time);
            chart.data.datasets[0].data = newReadings.map(r => r.gas);
            chart.data.datasets[1].data = newReadings.map(r => r.temperature);
            chart.data.datasets[2].data = newReadings.map(r => r.humidity);

            chart.update('none');
        });

        // Function to handle incoming live sensor reading packets
        window.appendLiveSensorReading = function (reading) {

            // // Ensure the reading belongs to the currently active device
            // if (Number(reading.device_id) !== Number(@js($this->deviceId))) {
            //     return;
            // }
            // Compare directly against the global selectedDeviceId variable
            if (Number(reading.device_id) !== Number(selectedDeviceId)) {
                return;
            }
            // Format timestamp (e.g., '14:32:05')
            const timeLabel = new Date(reading.recorded_at || Date.now()).toLocaleTimeString([], {
                hour: '2-digit',
                minute: '2-digit',
                second: '2-digit',
                hour12: false
            });

            // Push new labels and data points
            chart.data.labels.push(timeLabel);
            chart.data.datasets[0].data.push(reading.gas_value);
            chart.data.datasets[1].data.push(reading.temperature);
            chart.data.datasets[2].data.push(reading.humidity);

            // Limit the chart to display only the last 30 data points (sliding window)
            const maxDataPoints = 30;
            if (chart.data.labels.length > maxDataPoints) {
                chart.data.labels.shift();
                chart.data.datasets.forEach(dataset => dataset.data.shift());
            }

            // Fast update without re-triggering entrance animations
            chart.update('none');
        };

    </script>
    @endscript
</div>