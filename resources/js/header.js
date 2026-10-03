function initHeader() {
    const app = document.getElementById('app');
    const sidebar = document.getElementById('sidebar');

    const menuBtn = document.getElementById("menu");
    if (menuBtn && !menuBtn.dataset.bound) {
        menuBtn.addEventListener('click', () => {
            app.classList.toggle('hidden');
            sidebar.classList.toggle('display-none');
        });
        menuBtn.dataset.bound = "true"; // prevent duplicate binding
    }

    const toggleBtn = document.getElementById("theme");
    if (toggleBtn && !toggleBtn.dataset.bound) {
        toggleBtn.addEventListener("click", () => {
            document.body.classList.toggle("light");
        });
        toggleBtn.dataset.bound = "true";
    }
}

function initClock() {
    function updateClock() {
        const now = new Date();
        const day = now.getDate();
        const monthNames = ["Jan","Feb","Mar","Apr","May","Jun",
                            "Jul","Aug","Sep","Oct","Nov","Dec"];
        const month = monthNames[now.getMonth()];
        const year = now.getFullYear();
        let hours = now.getHours();
        const minutes = now.getMinutes().toString().padStart(2, '0');
        const ampm = hours >= 12 ? 'PM' : 'AM';
        hours = hours % 12 || 12;

        const formatted = `${day} ${month} ${year}, ${hours}:${minutes} ${ampm}`;
        const clockEl = document.getElementById('clock');
        if (clockEl) clockEl.textContent = formatted;
    }

    updateClock();
    setInterval(updateClock, 15000);
}

// Run once on page load
document.addEventListener('DOMContentLoaded', () => {
    initHeader();
    initClock();
});

// Run again after Livewire navigation
document.addEventListener('livewire:navigated', () => {
    initHeader();
    initClock();
});

