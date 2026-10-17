// app.js
import './echo';
import { initDashboard } from './dashboard';

document.addEventListener('DOMContentLoaded', () => {
    lucide.createIcons();
});

// Handle Livewire Navigation DOM updates
document.addEventListener('livewire:navigated', () => {
    lucide.createIcons();
});

// Reverb Channel Subscription
if (window.Echo) {
    window.Echo.private('gas-monitoring')
        .subscribed(() => {
            console.log('Subscribed to gas-monitoring channel');
        })
        .listen('.sensor.reading.received', (event) => {
            console.log('Broadcast received via Reverb:', event);
            
            // Push broadcast data straight to the dashboard if function exists
            if (typeof window.updateDashboardFromReading === 'function') {
                window.updateDashboardFromReading(event.reading);
            }
        })
        .error((error) => {
            console.error('Private channel subscription failed:', error);
        });
}

// 3. Step 3 Code: Livewire SPA Navigation Hook
document.addEventListener('livewire:navigated', () => {
    // Re-initialize Lucide icons on page swap
    if (typeof lucide !== 'undefined') {
        lucide.createIcons();
    }

    // Check which page was navigated to
    const page = document.querySelector('[data-page]')?.dataset.page;

    if (page === 'dashboard') {
        // Run initial data fetch and setup for the dashboard
        initDashboard();
    }
});