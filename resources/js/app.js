//
document.addEventListener('DOMContentLoaded', () => {
    lucide.createIcons();
});

document.addEventListener('livewire:init', () => {
    Livewire.hook('morph.updated', () => {
        lucide.createIcons();
    });
});

document.addEventListener('livewire:navigated', () => {
    lucide.createIcons();
});


document.addEventListener("livewire:update", () => {
    lucide.createIcons();
});