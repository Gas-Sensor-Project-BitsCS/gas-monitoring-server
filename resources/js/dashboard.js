let gasHigh = 500
let tempHigh = 40
let humidityHigh = 85
let gas_moderate = 300
let temp_moderate = 31
let humidity_moderate = 71

const levelMap = {
    0: "normal",
    1: "moderate",
    2: "high"
};
let Alerts = [];
let gasCard;
let gasLevel;
let tempCard;
let tempLevel;
let humidityCard;
let humidityLevel;
let deviceCard;

function initializeDashboardElements() {
    gasCard = document.getElementById('gas-card');
    gasLevel = document.getElementById('gas-level');

    tempCard = document.getElementById('temp-card');
    tempLevel = document.getElementById('temp-level');

    humidityCard = document.getElementById('humidity-card');
    humidityLevel = document.getElementById('humidity-level');

    deviceCard = document.getElementById('deviceCard');
}

function setLevel(div, levelText, sensor_val, high, moderate, alertType) {
    if (!div || !levelText) return;

    // Remove old classes
    div.classList.remove('normal', 'moderate', 'high');

    let i = 0;
    if (sensor_val >= high) i = 2;
    else if (sensor_val >= moderate) i = 1;

    const levelClass = levelMap[i];
    levelText.textContent = levelClass;
    div.classList.add(levelClass);

    // Also apply class to icon inside the card (if present)
    const icon = div.querySelector('.icon svg');
    if (icon) {
        icon.classList.remove('normal', 'moderate', 'high');
        icon.classList.add(levelClass);
    }
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

function fetchDevice() {
    fetch('/api/devices/1')
        .then(response => response.json())
        .then(data => {
            gasHigh = data.device.gas_threshold;
            gas_moderate = data.device.gas_mod_threshold;
            tempHigh = data.device.temperature_threshold;
            temp_moderate = data.device.temperature_mod_threshold
            humidityHigh = data.device.humidity_threshold;
            humidity_moderate = data.device.humidity_mod_threshold;
            document.getElementById('gas-threshold').textContent = gasHigh;
            document.getElementById('temp-threshold').textContent = tempHigh;
            document.getElementById('humidity-threshold').textContent = humidityHigh;
        });
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


            setLevel(gasCard, gasLevel, data.gas_value, gasHigh, gas_moderate, 'gas');
            setLevel(tempCard, tempLevel, data.temperature, tempHigh, temp_moderate, 'temperature');
            setLevel(humidityCard, humidityLevel, data.humidity, humidityHigh, humidity_moderate, 'humidity');
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
            Alerts.forEach(alert => { if (alert.status == 'active') activeAlert++; })
            document.getElementById('active-alerts').textContent = `${activeAlert}`;
            displayAlerts();

        });
}

function displayAlerts() {
    const container = document.getElementById('alert-container');
    if (!container) return;

    container.innerHTML = '';

    Alerts.forEach(alert => {
        const severityClass = alert.severity.toLowerCase();

        const alertElement = document.createElement('div');
        alertElement.innerHTML = `
            <div class="alert ${alert.status === 'active' ? 'alert-active' : 'alert-resolved'}"
                 style="display:flex; flex-direction:row; align-items:center; justify-content:space-between; border-radius:5px">
                 
                <div class="icon ${severityClass}">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                         viewBox="0 0 24 24" fill="none" stroke="currentColor"
                         stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                         class="lucide lucide-triangle-alert">
                        <path d="m21.73 18-8-14a2 2 0 0 0-3.48 0l-8 14A2 2 0 0 0 4 21h16a2 2 0 0 0 1.73-3"></path>
                        <path d="M12 9v4"></path>
                        <path d="M12 17h.01"></path>
                    </svg>
                </div>

                <strong>${alert.severity.toUpperCase()}</strong>
                <span>Gas Level exceeded threshold</span>
                <span class="status">${alert.status}</span>
                <span>${new Date(alert.status === 'active' ? alert.triggered_at : alert.resolved_at)
                    .toLocaleTimeString([], { hour: '2-digit', minute: '2-digit', hour12: true, timeZone: 'Asia/Kolkata' })}</span>
            </div>
        `;

        container.appendChild(alertElement);
    });
}

let deviceInterval;
let readingInterval;
let alertInterval;

function startDashboard() {
    initializeDashboardElements();
    fetchDevice();
    fetchLatestData();
    fetchRecentAlerts();

    deviceInterval = setInterval(fetchDevice, 5000);
    readingInterval = setInterval(fetchLatestData, 2000);
    alertInterval = setInterval(fetchRecentAlerts, 3000);
}

function stopDashboard() {

    clearInterval(deviceInterval);
    clearInterval(readingInterval);
    clearInterval(alertInterval);
}



document.addEventListener('livewire:navigated', () => {

    stopDashboard();

    const page = document.querySelector('[data-page]')?.dataset.page;

    if (page === 'dashboard') {

        // lucide.createIcons();

        startDashboard();
    }
});
