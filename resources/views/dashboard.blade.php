@extends('layouts.app')
@section('title')
    Dashboard
@endsection
@section('content')
    <div class="dashboard">
        <div class="sensor-data">
            <div class="gas-card card shadow-s" id="gas-card">
                <div class="info">
                    <div class="card-title">
                        <p>Gas Level</p>
                    </div>
                    <div class="card-data">
                        <h1 id="gas_value">{{ $readings?->gas_value ?? '0.0' }}</h1>
                        <p>PPM</p>
                    </div>

                    <div>
                        <p class="status-text" id="gas-level">Normal</p>
                        <p class="text-s">Threshold: <span id="threshold">500ppm</span></p>
                    </div>
                </div>
                <div class="card-icon">
                    <i data-lucide="cloud-alert"></i>
                </div>
            </div>

            <div class="temp-card card shadow-s" id="temp-card">
                <div class="info">
                    <div class="card-title">
                        <p>Temperature</p>
                    </div>
                    <div class="card-data">
                        <h1 id="temperature">{{ $readings?->temperature ?? '0.0' }}</h1>
                        <p>°C</p>
                    </div>
                    <p class="status-text" id="temp-level">Normal</p>
                    <p class="text-s">Threshold: <span id="threshold">40°C</span></p>
                </div>
                <div class="card-icon">
                    <svg viewBox="0 0 24 24" version="1.1" xmlns="http://www.w3.org/2000/svg" fill="currentColor">
                        <g id="SVGRepo_iconCarrier">
                            <title>ic_fluent_temperature_24_regular</title>
                            <g id="ic_fluent_temperature_24_regular" fill="currentColor" fill-rule="nonzero">
                                <path
                                    d="M12,2 C13.7330315,2 15.1492459,3.35645477 15.2448552,5.06545968 L15.25,5.24987066 L15.251,13.202 L15.3310301,13.270935 C16.2565465,14.097507 16.8481697,15.2418033 16.9745652,16.4939066 L16.9936024,16.7457024 L17,17 C17,19.7614237 14.7614237,22 12,22 C9.23857625,22 7,19.7614237 7,17 C7,15.637307 7.54959924,14.3654986 8.48922288,13.4395696 L8.66993395,13.2700735 L8.749,13.202 L8.75,5.25 C8.75,3.57886252 10.0112953,2.20231635 11.6338512,2.02039625 L11.8155761,2.00514479 L12,2 Z M12,3.5 C11.0818266,3.5 10.3288077,4.20711027 10.2558012,5.10650661 L10.25,5.25003944 L10.2495427,13.9444921 L9.94128095,14.1691409 C9.04185425,14.824607 8.5,15.8663631 8.5,17 C8.5,18.9329966 10.0670034,20.5 12,20.5 C13.9329966,20.5 15.5,18.9329966 15.5,17 C15.5,15.9375513 15.0240648,14.955799 14.2238599,14.2971002 L14.0595403,14.1697396 L13.7514995,13.9451154 L13.75,5.25 C13.75,4.28350169 12.9664983,3.5 12,3.5 Z M12,8 C12.4142136,8 12.75,8.33578644 12.75,8.75 L12.7505732,14.6146307 C13.7645539,14.9333735 14.5,15.8808004 14.5,17 C14.5,18.3807119 13.3807119,19.5 12,19.5 C10.6192881,19.5 9.5,18.3807119 9.5,17 C9.5,15.8804347 10.2359268,14.9327543 11.250421,14.6143184 L11.25,8.75 C11.25,8.33578644 11.5857864,8 12,8 Z"
                                    id="🎨-Color"></path>
                            </g>
                        </g>
                    </svg>

                </div>
            </div>

            <div class="humidity-card card shadow-s" id="humidity-card">
                <div class="info">
                    <div class="card-title">
                        <p>Humidity</p>
                    </div>
                    <div class="card-data">
                        <h1 id="humidity">{{ $readings?->humidity ?? '0.0' }}</h1>
                        <p>%</p>
                    </div>
                    <p class="status-text" id="humidity-level">Normal</p>
                    <p class="text-s">Threshold: <span id="threshold">85%</span></p>
                </div>
                <div class="card-icon">
                    <i data-lucide="droplets"></i>
                </div>
            </div>

            <div class="device-card card shadow-s offline" id="deviceCard">
                <div class="info">
                    <div class="card-title">
                        <p>Device Status</p>
                    </div>
                    <div class="card-data">
                        <h1 class="status-text" id="device-status">Offline</h1>
                    </div>
                    <div class="info-last-div">
                        <p>ESP32-Device 01</p>
                        {{-- <p class="text-s">Uptime: <span id="uptime">2h 45m</span></p> --}}
                        <p class="text-s">Location: <span id="uptime">Lab - room 101</span></p>
                    </div>
                </div>
                <div class="card-icon">
                    <i data-lucide="wifi"></i>
                </div>
            </div>

            <div class="alert-card card shadow-s high">
                <div class="info">
                    <div class="card-title">
                        <p>Active Alerts</p>
                    </div>
                    <div class="card-data">
                        <h1 class="status-text" id="active-alerts">0</h1>
                    </div>
                    <div class="info-last-div">
                        <p>Unresolved Alerts</p>
                        <p style="color: #006dff;">View all alerts →</p>
                    </div>
                </div>
                <div class="card-icon">
                    <i data-lucide="triangle-alert"></i>

                </div>
            </div>

        </div>
        <div class="info-data">
            <div class="recent-alerts-card card shadow-s">
                <div class="card-title">
                    <p>Recent Alerts</p>
                    <p class="card-title-right link">View All</p>
                </div>
                <div id="alert-container">

                </div>
            </div>
            {{-- <div class="device-info card shadow-s">
                <div class="card-title">
                    <p>Device Information</p>
                    <p class="card-title-right status-online">Online</p>
                </div>
            </div> --}}
        </div>
    </div>
