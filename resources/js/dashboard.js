// Dashboard.js
window.selectedDeviceId = 1;

let gasHigh = 500;
let tempHigh = 40;
let humidityHigh = 85;
let gas_moderate = 300;
let temp_moderate = 31;
let humidity_moderate = 71;

const levelMap = {
    0: "normal",
    1: "moderate",
    2: "high"
};
let Alerts = [];
let gasCard, gasLevel, tempCard, tempLevel, humidityCard, humidityLevel, deviceCard;

function initializeDashboardElements() {
    gasCard = document.getElementById('gas-card');
    gasLevel = document.getElementById('gas-level');
    tempCard = document.getElementById('temp-card');
    tempLevel = document.getElementById('temp-level');
    humidityCard = document.getElementById('humidity-card');
    humidityLevel = document.getElementById('humidity-level');
    deviceCard = document.getElementById('deviceCard');
}

function updateDeviceHeaderInfo(deviceName, deviceLocation) {
    // Re-verify elements in case of Livewire DOM morph changes
    const nameElem = document.getElementById('name');
    const locationElem = document.getElementById('location');

    if (nameElem && deviceName) {
        nameElem.textContent = deviceName;
    }

    if (locationElem && deviceLocation) {
        locationElem.textContent = deviceLocation;
    }
}

function setLevel(div, levelText, sensor_val, high, moderate) {
    // Re-bind references if they were lost during Livewire navigation morphing
    if (!gasCard) initializeDashboardElements();

    if (!div || !levelText) return;
    div.classList.remove('normal', 'moderate', 'high');

    let i = 0;
    if (sensor_val >= high) i = 2;
    else if (sensor_val >= moderate) i = 1;

    const levelClass = levelMap[i];
    levelText.textContent = levelClass;
    div.classList.add(levelClass);
}

function isOnline(timeStamp, threshold) {
    if (!deviceCard) return;
    const statusText = document.getElementById('device-status');
    if (!statusText) return;

    const diff = (Date.now() - new Date(timeStamp).getTime()) / 1000;
    if (!Number.isFinite(diff)) return;

    const isDeviceOnline = diff <= threshold;
    deviceCard.classList.remove('online', 'offline');
    statusText.textContent = isDeviceOnline ? 'Online' : 'Offline';
    deviceCard.classList.add(isDeviceOnline ? 'online' : 'offline');
}

async function fetchDevice() {
    if (!selectedDeviceId) return;
    const requestedDeviceId = selectedDeviceId;

    try {
        const response = await fetch(`/api/devices/${requestedDeviceId}`);
        if (!response.ok) throw new Error('Failed to fetch device');

        const data = await response.json();
        if (requestedDeviceId !== selectedDeviceId) return;

        gasHigh = Number(data.device.gas_threshold);
        gas_moderate = Number(data.device.gas_mod_threshold);
        tempHigh = Number(data.device.temperature_threshold);
        temp_moderate = Number(data.device.temperature_mod_threshold);
        humidityHigh = Number(data.device.humidity_threshold);
        humidity_moderate = Number(data.device.humidity_mod_threshold);

        const gasThresh = document.getElementById('gas-threshold');
        const tempThresh = document.getElementById('temp-threshold');
        const humThresh = document.getElementById('humidity-threshold');

        if (gasThresh) gasThresh.textContent = gasHigh;
        if (tempThresh) tempThresh.textContent = tempHigh;
        if (humThresh) humThresh.textContent = humidityHigh;

        // 2. Safely update device name and location from the API response
        updateDeviceHeaderInfo(data.device.name, data.device.location);

    } catch (error) {
        console.error('Device fetch error:', error);
    }
}

window.updateDashboardFromReading = function(data) {
    if (!data || data.gas_value === undefined) return;
    if (Number(data.device_id) !== Number(selectedDeviceId)) return;

    const gasElem = document.getElementById('gas_value');
    const tempElem = document.getElementById('temperature');
    const humElem = document.getElementById('humidity');

    if (gasElem) gasElem.textContent = Number(data.gas_value).toFixed(1);
    if (tempElem) tempElem.textContent = Number(data.temperature).toFixed(1);
    if (humElem) humElem.textContent = Number(data.humidity).toFixed(1);

    setLevel(gasCard, gasLevel, data.gas_value, gasHigh, gas_moderate);
    setLevel(tempCard, tempLevel, data.temperature, tempHigh, temp_moderate);
    setLevel(humidityCard, humidityLevel, data.humidity, humidityHigh, humidity_moderate);
    
    isOnline(data.recorded_at || new Date().toISOString(), 15);
};

