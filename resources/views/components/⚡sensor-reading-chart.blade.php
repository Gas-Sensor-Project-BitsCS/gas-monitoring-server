<?php

use Livewire\Component;
use App\Models\SensorData;

new class extends Component
{
    public $deviceId;
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
            ->map(fn ($reading) => [
                'gas' => $reading->gas_value,
                'temperature' => $reading->temperature,
                'humidity' => $reading->humidity,
                'time' => $reading->recorded_at?->format('H:i:s'),
            ])
            ->all();
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
    <div class="">
        <canvas id="myChart" style="height: 600px; width: 50vw;"></canvas>
    </div>
    @assets
        <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    @endassets

    @script
        <script>
            const readings = @js($this->getData());

            const canvas = $wire.$el.querySelector('canvas');

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
                    animation: {
                        duration: 500,
                        easing: 'easeOutQuart'
                    },
                    responsive: true,
                    maintainAspectRatio: false,

                    interaction: {
                        mode: 'index',
                        intersect: false,
                    },

                    scales: {
                        y: {
                            type: 'linear',
                            position: 'left',
                            title: {
                                display: true,
                                text: 'Gas Level',
                            },
                            
                        },

                        y1: {
                            type: 'linear',
                            position: 'right',
                            title: {
                                display: true,
                                text: 'Temperature and Humidity',
                            },
                            grid: {
                                drawOnChartArea: false,
                            },
                            suggestedMax: 100,
                        },

                        
                    },
                },
            });
        </script>
    @endscript
</div>
