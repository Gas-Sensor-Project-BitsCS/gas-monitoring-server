import './echo';
import { initDashboard } from './dashboard';

// 1. Initial Load & Lucide Icons
document.addEventListener('DOMContentLoaded', () => {
    if (typeof lucide !== 'undefined') {
        lucide.createIcons();
    }
});

// 2. Combined Livewire Navigation Hook
document.addEventListener('livewire:navigated', () => {
    // Re-initialize Lucide icons on page swap
    if (typeof lucide !== 'undefined') {
        lucide.createIcons();
    }

    // Check which page was navigated to
    const page = document.querySelector('[data-page]')?.dataset.page;
    if (page === 'dashboard') {
        initDashboard();
    }
});

// 3. Livewire Component Morph Hook for Dynamic DOM Updates
document.addEventListener('livewire:initialized', () => {
    Livewire.hook('morph.updated', ({ el, component }) => {
        if (typeof lucide !== 'undefined') {
            lucide.createIcons();
        }
    });
});

// 4. Reverb Private Channel Subscription
if (window.Echo) {
    window.Echo.private('gas-monitoring')
        .subscribed(() => {
            console.log('Successfully subscribed to gas-monitoring channel');
        })
        .listen('.sensor.reading.received', (event) => {
            console.log('Broadcast received via Reverb:', event);
            
            if (typeof window.updateDashboardFromReading === 'function') {
                window.updateDashboardFromReading(event.reading);
            }
            if (typeof window.appendLiveSensorReading === 'function') {
                window.appendLiveSensorReading(event.reading);
            }
        })
        .error((error) => {
            console.error('Private channel subscription failed:', error);
        });
}

document.addEventListener('livewire:initialized', () => {
    // Re-run Lucide icons after any component update, render, or morph
    Livewire.hook('morph.removed', ({ el, component }) => {
        // Optional cleanup if needed
    });

    Livewire.hook('commit', ({ component, succeed, fail, respond }) => {
        succeed(({ snapshot, effect }) => {
            queueMicrotask(() => {
                if (typeof lucide !== 'undefined') {
                    lucide.createIcons();
                }
            });
        });
    });
});