@endsection

@push('scripts')
    <script>

        const levelMap = {
            0: "normal",
            1: "moderate",
            2: "high"
        };
        let Alerts= [];
        const gasCard = document.getElementById('gas-card');
        const gasLevel = document.getElementById('gas-level')
        const tempCard = document.getElementById('temp-card');
        const tempLevel = document.getElementById('temp-level')
        const humidityCard = document.getElementById('humidity-card');
        const humidityLevel = document.getElementById('humidity-level')
        const deviceCard = document.getElementById('deviceCard');

        function setLevel(div, levelText, sensor_val, high, moderate, alertType) {
            var i = 0;
            div.classList.remove('normal', 'moderate', 'high');

            if (sensor_val >= high) {
                i = 2;
                // alerts.set(alertType, 'high');
            }
            else if (sensor_val >= moderate) i = 1;
            else i = 0;

            levelText.textContent = levelMap[i];
            div.classList.add(levelMap[i]);
        }
        function isOnline(timeStamp, threshold) {
            const diff = (Date.now() - new Date(timeStamp).getTime()) / 1000;
            const statusText = document.getElementById('device-status');
            if (diff > threshold) {
                deviceCard.classList.remove('online', 'offline');
                statusText.textContent = 'Offline';
                deviceCard.classList.add('offline');

            }
            else {
                deviceCard.classList.remove('online', 'offline');
                statusText.textContent = 'Online';
                deviceCard.classList.add('online');
            }
        }
        function fetchLatestData() {
            fetch('/api/sensor-readings/latest')
                .then(response => response.json())
                .then(data => {
                    // Check if valid data returned (prevents null crashes when DB is empty)
                    if (!data || data.gas_value === undefined) return;
                    console.log(data);
                    // Convert values to Numbers before calling .toFixed(1)
                    document.getElementById('gas_value').textContent = Number(data.gas_value).toFixed(1);
                    document.getElementById('temperature').textContent = Number(data.temperature).toFixed(1);
                    document.getElementById('humidity').textContent = Number(data.humidity).toFixed(1);


                    setLevel(gasCard, gasLevel, data.gas_value, 500, 300, 'gas');
                    setLevel(tempCard, tempLevel, data.temperature, 41, 31, 'temperature');
                    setLevel(humidityCard, humidityLevel, data.humidity, 85, 70, 'humidity');
                    isOnline(data.recorded_at, 15);
                });
        }
        function fetchRecentAlerts() {
            fetch('/api/alerts')
                .then(response => response.json())
                .then(data => {
                    // Check if valid data returned (prevents null crashes when DB is empty)
                    if (!data || data.alerts === undefined) return;
                    console.log(data.alerts.data);
                    Alerts = data.alerts.data;
                    var activeAlert = 0;
                    Alerts.forEach(alert => {if(alert.status == 'active') activeAlert++;})
                    document.getElementById('active-alerts').textContent = `${activeAlert}`;
                    displayAlerts();

                });
        }
        function displayAlerts() {
            const container = document.getElementById('alert-container');

            container.innerHTML = '';

            Alerts.forEach(alert => {
                const alertElement = document.createElement('div');

                alertElement.innerHTML = `
                <div class="alert ${alert.status == 'active'?  'alert-active':'alert-resolved'}" style="display:flex; flex-direction:row; align-items:center;justify-content: space-between; border-radius:5px">
                    <div class="icon high">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" data-lucide="triangle-alert" aria-hidden="true" class="lucide lucide-triangle-alert"><path d="m21.73 18-8-14a2 2 0 0 0-3.48 0l-8 14A2 2 0 0 0 4 21h16a2 2 0 0 0 1.73-3"></path><path d="M12 9v4"></path><path d="M12 17h.01"></path></svg>
                    </div>
                    <strong>${alert.severity.toUpperCase()}</strong>
                    <span>Gas Level exceeded threshold</span>
                    <span class="status">${alert.status}</span>
                    <span>${new Date(alert.triggered_at).toLocaleTimeString([], { hour: '2-digit', minute: '2-digit',hour12: true,
  timeZone: 'Asia/Kolkata' })}</span>
                </div>
            `;

                container.appendChild(alertElement);
            });
        }

        // Fetch every 2 seconds 
        setInterval(fetchLatestData, 2000);
        setInterval(fetchRecentAlerts, 3000);
        // Initial load
        fetchLatestData();
        fetchRecentAlerts();
        
    </script>
    <script type="text/javascript">
        // Initialize Lucide icons if used on page
        lucide.createIcons();

        // // Google Chart Logic
        // google.charts.load('current', { 'packages': ['line'] });
        // google.charts.setOnLoadCallback(drawChart);

        // let chart, data, options;

        // function drawChart() {
        //     data = new google.visualization.DataTable();
        //     data.addColumn('number', 'Day');
        //     data.addColumn('number', 'gas level (ppm)');

        //     data.addRows([
        //         [1, 80.8], [2, 32.4], [3, 25.7], [4, 10.5],
        //         [5, 10.4], [6, 7.7], [7, 9.6], [8, 10.6],
        //         [9, 14.8], [10, 11.6], [11, 4.7], [12, 5.2],
        //         [13, 3.6], [14, 3.4]
        //     ]);

        //     options = {
        //         legend: { position: 'bottom' },
        //         backgroundColor: { fill: '#1c1d2b', fillOpacity: 0.8 },
        //         chartArea: { backgroundColor: { fill: '#1c1d2b', fillOpacity: 0.3 } },
        //         chart: {
        //             title: 'gas data',
        //             subtitle: 'in ppm'
        //         }
        //     };

        //     chart = new google.charts.Line(document.getElementById('google_chart'));
        //     chart.draw(data, google.charts.Line.convertOptions(options));
        // }

        // window.addEventListener('resize', () => {
        //     if (chart && data && options) {
        //         chart.draw(data, google.charts.Line.convertOptions(options));
        //     }
        // });
    </script>
@endpush