@extends('layouts.app')
@section('title')
    Dashboard
@endsection
@section('content')
    <div class="dashboard">
        <div class="sensor-data">
            <div class="item card">
                <p>Gas Value</p>
                <p><span id="gas_value">{{ $readings?->gas_value ?? '0.00' }}</span> ppm</p>
            </div>
            <div class="item card">
                <p>Temperature</p>
                <p><span id="temperature" class="">{{ $readings?->temperature ?? '0.00' }}</span> °C</p>
                <img src="images/temp.svg" height="40px" alt="">
            </div>
            <div class="item card">
                <p>Humidity</p>
                <p><span id="humidity">{{ $readings?->humidity ?? '0.00' }}</span> %</p>
                <img src="images/humidity.svg" height="40px" alt="">
            </div>

        </div>
        <div class="message">

        </div>
        <div class="live-data-graph">
            <div class="card" id="google_chart" style=" width: 100%;"></div>
        </div>

    </div>
@endsection

@push('scripts')
    <script>
        function fetchLatestData() {
            fetch('/api/sensor-readings/latest')
                .then(response => response.json())
                .then(data => {
                    // Check if valid data returned (prevents null crashes when DB is empty)
                    if (!data || data.gas_value === undefined) return;

                    // Convert values to Numbers before calling .toFixed(2)
                    document.getElementById('gas_value').textContent = Number(data.gas_value).toFixed(2);
                    document.getElementById('temperature').textContent = Number(data.temperature).toFixed(2);
                    document.getElementById('humidity').textContent = Number(data.humidity).toFixed(2);
                });
        }

        // Fetch every 5 seconds
        setInterval(fetchLatestData, 2000);

        // Initial load
        fetchLatestData();
    </script>
    <script type="text/javascript">
        // Initialize Lucide icons if used on page
        lucide.createIcons();

        // Google Chart Logic
        google.charts.load('current', { 'packages': ['line'] });
        google.charts.setOnLoadCallback(drawChart);

        let chart, data, options;

        function drawChart() {
            data = new google.visualization.DataTable();
            data.addColumn('number', 'Day');
            data.addColumn('number', 'gas level (ppm)');

            data.addRows([
                [1, 80.8], [2, 32.4], [3, 25.7], [4, 10.5],
                [5, 10.4], [6, 7.7], [7, 9.6], [8, 10.6],
                [9, 14.8], [10, 11.6], [11, 4.7], [12, 5.2],
                [13, 3.6], [14, 3.4]
            ]);

            options = {
                legend: { position: 'bottom' },
                backgroundColor: { fill: '#1c1d2b', fillOpacity: 0.8 },
                chartArea: { backgroundColor: { fill: '#1c1d2b', fillOpacity: 0.3 } },
                chart: {
                    title: 'gas data',
                    subtitle: 'in ppm'
                }
            };

            chart = new google.charts.Line(document.getElementById('google_chart'));
            chart.draw(data, google.charts.Line.convertOptions(options));
        }

        window.addEventListener('resize', () => {
            if (chart && data && options) {
                chart.draw(data, google.charts.Line.convertOptions(options));
            }
        });
    </script>
@endpush