window.resetDashboardToEmpty = function() {
    // 1. Reset numerical text displays
    const gasElem = document.getElementById('gas_value');
    const tempElem = document.getElementById('temperature');
    const humElem = document.getElementById('humidity');

    if (gasElem) gasElem.textContent = '--';
    if (tempElem) tempElem.textContent = '--';
    if (humElem) humElem.textContent = '--';

    // 2. Reset card thresholds / background status colors
    if (typeof setLevel === 'function' && gasCard && gasLevel) {
        setLevel(gasCard, gasLevel, 0, gasHigh, gas_moderate);
        setLevel(tempCard, tempLevel, 0, tempHigh, temp_moderate);
        setLevel(humidityCard, humidityLevel, 0, humidityHigh, humidity_moderate);
    }
    
    // 3. Mark device status as offline
    if (typeof isOnline === 'function') {
        isOnline(new Date(0).toISOString(), 15);
    }

    // 4. Safely flush Chart.js instance datasets if defined
    let activeChart = typeof myChart !== 'undefined' ? myChart : Chart.getChart('myChart');
    if (activeChart) {
        activeChart.data.labels = [];
        activeChart.data.datasets.forEach(dataset => {
            dataset.data = [];
        });
        activeChart.update('none');
    }
};

function fetchRecentAlerts() {
    fetch('/api/alerts')
        .then(response => response.json())
        .then(data => {
            if (!data || data.alerts === undefined) return;
            Alerts = data.alerts.data;
            let activeAlert = 0;
            Alerts.forEach(alert => { if (alert.status === 'active') activeAlert++; });
            const activeAlertsElem = document.getElementById('active-alerts');
            if (activeAlertsElem) activeAlertsElem.textContent = `${activeAlert}`;
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
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-triangle-alert">
                        <path d="m21.73 18-8-14a2 2 0 0 0-3.48 0l-8 14A2 2 0 0 0 4 21h16a2 2 0 0 0 1.73-3"></path>
                        <path d="M12 9v4"></path>
                        <path d="M12 17h.01"></path>
                    </svg>
                </div>
                <strong>${alert.severity.toUpperCase()}</strong>
                <span>Gas Level exceeded threshold</span>
                <span class="status">${alert.status}</span>
                <span>${new Date(alert.status === 'active' ? alert.triggered_at : alert.resolved_at).toLocaleTimeString([], { hour: '2-digit', minute: '2-digit', hour12: true, timeZone: 'Asia/Kolkata' })}</span>
            </div>
        `;
        container.appendChild(alertElement);
    });
}

export async function fetchLatestData() {
    if (!selectedDeviceId) return;
    try {
        const response = await fetch(`/api/sensor-readings/latest?device_id=${selectedDeviceId}`);
        if (!response.ok) throw new Error('Failed to fetch readings');
        const data = await response.json();

        if (data.device_id && Number(data.device_id) !== Number(selectedDeviceId)) return;

        if (!data || Object.keys(data).length === 0 || data.error) {
            window.resetDashboardToEmpty();
            return;
        }

        window.updateDashboardFromReading(data);
    } catch (error) {
        console.error('Sensor reading fetch error:', error);
        window.resetDashboardToEmpty();
    }
}

export function initDashboard() {
    initializeDashboardElements();
    const selector = document.querySelector('[data-device-selector]');
    selectedDeviceId = Number(selector?.dataset.deviceId) || selectedDeviceId;

    if (!selectedDeviceId) {
        console.warn('No device selected');
        return;
    }

    fetchDevice();
    fetchLatestData();
    fetchRecentAlerts();
}

let deviceInterval;
let alertInterval;

function startDashboard() {
    initDashboard();
    deviceInterval = setInterval(fetchDevice, 5000);
    alertInterval = setInterval(fetchRecentAlerts, 3000);
}

function stopDashboard() {
    clearInterval(deviceInterval);
    clearInterval(alertInterval);
}

// Listen to device changes dispatched from Livewire view
window.addEventListener('device-changed', async (event) => {
    const detail = event.detail;
    const rawId = detail.deviceId !== undefined ? detail.deviceId : (Array.isArray(detail) ? detail[0] : detail);
    const newDeviceId = Number(rawId);

    if (!newDeviceId || newDeviceId === selectedDeviceId) return;

    selectedDeviceId = newDeviceId;
    console.log('Dashboard JS registered device change:', selectedDeviceId);

    await fetchDevice();
    await fetchLatestData();
});

function bootDashboardIfReady() {
    // Re-initialize DOM element references first
    initializeDashboardElements();
    
    const pageContainer = document.querySelector('[data-page]');
    const page = pageContainer?.dataset.page;
    
    // Check if we are on the dashboard page and elements exist
    if (page === 'dashboard' || document.getElementById('gas-card')) {
        stopDashboard();
        startDashboard();
    }
}

// 1. Run on standard initial load
document.addEventListener('DOMContentLoaded', bootDashboardIfReady);

// 2. Run immediately when Livewire starts navigating (or finishes navigating)
document.addEventListener('livewire:navigated', () => {
    // Small timeout allows Livewire 4 to finish rendering the new page DOM into the body
    setTimeout(bootDashboardIfReady, 50);
});