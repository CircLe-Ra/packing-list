import './bootstrap';
import '../../vendor/masmerise/livewire-toaster/resources/js';

function toggleTheme() {
    const savedTheme = localStorage.getItem('theme') || 'light';
    if (savedTheme) {
        document.querySelector(`input[value="${savedTheme}"]`).checked = true;
    }
    const theme = document.querySelectorAll('.theme-controller');
    theme.forEach((theme) => {
        theme.addEventListener('change', function () {
            const selectedTheme = this.value;
            document.documentElement.setAttribute('data-theme', selectedTheme);
            localStorage.setItem('theme', selectedTheme); // Simpan tema ke localStorage
        });
    });
}
toggleTheme();
document.addEventListener('livewire:navigated', function() {
    toggleTheme();
});



